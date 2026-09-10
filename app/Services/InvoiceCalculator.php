<?php
declare(strict_types=1);
namespace MMIG46\Services;

final class InvoiceCalculator
{
    public static function calculate(array $items): array
    {
        if ($items === [] || count($items) > 100) throw new \InvalidArgumentException('Mindestens eine und höchstens 100 Rechnungspositionen sind erforderlich.');
        $result=[]; $net=0; $tax=0;
        foreach ($items as $index=>$item) {
            $description=trim((string)($item['description']??'')); $unit=trim((string)($item['unit']??''));
            if ($description==='' || mb_strlen($description)>500 || $unit==='' || mb_strlen($unit)>40) throw new \InvalidArgumentException('Beschreibung und Einheit jeder Position sind erforderlich.');
            $quantity=self::decimalToInt((string)($item['quantity']??''),3,'Menge');
            $unitCents=self::decimalToInt((string)($item['unit_price']??''),2,'Einzelpreis');
            $taxBps=self::decimalToInt((string)($item['tax_rate']??''),2,'Steuersatz');
            if($quantity<=0 || $unitCents<0 || $taxBps<0 || $taxBps>10000) throw new \InvalidArgumentException('Ungültige Menge, Preis- oder Steuerangabe.');
            if($unitCents!==0&&$quantity>intdiv(PHP_INT_MAX-500,$unitCents))throw new \InvalidArgumentException('Positionsbetrag ist zu groß.');
            $lineNet=intdiv($quantity*$unitCents+500,1000);
            if($taxBps!==0&&$lineNet>intdiv(PHP_INT_MAX-5000,$taxBps))throw new \InvalidArgumentException('Steuerbetrag ist zu groß.');
            $lineTax=intdiv($lineNet*$taxBps+5000,10000);
            $result[]=['position_no'=>$index+1,'description'=>$description,'quantity_millis'=>$quantity,'unit'=>$unit,'unit_net_cents'=>$unitCents,'tax_rate_basis_points'=>$taxBps,'line_net_cents'=>$lineNet,'line_tax_cents'=>$lineTax,'line_gross_cents'=>$lineNet+$lineTax];
            if($net>PHP_INT_MAX-$lineNet||$tax>PHP_INT_MAX-$lineTax)throw new \InvalidArgumentException('Rechnungssumme ist zu groß.');
            $net+=$lineNet; $tax+=$lineTax;
        }
        return ['items'=>$result,'net_cents'=>$net,'tax_cents'=>$tax,'gross_cents'=>$net+$tax];
    }

    public static function decimalToInt(string $value,int $scale,string $label): int
    {
        $value=str_replace(["\xc2\xa0",' '],'',trim($value));
        if(str_contains($value,',')) $value=str_replace(',','.',str_replace('.','',$value));
        if(!preg_match('/^\d+(?:\.\d{1,'.(int)$scale.'})?$/',$value)) throw new \InvalidArgumentException($label.' hat ein ungültiges Zahlenformat.');
        [$whole,$fraction]=array_pad(explode('.',$value,2),2,'');
        $factor=10**$scale;
        if(strlen($whole)>12) throw new \InvalidArgumentException($label.' ist zu groß.');
        return ((int)$whole*$factor)+(int)str_pad($fraction,$scale,'0');
    }
}
