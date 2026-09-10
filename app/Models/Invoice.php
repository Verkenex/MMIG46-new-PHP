<?php
declare(strict_types=1);
namespace MMIG46\Models;
use MMIG46\Core\DB;

final class Invoice
{
    public static function all(): array { return DB::pdo()->query('SELECT i.*,u.name AS creator_name FROM invoices i JOIN users u ON u.id=i.created_by ORDER BY i.invoice_date DESC,i.id DESC')->fetchAll(); }
    public static function find(int $id): ?array { $s=DB::pdo()->prepare('SELECT * FROM invoices WHERE id=?');$s->execute([$id]);return $s->fetch()?:null; }
    public static function items(int $id): array { $s=DB::pdo()->prepare('SELECT * FROM invoice_items WHERE invoice_id=? ORDER BY position_no');$s->execute([$id]);return $s->fetchAll(); }
    public static function outbox(int $id): array { $s=DB::pdo()->prepare("SELECT * FROM mail_outbox WHERE related_type='invoice' AND related_id=? ORDER BY id DESC");$s->execute([$id]);return $s->fetchAll(); }
}
