<?php

declare(strict_types=1);

namespace MMIG46\Services;

use MMIG46\Core\Env;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    public static function contact(string $name, string $email, string $message): bool
    {
        $subject = 'Neue Kontaktanfrage über MMIG46';

        $rows = [
            'Name' => $name,
            'E-Mail' => $email,
            'Nachricht' => nl2br(self::e($message)),
            'IP-Adresse' => $_SERVER['REMOTE_ADDR'] ?? 'unbekannt',
            'Zeitpunkt' => date('d.m.Y H:i:s'),
        ];

        $html = self::htmlMail(
            'Neue Kontaktanfrage',
            'Über das Kontaktformular der MMIG46-Website wurde eine neue Anfrage gesendet.',
            [
                'Kontaktangaben' => $rows,
            ]
        );

        $text = self::textBlock('Neue Kontaktanfrage über die MMIG46-Website', [
            'Name' => $name,
            'E-Mail' => $email,
            'Nachricht' => $message,
            'IP-Adresse' => $_SERVER['REMOTE_ADDR'] ?? 'unbekannt',
            'Zeitpunkt' => date('d.m.Y H:i:s'),
        ]);

        return self::send(
            Env::get('CONTACT_TO', Env::get('MAIL_FROM', '')),
            $subject,
            $html,
            $text,
            $email,
            $name
        );
    }

    public static function membershipApplication(array $data): bool
    {
        $name = trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''));
        $subject = 'Neuer MMIG46-Mitgliedsantrag: ' . ($name !== '' ? $name : 'ohne Namen');

        $html = self::membershipHtml($data, false);
        $text = self::membershipText($data, false);

        return self::send(
            Env::get('CONTACT_TO', Env::get('MAIL_FROM', '')),
            $subject,
            $html,
            $text,
            $data['private_email'] ?? null,
            $name ?: null
        );
    }

    public static function membershipCopy(array $data): bool
    {
        $to = trim((string)($data['private_email'] ?? ''));

        if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Invalid private_email for membership copy.');
        }

        $subject = 'Kopie Ihres MMIG46-Mitgliedsantrags';

        return self::send(
            $to,
            $subject,
            self::membershipHtml($data, true),
            self::membershipText($data, true)
        );
    }

    public static function send(
        string $to,
        string $subject,
        string $htmlBody,
        ?string $textBody = null,
        ?string $replyToEmail = null,
        ?string $replyToName = null
    ): bool {
        $driver = strtolower(trim(Env::get('MAIL_DRIVER', 'mail')));

        if ($driver === 'smtp') {
            return self::sendViaSmtp($to, $subject, $htmlBody, $textBody, $replyToEmail, $replyToName);
        }

        return self::sendViaPhpMail($to, $subject, $htmlBody, $textBody, $replyToEmail, $replyToName);
    }

    private static function sendViaSmtp(
        string $to,
        string $subject,
        string $htmlBody,
        ?string $textBody,
        ?string $replyToEmail,
        ?string $replyToName
    ): bool {
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();

            $mail->Host = Env::get('MAIL_HOST', '');
            $mail->SMTPAuth = true;
            $mail->Username = Env::get('MAIL_USERNAME', '');
            $mail->Password = Env::get('MAIL_PASSWORD', '');

            $encryption = strtolower(trim(Env::get('MAIL_ENCRYPTION', 'ssl')));

            if ($encryption === 'ssl' || $encryption === 'smtps') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($encryption === 'tls' || $encryption === 'starttls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = false;
            }

            $mail->Port = (int) Env::get('MAIL_PORT', '465');

            $from = Env::get('MAIL_FROM', '');
            $fromName = Env::get('MAIL_FROM_NAME', 'MMIG46 e.V.');

            if ($from === '') {
                throw new \RuntimeException('MAIL_FROM is not configured.');
            }

            $mail->setFrom($from, $fromName);

            foreach (self::parseRecipients($to) as $recipient) {
                $mail->addAddress($recipient);
            }

            if ($replyToEmail && filter_var($replyToEmail, FILTER_VALIDATE_EMAIL)) {
                $mail->addReplyTo($replyToEmail, $replyToName ?: $replyToEmail);
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody ?: strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody));

            return $mail->send();
        } catch (PHPMailerException $e) {
            throw new \RuntimeException('PHPMailer error: ' . $e->getMessage(), 0, $e);
        }
    }

    private static function sendViaPhpMail(
        string $to,
        string $subject,
        string $htmlBody,
        ?string $textBody,
        ?string $replyToEmail,
        ?string $replyToName
    ): bool {
        $from = Env::get('MAIL_FROM', 'no-reply@mmig46.org');
        $fromName = Env::get('MAIL_FROM_NAME', 'MMIG46 e.V.');

        $headers = [];
        $headers[] = 'From: ' . self::encodeHeader($fromName) . ' <' . $from . '>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';

        if ($replyToEmail && filter_var($replyToEmail, FILTER_VALIDATE_EMAIL)) {
            $headers[] = 'Reply-To: ' . self::encodeHeader($replyToName ?: $replyToEmail) . ' <' . $replyToEmail . '>';
        }

        return mail(
            implode(',', self::parseRecipients($to)),
            self::encodeHeader($subject),
            $htmlBody,
            implode("\r\n", $headers)
        );
    }

    private static function membershipHtml(array $data, bool $isCopy): string
    {
        $intro = $isCopy
            ? 'Vielen Dank für Ihren Mitgliedsantrag bei MMIG46 e.V. Nachfolgend erhalten Sie eine Kopie Ihrer übermittelten Angaben.'
            : 'Über die MMIG46-Website wurde ein neuer Mitgliedsantrag übermittelt.';

        return self::htmlMail(
            $isCopy ? 'Kopie Ihres Mitgliedsantrags' : 'Neuer Mitgliedsantrag',
            $intro,
            [
                'Mitgliedschaft und Rechnung' => [
                    'Mitgliedschaft' => self::labelMembershipType($data['membership_type'] ?? ''),
                    'Rechnungsempfänger' => $data['invoice_name'] ?? '',
                    'Straße' => $data['street'] ?? '',
                    'PLZ / Ort / Land' => $data['postal_city_country'] ?? '',
                ],
                'Persönliche Daten' => [
                    'Vorname' => $data['first_name'] ?? '',
                    'Nachname' => $data['last_name'] ?? '',
                    'Geburtsdatum' => $data['birthday'] ?? '',
                    'Beruf' => $data['occupation'] ?? '',
                    'Copilot / Ehepartner' => $data['copilot_spouse'] ?? '',
                ],
                'Flugerfahrung' => [
                    'Gesamtflugzeit' => $data['total_time'] ?? '',
                    'Zeit auf Muster' => $data['time_in_type'] ?? '',
                    'Lizenz / Ratings' => $data['license_ratings'] ?? '',
                    'Fliegt seit' => $data['flying_since'] ?? '',
                    'Aviation History' => $data['aviation_history'] ?? '',
                ],
                'Flugzeug' => [
                    'Eingetragener Halter' => $data['registered_owner'] ?? '',
                    'Rufzeichen' => $data['callsign'] ?? '',
                    'Modell' => $data['model'] ?? '',
                    'Seriennummer' => $data['serial_number'] ?? '',
                    'Baujahr' => $data['aircraft_year'] ?? '',
                    'Modifikationen' => $data['modifications'] ?? '',
                    'Homebase' => $data['home_base'] ?? '',
                ],
                'Kontakt' => [
                    'Telefon Büro' => $data['office_phone'] ?? '',
                    'E-Mail Büro' => $data['office_email'] ?? '',
                    'Telefon privat' => $data['home_phone'] ?? '',
                    'E-Mail privat' => $data['private_email'] ?? '',
                    'Mobil' => $data['mobile'] ?? '',
                ],
                'Einwilligung und Technik' => [
                    'Einwilligung' => (($data['consent'] ?? '') === 'yes') ? 'Ja' : 'Nein',
                    'IP-Adresse' => $_SERVER['REMOTE_ADDR'] ?? 'unbekannt',
                    'Zeitpunkt' => date('d.m.Y H:i:s'),
                ],
            ]
        );
    }

    private static function membershipText(array $data, bool $isCopy): string
    {
        $lines = [];

        $lines[] = $isCopy ? 'Kopie Ihres MMIG46-Mitgliedsantrags' : 'Neuer MMIG46-Mitgliedsantrag';
        $lines[] = str_repeat('=', 42);
        $lines[] = '';

        $sections = [
            'Mitgliedschaft und Rechnung' => [
                'Mitgliedschaft' => self::labelMembershipType($data['membership_type'] ?? ''),
                'Rechnungsempfänger' => $data['invoice_name'] ?? '',
                'Straße' => $data['street'] ?? '',
                'PLZ / Ort / Land' => $data['postal_city_country'] ?? '',
            ],
            'Persönliche Daten' => [
                'Vorname' => $data['first_name'] ?? '',
                'Nachname' => $data['last_name'] ?? '',
                'Geburtsdatum' => $data['birthday'] ?? '',
                'Beruf' => $data['occupation'] ?? '',
                'Copilot / Ehepartner' => $data['copilot_spouse'] ?? '',
            ],
            'Flugerfahrung' => [
                'Gesamtflugzeit' => $data['total_time'] ?? '',
                'Zeit auf Muster' => $data['time_in_type'] ?? '',
                'Lizenz / Ratings' => $data['license_ratings'] ?? '',
                'Fliegt seit' => $data['flying_since'] ?? '',
                'Aviation History' => $data['aviation_history'] ?? '',
            ],
            'Flugzeug' => [
                'Eingetragener Halter' => $data['registered_owner'] ?? '',
                'Rufzeichen' => $data['callsign'] ?? '',
                'Modell' => $data['model'] ?? '',
                'Seriennummer' => $data['serial_number'] ?? '',
                'Baujahr' => $data['aircraft_year'] ?? '',
                'Modifikationen' => $data['modifications'] ?? '',
                'Homebase' => $data['home_base'] ?? '',
            ],
            'Kontakt' => [
                'Telefon Büro' => $data['office_phone'] ?? '',
                'E-Mail Büro' => $data['office_email'] ?? '',
                'Telefon privat' => $data['home_phone'] ?? '',
                'E-Mail privat' => $data['private_email'] ?? '',
                'Mobil' => $data['mobile'] ?? '',
            ],
            'Einwilligung und Technik' => [
                'Einwilligung' => (($data['consent'] ?? '') === 'yes') ? 'Ja' : 'Nein',
                'IP-Adresse' => $_SERVER['REMOTE_ADDR'] ?? 'unbekannt',
                'Zeitpunkt' => date('d.m.Y H:i:s'),
            ],
        ];

        foreach ($sections as $title => $rows) {
            $lines[] = $title;
            $lines[] = str_repeat('-', mb_strlen($title));

            foreach ($rows as $label => $value) {
                $lines[] = $label . ': ' . self::plain((string)$value);
            }

            $lines[] = '';
        }

        return implode("\n", $lines);
    }

    private static function htmlMail(string $title, string $intro, array $sections): string
    {
        $sectionHtml = '';

        foreach ($sections as $sectionTitle => $rows) {
            $sectionHtml .= '
                <h2 style="font-size:18px;line-height:1.35;margin:28px 0 12px;color:#0b254a;">' . self::e($sectionTitle) . '</h2>
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;border:1px solid #e4ded4;border-radius:12px;overflow:hidden;">';

            foreach ($rows as $label => $value) {
                $display = (string)$value;

                if ($display === '') {
                    $display = '—';
                }

                $sectionHtml .= '
                    <tr>
                        <td style="width:38%;padding:12px 14px;border-bottom:1px solid #eee7dc;background:#faf8f4;color:#5b6475;font-size:14px;font-weight:700;vertical-align:top;">' . self::e($label) . '</td>
                        <td style="padding:12px 14px;border-bottom:1px solid #eee7dc;color:#162033;font-size:15px;line-height:1.45;vertical-align:top;">' . self::safeHtmlValue($display) . '</td>
                    </tr>';
            }

            $sectionHtml .= '</table>';
        }

        return '<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>' . self::e($title) . '</title>
</head>
<body style="margin:0;padding:0;background:#f6f2ec;font-family:Arial,Helvetica,sans-serif;color:#162033;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
        ' . self::e($intro) . '
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f6f2ec;padding:24px 0;">
        <tr>
            <td align="center" style="padding:0 12px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:680px;background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e4ded4;">
                    <tr>
                        <td style="padding:28px 28px 22px;background:#0b254a;color:#ffffff;">
                            <div style="font-size:14px;letter-spacing:0.12em;text-transform:uppercase;font-weight:700;color:#d7b98e;margin-bottom:8px;">MMIG46 e.V.</div>
                            <h1 style="margin:0;font-size:28px;line-height:1.2;color:#ffffff;">' . self::e($title) . '</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:26px 28px;">
                            <p style="margin:0 0 18px;color:#4f5d73;font-size:16px;line-height:1.55;">' . self::e($intro) . '</p>
                            ' . $sectionHtml . '
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:18px 28px;background:#faf8f4;color:#6b7280;font-size:13px;line-height:1.5;border-top:1px solid #e4ded4;">
                            Diese E-Mail wurde automatisch von der MMIG46-Website erzeugt.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    }

    private static function parseRecipients(string $to): array
    {
        $recipients = [];

        foreach (explode(',', $to) as $recipient) {
            $recipient = trim($recipient);

            if ($recipient !== '' && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                $recipients[] = $recipient;
            }
        }

        if ($recipients === []) {
            throw new \RuntimeException('No valid mail recipient configured.');
        }

        return $recipients;
    }

    private static function labelMembershipType(string $value): string
    {
        return match ($value) {
            'owner_pilot' => 'Owner Pilot',
            'pilot' => 'Pilot',
            'associate' => 'Associate Member',
            'supporting' => 'Fördermitglied',
            default => $value,
        };
    }

    private static function safeHtmlValue(string $value): string
    {
        if (str_contains($value, '<br')) {
            return $value;
        }

        return nl2br(self::e($value));
    }

    private static function textBlock(string $title, array $rows): string
    {
        $lines = [$title, str_repeat('=', mb_strlen($title)), ''];

        foreach ($rows as $label => $value) {
            $lines[] = $label . ': ' . self::plain((string)$value);
        }

        return implode("\n", $lines);
    }

    private static function encodeHeader(string $value): string
    {
        return mb_encode_mimeheader($value, 'UTF-8', 'B', "\r\n");
    }

    private static function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private static function plain(string $value): string
    {
        return trim(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $value)));
    }
}