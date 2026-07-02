<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>PAR</title>
<style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}h1{font-size:16px;text-align:center}</style>
</head>
<body>
<h1>Property Acknowledgement Receipt (PAR)</h1>
<p><strong>Document No:</strong> {{ $par->document_number }}</p>
<p><strong>Asset Code:</strong> {{ $asset->asset_code }}</p>
<p><strong>Date:</strong> {{ $par->issued_at->format('F d, Y') }}</p>
</body>
</html>
