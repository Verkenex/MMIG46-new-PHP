<?php
declare(strict_types=1);
namespace MMIG46\Services;
use MMIG46\Models\SiteSetting;

final class InvoiceSettings
{
    public static function load(): array
    {
        $all=SiteSetting::allKeyValue(); $keys=['invoice_number_prefix','invoice_issuer_name','invoice_issuer_street','invoice_issuer_postal_code','invoice_issuer_city','invoice_issuer_country','invoice_tax_number_or_vat_id','invoice_iban','invoice_bic','invoice_bank_name','invoice_footer_note_de','invoice_footer_note_en'];
        $result=[]; foreach($keys as $key)$result[$key]=trim((string)($all[$key]??'')); return $result;
    }
    public static function validateForFinalization(array $settings): void
    {
        $required=['invoice_number_prefix'=>'Rechnungsnummer-Präfix','invoice_issuer_name'=>'Ausstellername','invoice_issuer_street'=>'Ausstellerstraße','invoice_issuer_postal_code'=>'Aussteller-PLZ','invoice_issuer_city'=>'Ausstellerort','invoice_issuer_country'=>'Ausstellerland','invoice_tax_number_or_vat_id'=>'Steuernummer oder USt-ID','invoice_iban'=>'IBAN'];
        $missing=[]; foreach($required as $key=>$label)if(trim((string)($settings[$key]??''))==='')$missing[]=$label;
        if($missing)throw new \RuntimeException('Finalisierung blockiert. Fehlende Pflichtangaben: '.implode(', ',$missing).'.');
        if(!preg_match('/^[A-Z0-9-]{1,20}$/i',(string)$settings['invoice_number_prefix']))throw new \RuntimeException('Das Rechnungsnummer-Präfix ist ungültig.');
    }
}
