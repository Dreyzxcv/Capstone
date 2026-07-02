<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Acknowledgement Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 16px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td { padding: 6px; vertical-align: top; }
        .label { font-weight: bold; width: 35%; }
    </style>
</head>
<body>
    <h1>DENR-PENRO Catanduanes<br>Acknowledgement Receipt</h1>
    <p><strong>Receipt No:</strong> {{ $receipt->receipt_number }}</p>
    <p><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
    <table>
        <tr><td class="label">Asset Code</td><td>{{ $asset->asset_code }}</td></tr>
        <tr><td class="label">Type</td><td>{{ $asset->type->label() }}</td></tr>
        <tr><td class="label">Species / Description</td><td>{{ $asset->species }} {{ $asset->description }}</td></tr>
        <tr><td class="label">Municipality of Origin</td><td>{{ $asset->municipality_of_origin }}</td></tr>
        <tr><td class="label">Location Apprehended</td><td>{{ $asset->location_apprehended }}</td></tr>
        <tr><td class="label">Apprehending Agency</td><td>{{ $asset->apprehending_agency }}</td></tr>
        <tr><td class="label">Mode of Intake</td><td>{{ $asset->mode->label() }}</td></tr>
    </table>
    <p style="margin-top: 40px;">This receipt acknowledges receipt of the above asset by DENR-PENRO Catanduanes Property Section.</p>
</body>
</html>
