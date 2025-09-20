<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Expense Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Expense Report</h2>
    <p><strong>Period:</strong> {{ $startDate }} to {{ $endDate }}</p>
    @if($category)
        <p><strong>Category:</strong> {{ ucfirst($category) }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->expense_date }}</td>
                    <td>{{ ucfirst($expense->category) }}</td>
                    <td>{{ $expense->description }}</td>
                    <td class="text-right">₱{{ number_format($expense->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>₱{{ number_format($total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
