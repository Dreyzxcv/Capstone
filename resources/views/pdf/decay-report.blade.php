<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Decay Report</title>
<style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}h1{font-size:16px;text-align:center}</style>
</head>
<body>
<h1>Decay Report</h1>
<p><strong>Asset Code:</strong> {{ $asset->asset_code }}</p>
<p><strong>Species:</strong> {{ $asset->species }}</p>
<p><strong>Report Date:</strong> {{ now()->format('F d, Y') }}</p>
<p>This report certifies that the above asset has decayed and is deducted from inventory.</p>
</body>
</html>
