{{--
    The one certificate template (A4 landscape), rendered by dompdf in
    Certificate::generatePdf(). dompdf has no flexbox or grid, so every block
    is absolutely positioned in millimetres (widths exclude borders). The
    frame, emblem, logo and watermark are files in public/assets/images/jfi,
    passed in as data URIs. Signatures are placeholders until the client's
    approved design and signature images arrive.
--}}
@php
    $player = $certificate->player;
    $event = $certificate->event;

    // Times and Helvetica are PDF core fonts (classic look, nothing embedded) but only
    // cover Windows-1252. A block whose entered text has other characters (for example
    // "Ā" in a name) switches to the embedded DejaVu Serif, a little smaller as it runs wider.
    $fitsCoreFonts = function (?string ...$texts): bool {
        $text = implode(' ', array_filter($texts));

        return mb_convert_encoding(mb_convert_encoding($text, 'Windows-1252', 'UTF-8'), 'UTF-8', 'Windows-1252') === $text;
    };
    [$titleFont, $titleScale] = $fitsCoreFonts($certificate->title) ? ['times', 1] : ['"DejaVu Serif"', 0.85];
    [$nameFont, $nameScale] = $fitsCoreFonts($player->name) ? ['times', 1] : ['"DejaVu Serif"', 0.85];
    [$citationFont, $citationScale] = $fitsCoreFonts($certificate->achievement, $event?->title, $event?->city, $event?->state) ? ['times', 1] : ['"DejaVu Serif"', 0.9];

    // "Certificate of Participation" prints as a large CERTIFICATE over a smaller OF PARTICIPATION.
    if (preg_match('/^certificate\s+((?:of|for)\s+.+)$/i', trim($certificate->title), $titleParts)) {
        [$titleMain, $titleSub] = ['Certificate', $titleParts[1]];
    } else {
        [$titleMain, $titleSub] = [$certificate->title, null];
    }
    [$titleSize, $titleSpacing, $titleTop] = match (true) {
        $titleSub !== null => [42, 8, 58],
        mb_strlen($titleMain) <= 16 => [36, 5, 62],
        mb_strlen($titleMain) <= 28 => [28, 3, 64],
        default => [20, 2, 66],
    };
    $titleSize = round($titleSize * $titleScale, 1);

    $nameSize = round($nameScale * match (true) {
        mb_strlen($player->name) <= 26 => 34,
        mb_strlen($player->name) <= 36 => 28,
        default => 22,
    }, 1);

    $eventPlace = $event ? collect([$event->city, $event->state])->filter()->unique()->join(', ') : null;
    $eventLine = $event ? collect([$eventPlace, $event->dateRange('F')])->filter()->join(', ') : null;

    // Long citations get smaller type so they never reach the signature row.
    $citationLength = mb_strlen(implode(' ', array_filter([$certificate->achievement, $event?->title, $eventLine])));
    [$citationSize, $citationLeading] = $citationLength > 110 ? [12, 1.4] : [13.5, 1.5];
    $citationSize = round($citationSize * $citationScale, 1);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>{{ $certificate->title }} - {{ $certificate->certificate_no }}</title>
