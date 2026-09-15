<?php
declare(strict_types=1);
namespace MMIG46\Controllers;
use MMIG46\Core\DB;
use MMIG46\Core\I18n;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\Invoice;
use MMIG46\Models\Member;
use MMIG46\Models\User;
use MMIG46\Services\InvoicePdf;
use MMIG46\Services\InvoiceSettings;
use MMIG46\Services\InvoiceWorkflow;
use MMIG46\Services\OutboxDelivery;

final class InvoiceController
{
    private function guard(): void { Security::requireRole(['admin']); }
    private function redirect(?int $id=null): never { header('Location:'.I18n::url($id?'/verwaltung/rechnungen/'.$id:'/verwaltung/rechnungen'));exit; }
    private function flashError(\Throwable $e,?int $id=null): never { Session::flash('error',$e->getMessage());$this->redirect($id); }

    public function index(): string { $this->guard();return View::render('admin/invoices',['invoices'=>Invoice::all(),'members'=>Member::all(),'users'=>User::all(),'settings'=>InvoiceSettings::load(),'invoice'=>null,'items'=>[],'outbox'=>[],'lang'=>I18n::current()]); }
    public function edit(string $id): string { $this->guard();$invoice=Invoice::find((int)$id);if(!$invoice){http_response_code(404);return View::render('errors/404');}return View::render('admin/invoices',['invoices'=>Invoice::all(),'members'=>Member::all(),'users'=>User::all(),'settings'=>InvoiceSettings::load(),'invoice'=>$invoice,'items'=>Invoice::items((int)$id),'outbox'=>Invoice::outbox((int)$id),'lang'=>I18n::current()]); }

    public function save(): string
    {
        $this->guard();Security::verifyCsrf();$id=max(0,(int)($_POST['invoice_id']??0))?:null;
        try{$items=$this->postedItems();$saved=InvoiceWorkflow::saveDraft($id,$_POST,$items,(int)$_SESSION['user']['id']);Session::flash('success','Rechnungsentwurf wurde gespeichert.');$this->redirect($saved);}catch(\Throwable $e){$this->flashError($e,$id);}
    }
    public function delete(string $id): string { $this->guard();Security::verifyCsrf();try{if(($_POST['confirmation']??'')!=='ENTWURF LÖSCHEN')throw new \RuntimeException('Bestätigung ENTWURF LÖSCHEN fehlt.');InvoiceWorkflow::deleteDraft((int)$id);Session::flash('success','Entwurf wurde gelöscht.');$this->redirect();}catch(\Throwable $e){$this->flashError($e,(int)$id);} }
    public function finalize(string $id): string { $this->guard();Security::verifyCsrf();try{InvoiceWorkflow::finalize((int)$id,(int)$_SESSION['user']['id'],($_POST['confirmation']??'')==='FINALISIEREN');Session::flash('success','Rechnung wurde finalisiert und unveränderlich gespeichert.');$this->redirect((int)$id);}catch(\Throwable $e){$this->flashError($e,(int)$id);} }
    public function paid(string $id): string { $this->guard();Security::verifyCsrf();try{if(($_POST['confirmation']??'')!=='BEZAHLT')throw new \RuntimeException('Bestätigung BEZAHLT fehlt.');InvoiceWorkflow::markPaid((int)$id,(int)$_SESSION['user']['id']);Session::flash('success','Zahlung wurde dokumentiert.');$this->redirect((int)$id);}catch(\Throwable $e){$this->flashError($e,(int)$id);} }
    public function cancel(string $id): string { $this->guard();Security::verifyCsrf();try{if(($_POST['confirmation']??'')!=='STORNIEREN')throw new \RuntimeException('Bestätigung STORNIEREN fehlt.');InvoiceWorkflow::cancel((int)$id,(int)$_SESSION['user']['id'],(string)($_POST['reason']??''));Session::flash('success','Rechnung wurde storniert.');$this->redirect((int)$id);}catch(\Throwable $e){$this->flashError($e,(int)$id);} }
    public function send(string $id): string { $this->guard();Security::verifyCsrf();try{$invoice=Invoice::find((int)$id);if(!$invoice||($_POST['recipient_confirmation']??'')!==$invoice['recipient_email'])throw new \RuntimeException('Empfängeradresse wurde nicht korrekt bestätigt.');$outboxId=InvoiceWorkflow::queueEmail((int)$id,(int)$_SESSION['user']['id']);$sent=OutboxDelivery::deliver($outboxId);Session::flash($sent?'success':'error',$sent?'Rechnung wurde versendet.':'Versand fehlgeschlagen und kann erneut versucht werden.');$this->redirect((int)$id);}catch(\Throwable $e){$this->flashError($e,(int)$id);} }
    public function retry(string $id): string { $this->guard();Security::verifyCsrf();$invoiceId=(int)($_POST['invoice_id']??0);try{$s=DB::pdo()->prepare("SELECT id FROM mail_outbox WHERE id=? AND message_type='invoice_mail' AND related_type='invoice' AND related_id=?");$s->execute([(int)$id,$invoiceId]);if(!$s->fetchColumn())throw new \RuntimeException('Versanddatensatz nicht gefunden.');$sent=OutboxDelivery::deliver((int)$id);Session::flash($sent?'success':'error',$sent?'E-Mail wurde versendet.':'Versand ist erneut fehlgeschlagen.');$this->redirect($invoiceId);}catch(\Throwable $e){$this->flashError($e,$invoiceId);} }

