<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\Output\QRGdImagePNG;
use Illuminate\Support\Facades\URL;

class QrCodeService
{
    public function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function buildScanUrl(string $token): string
    {
        return URL::signedRoute('scan.resolve', ['token' => $token]);
    }

    public function generateSvg(string $payload): string
    {
        $options = [
            'outputInterface' => QRMarkupSVG::class,
            'scale' => 6,
            'addQuietzone' => true,
            // do not include XML prolog when embedding SVG into HTML fragments
            'svgAddXmlHeader' => false,
            // chillerlan/php-qrcode defaults outputBase64 to true for ALL
            // output interfaces, including SVG — without this override,
            // render() returns a base64 data URI instead of raw <svg> markup,
            // which then gets dumped as literal text by dangerouslySetInnerHTML
            'outputBase64' => false,
        ];

        return (new QRCode($options))->render($payload);
    }

    public function generatePngDataUri(string $payload): string
    {
        $options = [
            'outputInterface' => QRGdImagePNG::class,
            'scale' => 6,
            'imageTransparent' => true,
            'outputBase64' => true,
        ];

        return (new QRCode($options))->render($payload);
    }
}