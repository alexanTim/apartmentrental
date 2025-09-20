<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function expenses(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->input('end_date', now()->endOfMonth()->toDateString());
        $category  = $request->input('category');

        $query = Expense::query()->whereBetween('expense_date', [$startDate, $endDate]);

        if ($category) {
            $query->where('category', $category);
        }

        $expenses = $query->orderBy('expense_date', 'asc')->get();
        $total = $expenses->sum('amount');

        // If user wants PDF export
        if ($request->has('export') && $request->export === 'pdf') {
            $pdf = Pdf::loadView('reports.expenses-pdf', [
                'expenses' => $expenses,
                'total' => $total,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'category' => $category,
            ]);

            return $pdf->download('expense-report.pdf');
        }

        return Inertia::render('Reports/Expenses', [
            'filters' => [
                'start_date' => $startDate,
                'end_date'   => $endDate,
                'category'   => $category,
            ],
            'expenses' => $expenses,
            'total'    => $total,
        ]);
    }
}