<style>
    @page { margin: 0; }

    body {
        margin: 0;
        font-family: helvetica, sans-serif;
        color: #1A2238;
    }

    .layer {
        position: absolute;
    }

    .centered {
        position: absolute;
        left: 23.5mm;
        width: 250mm;
        text-align: center;
    }

    .federation {
        top: 41.5mm;
        padding-left: 3pt;
        font-family: times, serif;
        font-size: 15pt;
        font-weight: bold;
        letter-spacing: 3pt;
        color: #0A2463;
    }

    .affiliation {
        top: 48.5mm;
        padding-left: 1.6pt;
        font-size: 6.8pt;
        letter-spacing: 1.6pt;
        color: #5A6478;
    }

    .tricolor {
        position: absolute;
        top: 53.5mm;
        width: 10mm;
        height: 0.9mm;
    }

    .title {
        font-family: {!! $titleFont !!};
        font-weight: bold;
        text-transform: uppercase;
        color: #0A2463;
    }

    .title-sub {
        top: 76.5mm;
        padding-left: 5pt;
        font-size: 11.5pt;
        font-weight: bold;
        letter-spacing: 5pt;
        text-transform: uppercase;
        color: #A8801E;
    }

    .certify {
        top: 87mm;
        font-family: times, serif;
        font-size: 13pt;
        font-style: italic;
        color: #5A6478;
    }

    .name {
        top: 94mm;
        font-family: {!! $nameFont !!};
        font-weight: bold;
        font-style: italic;
        color: #0A2463;
    }

    .name-rule {
        position: absolute;
        top: 109.5mm;
        left: 68.5mm;
        width: 160mm;
        height: 0.35mm;
        background-color: #C9A227;
    }

    .player-id {
        top: 112.5mm;
        padding-left: 1.5pt;
        font-size: 8pt;
        letter-spacing: 1.5pt;
        color: #5A6478;
    }

    .player-id strong { color: #0A2463; }

    .citation {
        top: 121mm;
        left: 33.5mm;
        width: 230mm;
        font-family: {!! $citationFont !!};
    }

    .citation strong { color: #0A2463; }

    .meta {
        top: 152mm;
        left: 27mm;
        width: 52mm;
    }

    .label {
        font-size: 6.5pt;
        letter-spacing: 1.4pt;
        color: #5A6478;
    }

    .meta-date {
        margin: 1mm 0 3.5mm;
        font-family: times, serif;
        font-size: 12pt;
        color: #0A2463;
    }

    .meta-number {
        margin-top: 1mm;
        font-size: 9.5pt;
        font-weight: bold;
        letter-spacing: 0.5pt;
        color: #0A2463;
    }

    .signature {
        top: 154mm;
        width: 46mm;
        text-align: center;
    }

    .signature-space { height: 13mm; }

    .signature-line {
        padding-top: 1.8mm;
        border-top: 0.25mm solid #1A2238;
        font-family: times, serif;
        font-size: 11.5pt;
        font-weight: bold;
        color: #0A2463;
    }

    .signature-org {
        margin-top: 0.6mm;
        font-size: 6.8pt;
        letter-spacing: 0.6pt;
        color: #5A6478;
    }

    .qr-plate {
        top: 146.5mm;
        left: 240.5mm;
        width: 27mm;
        height: 27mm;
        border: 0.3mm solid #D9C68A;
        background-color: #FFFFFF;
    }

    .qr-caption {
        top: 175.5mm;
        left: 236mm;
        width: 36mm;
        text-align: center;
        padding-left: 1.4pt;
        font-size: 6.5pt;
        font-weight: bold;
        letter-spacing: 1.4pt;
        color: #0A2463;
    }

    .footnote {
        top: 187.5mm;
        font-size: 6.3pt;
        color: #5A6478;
    }
</style>
</head>
<body>
<img alt="" class="layer" src="{{ $images['frame'] }}" style="top: 0; left: 0; width: 297mm; height: 210mm;"/>
<img alt="" class="layer" src="{{ $images['watermark'] }}" style="top: 70mm; left: 98.5mm; width: 100mm;"/>

<div class="centered" style="top: 20mm;"><img alt="Jumpball Federation of India" src="{{ $images['logo'] }}" style="height: 20mm;"/></div>
<div class="centered federation">JUMPBALL FEDERATION OF INDIA</div>
<div class="centered affiliation">AFFILIATED TO THE INTERNATIONAL JUMPBALL FEDERATION</div>
<div class="tricolor" style="left: 133.5mm; background-color: #E8702A;"></div>
<div class="tricolor" style="left: 143.5mm; width: 9.7mm; height: 0.6mm; border: 0.15mm solid #D9D2C0; background-color: #FFFFFF;"></div>
<div class="tricolor" style="left: 153.5mm; background-color: #138A36;"></div>

<div class="centered title" style="top: {{ $titleTop }}mm; font-size: {{ $titleSize }}pt; letter-spacing: {{ $titleSpacing }}pt; padding-left: {{ $titleSpacing }}pt;">{{ $titleMain }}</div>
@if ($titleSub)
<div class="centered title-sub">{{ $titleSub }}</div>
@endif

<div class="centered certify">This is to certify that</div>
<div class="centered name" style="font-size: {{ $nameSize }}pt;">{{ $player->name }}</div>
<div class="name-rule"></div>
<div class="centered player-id">PLAYER ID&nbsp;&nbsp;<strong>{{ $player->registration_no }}</strong></div>

<div class="centered citation" style="font-size: {{ $citationSize }}pt; line-height: {{ $citationLeading }};">
@if ($certificate->achievement && $event)
has been awarded this certificate for <strong>{{ $certificate->achievement }}</strong><br/>at the <strong>{{ $event->title }}</strong>, {{ $eventLine }}.
@elseif ($certificate->achievement)
has been awarded this certificate for <strong>{{ $certificate->achievement }}</strong>.
@elseif ($event)
has been awarded this certificate for taking part in the<br/><strong>{{ $event->title }}</strong>, {{ $eventLine }}.
@else
has been awarded this certificate by the Jumpball Federation of India.
@endif
</div>

<div class="layer meta">
<div class="label">DATE OF ISSUE</div>
<div class="meta-date">{{ $certificate->issued_on->format('j F Y') }}</div>
<div class="label">CERTIFICATE NO.</div>
<div class="meta-number">{{ $certificate->certificate_no }}</div>
</div>

<div class="layer signature" style="left: 82mm;">
<div class="signature-space"></div>
<div class="signature-line">Secretary General</div>
<div class="signature-org">Jumpball Federation of India</div>
</div>

<img alt="" class="layer" src="{{ $images['emblem'] }}" style="top: 146mm; left: 132.5mm; width: 32mm; height: 32mm;"/>
<img alt="" class="layer" src="{{ $images['logo'] }}" style="top: 156.4mm; left: 141mm; width: 15mm;"/>

<div class="layer signature" style="left: 169mm;">
<div class="signature-space"></div>
<div class="signature-line">President</div>
<div class="signature-org">Jumpball Federation of India</div>
</div>

<div class="layer qr-plate"></div>
<img alt="QR code to verify this certificate" class="layer" src="{{ $images['qrCode'] }}" style="top: 148mm; left: 242mm; width: 24mm; height: 24mm;"/>
<div class="layer qr-caption">SCAN TO VERIFY</div>

<div class="centered footnote">Issued by the Jumpball Federation of India. Verify this certificate by scanning the QR code or at {{ $verifyAt }}.</div>
</body>
</html>
