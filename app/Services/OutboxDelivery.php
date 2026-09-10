<?php
declare(strict_types=1);
namespace MMIG46\Services;
use MMIG46\Models\MailOutbox;
use MMIG46\Core\Security;
use MMIG46\Core\DB;

final class OutboxDelivery
{
    public static function deliver(int $id): bool
    {
        $row = MailOutbox::claim($id);
        if (!$row) return true;
        try {
            $payload = json_decode((string)$row['payload_json'], true, 512, JSON_THROW_ON_ERROR);
            $type = (string)$row['message_type'];
            if ($type === 'membership_admin' || $type === 'membership_copy') {
                $data = (array)($payload['data'] ?? []);
                $copy = $type === 'membership_copy';
                $title = $copy ? ((($payload['language'] ?? 'de') === 'en') ? 'Your application was received' : 'Ihr Antrag ist eingegangen') : 'Neuer Mitgliedsantrag #' . (int)($payload['application_id'] ?? 0);
                $intro = $copy
                    ? ((($payload['language'] ?? 'de') === 'en') ? 'Your application has been saved and will be reviewed by the board. It does not yet constitute membership.' : 'Ihr Antrag wurde gespeichert und wird durch den Vorstand geprüft. Er begründet noch keine Mitgliedschaft.')
                    : 'Der Antrag und ein nicht öffentliches Pending-Mitglied wurden transaktionssicher gespeichert.';
                $rows = '';
                foreach ($data as $key => $value) {
                    if (in_array($key, ['consent'], true)) continue;
                    $rows .= '<tr><th style="text-align:left;padding:6px;border-bottom:1px solid #ddd">' . Security::e((string)$key) . '</th><td style="padding:6px;border-bottom:1px solid #ddd">' . nl2br(Security::e((string)$value)) . '</td></tr>';
                }
                $html = '<div style="font-family:Arial,sans-serif;max-width:720px"><h1>' . Security::e($title) . '</h1><p>' . Security::e($intro) . '</p><table style="border-collapse:collapse;width:100%">' . $rows . '</table></div>';
                $sent = Mailer::send((string)$row['recipient'], (string)$row['subject'], $html, strip_tags(str_replace(['</tr>','</p>'], "\n", $html)));
            } elseif ($type === 'password_link') {
                $url = (string)($payload['url'] ?? '');
                $en = ($payload['language'] ?? 'de') === 'en';
                $html = '<div style="font-family:Arial,sans-serif;max-width:620px"><h1>' . ($en ? 'Set your MMIG46 password' : 'MMIG46-Passwort festlegen') . '</h1><p>' . ($en ? 'This single-use link is valid for 24 hours:' : 'Dieser einmal verwendbare Link ist 24 Stunden gültig:') . '</p><p><a href="' . Security::e($url) . '">' . Security::e($url) . '</a></p></div>';
                $sent = Mailer::send((string)$row['recipient'], (string)$row['subject'], $html, strip_tags($html));
            } elseif ($type === 'invoice_mail') {
                $invoiceId=(int)($payload['invoice_id']??0);$invoice=\MMIG46\Models\Invoice::find($invoiceId);
                if(!$invoice||!in_array($invoice['status'],['finalized','sent','paid'],true))throw new \RuntimeException('Nur aktive finalisierte Rechnungen dürfen versendet werden.');
                $path=InvoiceWorkflow::pdfPath($invoice);$en=($payload['language']??'de')==='en';$number=(string)($payload['invoice_number']??'');
                $html='<div style="font-family:Arial,sans-serif;max-width:620px"><h1>'.($en?'Invoice ':'Rechnung ').Security::e($number).'</h1><p>'.($en?'Please find your finalized invoice attached.':'Anbei erhalten Sie Ihre finalisierte Rechnung.').'</p><p>'.($en?'Kind regards':'Mit freundlichen Grüßen').'<br>MMIG46 e.V.</p></div>';
                $sent=Mailer::send((string)$row['recipient'],(string)$row['subject'],$html,strip_tags($html),null,null,[['path'=>$path,'name'=>$number.'.pdf','mime'=>'application/pdf']]);
                if($sent)DB::pdo()->prepare("UPDATE invoices SET status=CASE WHEN status='finalized' THEN 'sent' ELSE status END,sent_by=COALESCE(sent_by,?),sent_at=COALESCE(sent_at,NOW()) WHERE id=?")->execute([(int)($payload['admin_id']??0)?:null,$invoiceId]);
            } else {
                throw new \RuntimeException('Unbekannter Outbox-Nachrichtentyp.');
            }
            MailOutbox::finish($id, $sent, $sent ? null : 'Mail-Treiber meldete Fehler.');
            return $sent;
        } catch (\Throwable $e) {
            MailOutbox::finish($id, false, $e->getMessage());
            return false;
        }
    }
}
