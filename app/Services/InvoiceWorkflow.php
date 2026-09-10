<?php
declare(strict_types=1);
namespace MMIG46\Services;
use MMIG46\Core\DB;
use MMIG46\Models\Invoice;
use MMIG46\Models\MailOutbox;

final class InvoiceWorkflow
{
    public static function saveDraft(?int $id,array $data,array $rawItems,int $adminId): int
    {
        $invoice=self::validateData($data);$calculation=InvoiceCalculator::calculate($rawItems);$pdo=DB::pdo();$pdo->beginTransaction();
        try {
            if($id){$stmt=$pdo->prepare('SELECT status FROM invoices WHERE id=? FOR UPDATE');$stmt->execute([$id]);if($stmt->fetchColumn()!=='draft')throw new \RuntimeException('Nur Entwürfe dürfen geändert werden.');
                $pdo->prepare('UPDATE invoices SET member_id=?,user_id=?,language=?,recipient_name=?,recipient_email=?,recipient_street=?,recipient_postal_code=?,recipient_city=?,recipient_country=?,occasion=?,service_start=?,service_end=?,invoice_date=?,due_date=?,notes=?,net_cents=?,tax_cents=?,gross_cents=?,updated_by=? WHERE id=?')->execute(array_merge(self::invoiceValues($invoice,$calculation),[$adminId,$id]));
                $pdo->prepare('DELETE FROM invoice_items WHERE invoice_id=?')->execute([$id]);
            }else{$pdo->prepare("INSERT INTO invoices (member_id,user_id,status,language,recipient_name,recipient_email,recipient_street,recipient_postal_code,recipient_city,recipient_country,occasion,service_start,service_end,invoice_date,due_date,notes,net_cents,tax_cents,gross_cents,created_by,updated_by) VALUES (?,?,'draft',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")->execute(array_merge(self::invoiceValues($invoice,$calculation),[$adminId,$adminId]));$id=(int)$pdo->lastInsertId();}
            self::insertItems((int)$id,$calculation['items']);$pdo->commit();return (int)$id;
        }catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();throw $e;}
    }

    public static function deleteDraft(int $id): void
    {
        $pdo=DB::pdo();$pdo->beginTransaction();try{$s=$pdo->prepare('SELECT status FROM invoices WHERE id=? FOR UPDATE');$s->execute([$id]);if($s->fetchColumn()!=='draft')throw new \RuntimeException('Nur Entwürfe dürfen gelöscht werden.');$pdo->prepare('DELETE FROM invoices WHERE id=?')->execute([$id]);$pdo->commit();}catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();throw $e;}
    }

    public static function finalize(int $id,int $adminId,bool $confirmed): void
    {
        if(!$confirmed)throw new \InvalidArgumentException('Die Finalisierung muss ausdrücklich bestätigt werden.');
        $settings=InvoiceSettings::load();InvoiceSettings::validateForFinalization($settings);$pdo=DB::pdo();$finalPath=null;
        $pdo->beginTransaction();
        try{
            $s=$pdo->prepare('SELECT * FROM invoices WHERE id=? FOR UPDATE');$s->execute([$id]);$invoice=$s->fetch();if(!$invoice||$invoice['status']!=='draft')throw new \RuntimeException('Nur ein Entwurf kann finalisiert werden.');
            $items=Invoice::items($id);if(!$items)throw new \RuntimeException('Die Rechnung enthält keine Positionen.');
            $year=(int)substr((string)$invoice['invoice_date'],0,4);if($year<2000||$year>2100)throw new \RuntimeException('Ungültiges Rechnungsjahr.');
            $pdo->prepare('INSERT INTO invoice_number_sequences(sequence_year,next_number) VALUES (?,1) ON DUPLICATE KEY UPDATE next_number=next_number')->execute([$year]);
            $s=$pdo->prepare('SELECT next_number FROM invoice_number_sequences WHERE sequence_year=? FOR UPDATE');$s->execute([$year]);$number=(int)$s->fetchColumn();if($number<1)throw new \RuntimeException('Ungültiger Rechnungsnummernstand.');
            $prefix=strtoupper((string)$settings['invoice_number_prefix']);$invoiceNumber=sprintf('%s-%04d-%04d',$prefix,$year,$number);
            $invoice['invoice_number']=$invoiceNumber;$invoice['status']='finalized';$snapshot=['invoice'=>$invoice,'items'=>$items,'issuer'=>$settings];
            $pdf=InvoicePdf::render($invoice,$items,$settings,false);if(substr($pdf,0,4)!=='%PDF')throw new \RuntimeException('PDF-Erstellung lieferte keine gültige PDF-Datei.');
            $key=bin2hex(random_bytes(32));$directory=self::storageDirectory();if(!is_dir($directory)&&!mkdir($directory,0750,true)&&!is_dir($directory))throw new \RuntimeException('Rechnungsverzeichnis konnte nicht angelegt werden.');
            $finalPath=$directory.'/'.$key.'.pdf';$temp=$directory.'/tmp-'.$key;if(file_put_contents($temp,$pdf,LOCK_EX)!==strlen($pdf)||!rename($temp,$finalPath)){@unlink($temp);throw new \RuntimeException('Finale PDF konnte nicht atomar gespeichert werden.');}
            $now=date('Y-m-d H:i:s');$pdo->prepare("UPDATE invoices SET status='finalized',invoice_number=?,sequence_year=?,sequence_number=?,issuer_snapshot_json=?,finalized_snapshot_json=?,pdf_storage_key=?,pdf_sha256=?,finalized_by=?,finalized_at=? WHERE id=? AND status='draft'")->execute([$invoiceNumber,$year,$number,json_encode($settings,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR),json_encode($snapshot,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR),$key,hash('sha256',$pdf),$adminId,$now,$id]);
            $pdo->prepare('UPDATE invoice_number_sequences SET next_number=next_number+1 WHERE sequence_year=?')->execute([$year]);$pdo->commit();
        }catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();if($finalPath&&is_file($finalPath))@unlink($finalPath);throw $e;}
    }

    public static function cancel(int $id,int $adminId,string $reason): void
    {
        $reason=trim($reason);if($reason===''||mb_strlen($reason)>500)throw new \InvalidArgumentException('Ein Stornierungsgrund ist erforderlich.');
        $pdo=DB::pdo();$path=null;$pdo->beginTransaction();
        try{$s=$pdo->prepare('SELECT * FROM invoices WHERE id=? FOR UPDATE');$s->execute([$id]);$invoice=$s->fetch();if(!$invoice||!in_array($invoice['status'],['finalized','sent','paid'],true))throw new \RuntimeException('Diese Rechnung kann nicht storniert werden.');
            $snapshot=json_decode((string)$invoice['finalized_snapshot_json'],true,512,JSON_THROW_ON_ERROR);$frozenInvoice=(array)($snapshot['invoice']??[]);$items=(array)($snapshot['items']??[]);$issuer=(array)($snapshot['issuer']??[]);if(!$frozenInvoice||!$items||!$issuer)throw new \RuntimeException('Die unveränderliche Rechnungsmomentaufnahme ist unvollständig.');$frozenInvoice['status']='cancelled';$frozenInvoice['cancellation_reason']=$reason;$pdf=InvoicePdf::render($frozenInvoice,$items,$issuer,false);if(substr($pdf,0,4)!=='%PDF')throw new \RuntimeException('PDF-Erstellung lieferte keine gültige Storno-PDF-Datei.');
            $key=bin2hex(random_bytes(32));$directory=self::storageDirectory();if(!is_dir($directory)&&!mkdir($directory,0750,true)&&!is_dir($directory))throw new \RuntimeException('Rechnungsverzeichnis konnte nicht angelegt werden.');$path=$directory.'/'.$key.'.pdf';$temp=$directory.'/tmp-'.$key;if(file_put_contents($temp,$pdf,LOCK_EX)!==strlen($pdf)||!rename($temp,$path)){@unlink($temp);throw new \RuntimeException('Storno-PDF konnte nicht gespeichert werden.');}
            $pdo->prepare("UPDATE invoices SET status='cancelled',cancelled_by=?,cancelled_at=NOW(),cancellation_reason=?,cancellation_pdf_storage_key=?,cancellation_pdf_sha256=? WHERE id=?")->execute([$adminId,$reason,$key,hash('sha256',$pdf),$id]);$pdo->commit();
        }catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();if($path&&is_file($path))@unlink($path);throw $e;}
    }

    public static function markPaid(int $id,int $adminId): void
    {
        $s=DB::pdo()->prepare("UPDATE invoices SET status='paid',paid_by=?,paid_at=NOW() WHERE id=? AND status IN ('finalized','sent')");$s->execute([$adminId,$id]);if($s->rowCount()!==1)throw new \RuntimeException('Diese Rechnung kann nicht als bezahlt markiert werden.');
    }

    public static function queueEmail(int $id,int $adminId): int
    {
        $invoice=Invoice::find($id);if(!$invoice||!in_array($invoice['status'],['finalized','sent','paid'],true))throw new \RuntimeException('Nur finalisierte Rechnungen können versendet werden.');
        if(!filter_var($invoice['recipient_email'],FILTER_VALIDATE_EMAIL))throw new \RuntimeException('Die Empfängeradresse ist ungültig.');
        $en=$invoice['language']==='en';$payload=['invoice_id'=>$id,'admin_id'=>$adminId,'language'=>$invoice['language'],'pdf_storage_key'=>$invoice['pdf_storage_key'],'pdf_sha256'=>$invoice['pdf_sha256'],'invoice_number'=>$invoice['invoice_number'],'recipient_name'=>$invoice['recipient_name']];
        $pdo=DB::pdo();$pdo->beginTransaction();try{MailOutbox::queueInTransaction('invoice_mail',(string)$invoice['recipient_email'],$en?'Invoice '.$invoice['invoice_number'].' from MMIG46':'Rechnung '.$invoice['invoice_number'].' der MMIG46',$payload,'invoice',$id,'invoice-mail-'.$id);$s=$pdo->prepare("SELECT id FROM mail_outbox WHERE dedupe_key=?");$s->execute(['invoice-mail-'.$id]);$outboxId=(int)$s->fetchColumn();$pdo->commit();return $outboxId;}catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();throw $e;}
    }

    public static function pdfPath(array $invoice,bool $cancellation=false): string
    {
        $keyField=$cancellation?'cancellation_pdf_storage_key':'pdf_storage_key';$hashField=$cancellation?'cancellation_pdf_sha256':'pdf_sha256';$key=(string)($invoice[$keyField]??'');if(!preg_match('/^[a-f0-9]{64}$/',$key))throw new \RuntimeException('Ungültiger PDF-Speicherschlüssel.');
        $path=self::storageDirectory().'/'.$key.'.pdf';if(!is_file($path)||!hash_equals((string)$invoice[$hashField],hash_file('sha256',$path)))throw new \RuntimeException('PDF fehlt oder Integritätsprüfung ist fehlgeschlagen.');return $path;
    }

    private static function validateData(array $data): array
    {
        $fields=['recipient_name','recipient_email','recipient_street','recipient_postal_code','recipient_city','recipient_country','occasion','service_start','service_end','invoice_date','due_date'];$result=[];
        foreach($fields as $field){$result[$field]=trim((string)($data[$field]??''));if($result[$field]==='')throw new \InvalidArgumentException('Pflichtfeld fehlt: '.$field);}
        if(!filter_var($result['recipient_email'],FILTER_VALIDATE_EMAIL))throw new \InvalidArgumentException('Ungültige E-Mail-Adresse.');
        foreach(['service_start','service_end','invoice_date','due_date'] as $field){$d=\DateTimeImmutable::createFromFormat('!Y-m-d',$result[$field]);if(!$d||$d->format('Y-m-d')!==$result[$field])throw new \InvalidArgumentException('Ungültiges Datum: '.$field);}
        if($result['service_end']<$result['service_start']||$result['due_date']<$result['invoice_date'])throw new \InvalidArgumentException('Leistungsende bzw. Zahlungsziel liegt vor dem Anfangsdatum.');
        $result['language']=in_array(($data['language']??''),['de','en'],true)?$data['language']:'de';$result['member_id']=max(0,(int)($data['member_id']??0))?:null;$result['user_id']=max(0,(int)($data['user_id']??0))?:null;$result['notes']=trim((string)($data['notes']??''));if(mb_strlen($result['notes'])>5000)throw new \InvalidArgumentException('Hinweise sind zu lang.');
        foreach(['recipient_name'=>255,'recipient_email'=>190,'recipient_street'=>255,'recipient_postal_code'=>20,'recipient_city'=>150,'recipient_country'=>100,'occasion'=>255] as $field=>$max)if(mb_strlen($result[$field])>$max)throw new \InvalidArgumentException('Feld ist zu lang: '.$field);
        return $result;
    }

    private static function invoiceValues(array $i,array $c): array{return [$i['member_id'],$i['user_id'],$i['language'],$i['recipient_name'],$i['recipient_email'],$i['recipient_street'],$i['recipient_postal_code'],$i['recipient_city'],$i['recipient_country'],$i['occasion'],$i['service_start'],$i['service_end'],$i['invoice_date'],$i['due_date'],$i['notes']?:null,$c['net_cents'],$c['tax_cents'],$c['gross_cents']];}
    private static function insertItems(int $id,array $items): void{$s=DB::pdo()->prepare('INSERT INTO invoice_items(invoice_id,position_no,description,quantity_millis,unit,unit_net_cents,tax_rate_basis_points,line_net_cents,line_tax_cents,line_gross_cents) VALUES (?,?,?,?,?,?,?,?,?,?)');foreach($items as $x)$s->execute([$id,$x['position_no'],$x['description'],$x['quantity_millis'],$x['unit'],$x['unit_net_cents'],$x['tax_rate_basis_points'],$x['line_net_cents'],$x['line_tax_cents'],$x['line_gross_cents']]);}
    private static function storageDirectory(): string{return dirname(__DIR__,2).'/storage/invoices';}
}
