<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Compliance Report</title>
<style>body{font-family:DejaVu Sans,sans-serif;font-size:12px}h1{font-size:16px;text-align:center}table{width:100%;border-collapse:collapse;margin:16px 0}th,td{border:1px solid #ccc;padding:6px}</style>
</head>
<body>
<h1>DAO 97-32 Compliance / Inventory Report<br>DENR-PENRO Catanduanes</h1>
<p><strong>Generated:</strong> {{ $generatedAt->format('F d, Y H:i') }}</p>

<h2>By Municipality</h2>
<table><tr><th>Municipality</th><th>Count</th></tr>
@foreach($byMunicipality as $row)
<tr><td>{{ $row->municipality_of_origin }}</td><td>{{ $row->count }}</td></tr>
@endforeach
</table>

<h2>By Asset Type</h2>
<table><tr><th>Type</th><th>Count</th></tr>
@foreach($byType as $row)
<tr><td>{{ $row['type'] }}</td><td>{{ $row['count'] }}</td></tr>
@endforeach
</table>

<h2>By Status</h2>
<table><tr><th>Status</th><th>Count</th></tr>
@foreach($byStatus as $row)
<tr><td>{{ $row['status'] }}</td><td>{{ $row['count'] }}</td></tr>
@endforeach
</table>
</body>
</html>
