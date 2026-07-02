<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Deed of Donation</title>
<style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}h1{font-size:16px;text-align:center}</style>
</head>
<body>
<h1>Deed of Donation</h1>
<p><strong>Donor:</strong> DENR-PENRO Catanduanes</p>
<p><strong>Donee:</strong> {{ $requesterName }}</p>
<p><strong>Asset Code:</strong> {{ $asset->asset_code }}</p>
<p><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
</body>
</html>
