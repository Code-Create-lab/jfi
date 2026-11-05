{{--
    The one certificate template (A4 landscape), rendered by dompdf in
    Certificate::generatePdf(). dompdf has no flexbox or grid, so every block
    is absolutely positioned in millimetres; widths exclude borders.
    Signatures and seal are placeholders until the client's approved design.
--}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>{{ $certificate->title }} - {{ $certificate->certificate_no }}</title>
<style>
    @page { margin: 0; }

    body {
        margin: 0;
        font-family: "DejaVu Sans", sans-serif;
        color: #0F1B33;
    }

    .frame-outer {
        position: absolute;
        top: 7mm;
        left: 7mm;
        width: 278.6mm;
        height: 191.6mm;
        border: 2.2mm solid #0A2463;
    }

    .frame-inner {
        position: absolute;
        top: 11.5mm;
        left: 11.5mm;
        width: 273mm;
        height: 186mm;
        border: 0.4mm solid #E2AE2B;
    }

    .centered {
        position: absolute;
        left: 23.5mm;
        width: 250mm;
        text-align: center;
    }

    .logo { top: 18mm; }
    .logo img { height: 23mm; }

    .federation {
        top: 43mm;
        font-size: 13pt;
        font-weight: bold;
        letter-spacing: 1.5pt;
        color: #0A2463;
    }

    .affiliation {
        top: 50mm;
        font-size: 7.5pt;
        letter-spacing: 1pt;
        color: #4A5568;
    }

    .title {
        top: 60mm;
        font-size: 28pt;
        font-weight: bold;
        letter-spacing: 1pt;
        text-transform: uppercase;
        color: #0A2463;
    }

    .title-rule {
        position: absolute;
        top: 77mm;
        left: 133.5mm;
        width: 30mm;
        height: 0.8mm;
        background-color: #E2AE2B;
    }

    .certify {
        top: 83mm;
        font-size: 11pt;
        color: #4A5568;
    }

    .name {
        top: 91mm;
        font-size: 26pt;
        font-weight: bold;
        color: #0A2463;
    }

    .name-rule {
        position: absolute;
        top: 106mm;
        left: 73.5mm;
        width: 150mm;
        height: 0.3mm;
        background-color: #E2AE2B;
    }

    .player-id {
        top: 109mm;
        font-size: 10pt;
        letter-spacing: 0.5pt;
        color: #4A5568;
    }

    .citation {
        top: 120mm;
        font-size: 12pt;
        line-height: 1.5;
    }

    .meta {
        position: absolute;
        top: 158mm;
        left: 24mm;
        width: 58mm;
        font-size: 8.5pt;
        line-height: 1.6;
        color: #4A5568;
    }

    .meta strong { color: #0F1B33; }

    .signature {
        position: absolute;
        top: 154mm;
        width: 50mm;
        text-align: center;
    }

    .signature-space { height: 14mm; }

    .signature-line {
        border-top: 0.3mm solid #0F1B33;
        padding-top: 1.5mm;
        font-size: 9pt;
        font-weight: bold;
    }

    .signature-org {
        font-size: 7.5pt;
        color: #4A5568;
    }

    .seal {
        position: absolute;
        top: 150mm;
        left: 143mm;
        width: 23mm;
        height: 23mm;
        border: 0.3mm dashed #AEB8CC;
        border-radius: 12mm;
        text-align: center;
        font-size: 7pt;
        letter-spacing: 1pt;
        color: #AEB8CC;
    }

    .seal-label { margin-top: 9.5mm; }

    .qr {
        position: absolute;
        top: 148mm;
        left: 239mm;
        width: 28mm;
        text-align: center;
    }

    .qr img {
        width: 26mm;
        height: 26mm;
    }

    .qr-caption {
        margin-top: 1mm;
        font-size: 6.5pt;
        color: #4A5568;
    }
</style>
</head>
<body>
<div class="frame-outer"></div>
<div class="frame-inner"></div>

<div class="centered logo"><img alt="Jumpball Federation of India" src="{{ $logo }}"/></div>
<div class="centered federation">JUMPBALL FEDERATION OF INDIA</div>
<div class="centered affiliation">AFFILIATED TO INTERNATIONAL JUMPBALL FEDERATION</div>

<div class="centered title">{{ $certificate->title }}</div>
<div class="title-rule"></div>

<div class="centered certify">This is to certify that</div>
<div class="centered name">{{ $certificate->player->name }}</div>
<div class="name-rule"></div>
<div class="centered player-id">Player ID {{ $certificate->player->registration_no }}</div>

<div class="centered citation">
@if ($certificate->achievement)
has been awarded this certificate for <strong>{{ $certificate->achievement }}</strong>
@else
has been awarded this certificate by the Jumpball Federation of India
@endif
@if ($certificate->event)
<br/>at the <strong>{{ $certificate->event->title }}</strong>, {{ collect([$certificate->event->dateRange(), $certificate->event->city])->filter()->join(', ') }}.
@endif
</div>

<div class="meta">
Certificate No.<br/><strong>{{ $certificate->certificate_no }}</strong><br/>
Issued on<br/><strong>{{ $certificate->issued_on->format('j F Y') }}</strong>
</div>

<div class="signature" style="left: 86mm;">
<div class="signature-space"></div>
<div class="signature-line">Secretary General</div>
<div class="signature-org">Jumpball Federation of India</div>
</div>

<div class="seal"><div class="seal-label">SEAL</div></div>

<div class="signature" style="left: 173mm;">
<div class="signature-space"></div>
<div class="signature-line">President</div>
<div class="signature-org">Jumpball Federation of India</div>
</div>

<div class="qr">
<img alt="QR code to verify this certificate" src="{{ $qrCode }}"/>
<div class="qr-caption">Scan to verify on the<br/>federation website</div>
</div>
</body>
</html>
