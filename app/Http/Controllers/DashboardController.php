<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Booking;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // compute tenants percentage from last month
        $totalTenants = Tenant::count();
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $tenantsLastMonth = Tenant::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();

        $percentageLastMonth = $totalTenants > 0
            ? round(($tenantsLastMonth / $totalTenants) * 100, 2)
            : 0;

        
        // compute expenses last week 
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        $expensesLastWeek = Expense::whereBetween('expense_date', [$startOfLastWeek, $endOfLastWeek])
            ->sum('amount');

        $expensesLastWeekFormatted = number_format($expensesLastWeek, 2);
       

        // total earning last month 
        $startLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $revenueLastMonth = Booking::whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->sum('total_price');

        $expensesLastMonth = Expense::whereBetween('expense_date', [$startLastMonth, $endLastMonth])
            ->sum('amount');

        $earningsLastMonth = $revenueLastMonth - $expensesLastMonth;
        //end 

        // compute revenue last month 
        $startPrevMonth = Carbon::now()->subMonths(2)->startOfMonth();
        $endPrevMonth = Carbon::now()->subMonths(2)->endOfMonth();

        $revenuePrevMonth = Booking::whereBetween('created_at', [$startPrevMonth, $endPrevMonth])
            ->sum('total_price');

        $percentageChange = $revenuePrevMonth > 0
            ? (($revenueLastMonth - $revenuePrevMonth) / $revenuePrevMonth) * 100
            : 0;

        $percentageChange = round($percentageChange, 2);


        $totalTenants = Tenant::count();
        $totalBookings= Booking::count();
        $totalRevenue =  Booking::where('status', '!=', 'pending')->sum('total_price');
        $Expenses = Expense::sum('amount');

        $totalEarnings = $totalRevenue - $Expenses;
        // You can pass data here if needed (e.g., total bookings, total revenue)
        return Inertia::render('Dashboard/Index', [
            'tenantspercentageLastMonth' => $percentageLastMonth,
            'totalTenants' => $totalTenants, // example
            'totalBookings' => $totalBookings, // example
            'totalRevenue' =>  number_format($totalRevenue, 2), // example
            'totalearnings' => number_format($totalEarnings, 2), // example
            'totalExpenses' => number_format($Expenses, 2), // example
            'expensesLastWeek' => $expensesLastWeekFormatted,
            'earningsLastMonth' => number_format($earningsLastMonth, 2),
            'percentageChange' => $percentageChange,
        ]);
    }
}
