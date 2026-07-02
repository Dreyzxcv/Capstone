<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>ICS</title>
<style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}h1{font-size:16px;text-align:center}</style>
</head>
<body>
<h1>Inventory Custodian Slip (ICS)</h1>
<p><strong>Document No:</strong> {{ $ics->document_number }}</p>
<p><strong>Asset Code:</strong> {{ $asset->asset_code }}</p>
<p><strong>Date:</strong> {{ $ics->issued_at->format('F d, Y') }}</p>
</body>
</html>