    public function preview(string $id): string
    {
        $this->guard();$invoice=Invoice::find((int)$id);if(!$invoice){http_response_code(404);return '';}
        if($invoice['status']!=='draft')return $this->download($id);
        $pdf=InvoicePdf::render($invoice,Invoice::items((int)$id),InvoiceSettings::load(),true);header('Content-Type: application/pdf');header('Content-Disposition: inline; filename="Entwurf-'.(int)$id.'.pdf"');header('Cache-Control: private, no-store');return $pdf;
    }
    public function download(string $id): string
    {
        $this->guard();$invoice=Invoice::find((int)$id);if(!$invoice||$invoice['status']==='draft'){http_response_code(404);return '';}
        try{$cancelled=$invoice['status']==='cancelled';$path=InvoiceWorkflow::pdfPath($invoice,$cancelled);header('Content-Type: application/pdf');header('Content-Disposition: inline; filename="'.($cancelled?'Storno-':'').preg_replace('/[^A-Za-z0-9._-]/','_',((string)$invoice['invoice_number'])).'.pdf"');header('Cache-Control: private, no-store');$data=file_get_contents($path);if($data===false)throw new \RuntimeException('PDF konnte nicht gelesen werden.');return $data;}catch(\Throwable $e){http_response_code(500);return Security::e($e->getMessage());}
    }
    public function downloadOriginal(string $id): string
    {
        $this->guard();$invoice=Invoice::find((int)$id);if(!$invoice||$invoice['status']==='draft'){http_response_code(404);return '';}
        try{$path=InvoiceWorkflow::pdfPath($invoice,false);header('Content-Type: application/pdf');header('Content-Disposition: inline; filename="Original-'.preg_replace('/[^A-Za-z0-9._-]/','_',((string)$invoice['invoice_number'])).'.pdf"');header('Cache-Control: private, no-store');$data=file_get_contents($path);return $data===false?'':$data;}catch(\Throwable $e){http_response_code(500);return Security::e($e->getMessage());}
    }

    public function saveSettings(): string
    {
        $this->guard();Security::verifyCsrf();$keys=array_keys(InvoiceSettings::load());$pdo=DB::pdo();$pdo->beginTransaction();
        try{$s=$pdo->prepare('INSERT INTO site_settings(setting_key,setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)');foreach($keys as $key){$value=trim((string)($_POST[$key]??''));if(mb_strlen($value)>500)throw new \RuntimeException('Einstellung ist zu lang: '.$key);$s->execute([$key,$value]);}$pdo->commit();Session::flash('success','Rechnungseinstellungen wurden gespeichert.');$this->redirect();}catch(\Throwable $e){if($pdo->inTransaction())$pdo->rollBack();$this->flashError($e);}
    }

    private function postedItems(): array
    {
        $fields=['description','quantity','unit','unit_price','tax_rate'];$arrays=[];foreach($fields as $field){$arrays[$field]=$_POST['items'][$field]??[];if(!is_array($arrays[$field]))throw new \InvalidArgumentException('Ungültige Positionsdaten.');}
        $count=count($arrays['description']);$items=[];for($i=0;$i<$count;$i++)$items[]=['description'=>$arrays['description'][$i]??'','quantity'=>$arrays['quantity'][$i]??'','unit'=>$arrays['unit'][$i]??'','unit_price'=>$arrays['unit_price'][$i]??'','tax_rate'=>$arrays['tax_rate'][$i]??''];return $items;
    }
}
