<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Journal Entry Voucher</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .page {
            padding: 18px;
        }

        .header,
        .details,
        .account-table,
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header td,
        .details td,
        .account-table td,
        .account-table th,
        .footer-table td {
            padding: 6px;
            vertical-align: top;
        }

        .header .title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .header .subtitle {
            font-size: 9px;
            text-align: center;
            line-height: 1.2;
        }

        .bordered {
            border: 1px solid #000;
        }

        .bordered td,
        .bordered th {
            border: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 9px;
        }

        .signature {
            padding-top: 24px;
        }

        .signature .name {
            font-weight: bold;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="page">
        <table class="header">
            <tr>
                <td style="width: 70%;">
                    <div style="font-size: 12px; font-weight: bold;">DEPARTMENT OF ENVIRONMENT AND NATURAL RESOURCES</div>
                    <div style="font-size: 11px;">PROVINCE OF CATANDUANES</div>
                    <div class="subtitle">Journal Entry Voucher</div>
                </td>
                <td style="width: 30%; text-align: right; font-size: 10px;">
                    <div><strong>No. JEV-</strong>{{ $jev->jev_number }}</div>
                    <div>Date: {{ $jev->created_at->format('F d, Y') }}</div>
                </td>
            </tr>
        </table>

        <table class="bordered details" style="margin-top: 10px;">
            <tr>
                <td style="width: 28%;"><strong>Funding Source</strong></td>
                <td>{{ $asset->metadata['funding_source'] ?? 'Regular Agency Fund - General Fund - New General Appropriations - Specific Budgets of National Government Agencies' }}</td>
            </tr>
            <tr>
                <td><strong>Responsibility Center</strong></td>
                <td>{{ $asset->metadata['responsibility_center'] ?? '10-001-05-00036' }}</td>
            </tr>
            <tr>
                <td><strong>Account Title</strong></td>
                <td>{{ $asset->metadata['account_title'] ?? ($asset->description ?? $asset->species ?? 'Confiscated Property/Assets') }}</td>
            </tr>
            <tr>
                <td><strong>Account</strong></td>
                <td>{{ $asset->metadata['account_code'] ?? '19999940' }}</td>
            </tr>
            <tr>
                <td><strong>Sub-Object</strong></td>
                <td>{{ $asset->metadata['sub_object_code'] ?? '00' }}</td>
            </tr>
        </table>

        <table class="bordered details" style="margin-top: 10px;">
            <tr>
                <td style="width: 28%;"><strong>Type</strong></td>
                <td>{{ $asset->type?->label() ?? ucfirst($asset->type) }}</td>
            </tr>
            <tr>
                <td><strong>Mode</strong></td>
                <td>{{ $asset->mode?->label() ?? ucfirst($asset->mode) }}</td>
            </tr>
            <tr>
                <td><strong>Species / Description</strong></td>
                <td>{{ $asset->species ? $asset->species . ($asset->description ? ' - ' . $asset->description : '') : ($asset->description ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td><strong>Municipality</strong></td>
                <td>{{ $asset->municipality_of_origin }}</td>
            </tr>
            <tr>
                <td><strong>Location</strong></td>
                <td>{{ $asset->location_apprehended }}</td>
            </tr>
            <tr>
                <td><strong>Agency</strong></td>
                <td>{{ $asset->apprehending_agency }}</td>
            </tr>
        </table>

        <table class="bordered account-table" style="margin-top: 12px;">
            <tr>
                <th style="width: 44%;">Account Title</th>
                <th style="width: 15%;">Account</th>
                <th style="width: 10%;">Sub-Object</th>
                <th style="width: 15%;">Debit</th>
                <th style="width: 16%;">Credit</th>
            </tr>
            <tr>
                <td>{{ $asset->metadata['account_title'] ?? ($asset->description ?? $asset->species ?? 'Confiscated Property/Assets') }}</td>
                <td class="text-center">{{ $asset->metadata['account_code'] ?? '19999940' }}</td>
                <td class="text-center">{{ $asset->metadata['sub_object_code'] ?? '00' }}</td>
                <td class="text-right">{{ number_format($asset->metadata['debit'] ?? $asset->metadata['amount'] ?? 0, 2) }}</td>
                <td class="text-right">{{ number_format($asset->metadata['credit'] ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>{{ number_format($asset->metadata['debit'] ?? $asset->metadata['amount'] ?? 0, 2) }}</strong></td>
                <td class="text-right"><strong>{{ number_format($asset->metadata['credit'] ?? 0, 2) }}</strong></td>
            </tr>
        </table>

        <table class="bordered details" style="margin-top: 10px;">
            <tr>
                <td style="width: 28%;"><strong>Supporting Documents</strong></td>
                <td>{{ $asset->metadata['supporting_documents'] ?? 'E-FMS No. ' . ($asset->metadata['efms_number'] ?? '__________') }}</td>
            </tr>
            <tr>
                <td><strong>Particulars</strong></td>
                <td>{{ $asset->metadata['particulars'] ?? 'Recording of forest products and conveyances with confiscation and forfeiture orders.' }}</td>
            </tr>
        </table>

        <table class="bordered footer-table" style="margin-top: 18px;">
            <tr>
                <td style="width: 33%; text-align: center;">
                    Prepared by:<br>
                    <div class="signature">
                        <div class="name">{{ $jev->createdByAccounting?->name ?? '_________________________' }}</div>
                        Accounting Officer
                    </div>
                </td>
                <td style="width: 33%; text-align: center;">
                    Approved by:<br>
                    <div class="signature">
                        <div class="name">{{ $jev->uploadedByMes?->name ?? '_________________________' }}</div>
                        MES Officer
                    </div>
                </td>
                <td style="width: 34%; text-align: center;">
                    Date Printed:<br>
                    <div class="signature">
                        <div class="name">{{ now()->format('F d, Y') }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
