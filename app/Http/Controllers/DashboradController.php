<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Challan;
use App\Models\Expense;
use App\Models\Quotation;
use App\Models\SaleTarget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboradController extends Controller
{
    public function index()
    {

        if (Auth::user()->hasRole('admin')) {
            return $this->adminDasboard();
        } else {

            $userId = Auth::id();

            $bill = Bill::select(
                DB::raw('SUM(payable) as total_bill'),
                DB::raw('SUM(paid) as total_paid'),
                DB::raw('SUM(due) as total_due'),
                //paid percentage
                DB::raw('SUM(paid) / SUM(payable) * 100 as paid_percentage'),
            )
                ->where('due', '>', 0)
                    ->whereHas('challan.quotation', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                ->get();

            return view('dashboard.index', compact('bill'));
        }

    }

    private function adminDasboard()
    {
        return view('dashboard.admin');
    }

    public function getTopSummary()
    {

        $sell = Bill::sum('payable');

        $received = Bill::sum('paid');

        $due = Bill::sum('due');

        $buyingPrice = Bill::whereHas('challan.quotation.products')
                                ->with('challan.quotation.products')
                                ->get()
                                ->pluck('challan.quotation.products')
                                ->flatten()
                                ->sum('buying_price');

        //count all the product with no buying price
        $productsWithoutBuyingPrice = Bill::whereHas('challan.quotation.products', function ($query) {
            $query->whereNull('buying_price');
        })->count();

        $totalExpense = Expense::sum('amount');



        $sellRevenue = $sell - $buyingPrice;


        return response()->json([
            'sellRevenue' => $this->formatBanglaNumber($sellRevenue),
            'buyingPriceWarning' => $this->formatBanglaNumber($productsWithoutBuyingPrice),
            'collectableBill' => $this->formatBanglaNumber($sell),
            'totalPaid' => $this->formatBanglaNumber($received),
            'totalDue' => $this->formatBanglaNumber($due),
            'totalExpense' => $this->formatBanglaNumber($totalExpense),
        ]);

    }

    public function getExpenseData(Request $request)
    {
        $filter = $request->input('filter', 'this_month');

        // Start the query on the Expense model
        $query = Expense::query();

        // Apply the date filter based on the 'filter' parameter
        // Using whereBetween is more precise for month-based queries
        switch ($filter) {
            case 'last_month':
                $query->whereBetween('expenses.created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
                break;
            case 'this_year':
                $query->whereYear('expenses.created_at', Carbon::now()->year);
                break;
            case 'last_year':
                $query->whereYear('expenses.created_at', Carbon::now()->subYear()->year);
                break;
            case 'last_90_days':
                $query->where('expenses.created_at', '>=', Carbon::now()->subDays(90)->startOfDay());
                break;
            case 'last_6_months':
                $query->where('expenses.created_at', '>=', Carbon::now()->subMonths(6)->startOfDay());
                break;
            case 'this_month':
            default:
                $query->whereBetween('expenses.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
        }

        // Clone the query to get the total expense for the period before grouping
        $totalExpenseQuery = clone $query;
        $totalExpense = $totalExpenseQuery->sum('amount');

        // Now, join with users and group to get the expense breakdown per user
        $expensesPerUser = $query->join('users', 'expenses.user_id', '=', 'users.id')
            ->select(
                'users.name as user_name',
                DB::raw('SUM(expenses.amount) as total_expense')
            )
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_expense', 'desc') // Optional: show highest spenders first
            ->get();

        return response()->json([
            'total_expense' => $totalExpense,
            'expenses' => $expensesPerUser, // This now contains the user-wise data
        ]);
    }

    public function getDueData(Request $request)
    {
        // Updated the default filter to 'this_month'
        $filter = $request->input('filter', 'this_month');

        $query = Bill::query();

        // --- UPDATED SWITCH STATEMENT ---
        switch ($filter) {
            case 'this_month':
                // Where created_at is within the current month
                $query->whereBetween('bills.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;

            case 'last_month':
                // Where created_at is within the previous month
                $query->whereBetween('bills.created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
                break;

            case 'this_year':
                // Where the year of created_at is the current year
                $query->whereYear('bills.created_at', Carbon::now()->year);
                break;

            case 'last_year':
                // Where the year of created_at is the previous year
                $query->whereYear('bills.created_at', Carbon::now()->subYear()->year);
                break;

            case 'last_90_days':
                $query->where('bills.created_at', '>=', Carbon::now()->subDays(90)->startOfDay());
                break;

            case 'last_6_months':
                $query->where('bills.created_at', '>=', Carbon::now()->subMonths(6)->startOfDay());
                break;

            default:
                // Fallback to 'this_month' if an unknown filter is passed
                $query->whereBetween('bills.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;
        }
        // --- END OF UPDATED SWITCH STATEMENT ---


        $totalDue = (clone $query)->sum('due');

        $usersDue = $query
            ->join('challans', 'bills.challan_id', '=', 'challans.id')
            ->join('quotations', 'challans.quotation_id', '=', 'quotations.id')
            ->join('users', 'quotations.user_id', '=', 'users.id')
            ->select(
                'users.name as user_name',
                DB::raw('SUM(bills.due) as total_due'),
                DB::raw('SUM(bills.payable) as total_payable')
            )
            ->groupBy('users.id', 'users.name')
            ->havingRaw('SUM(bills.payable) > 0')
            ->orderBy('total_due', 'desc')
            ->get()
            ->map(function ($user) {
                $paidAmount = $user->total_payable - $user->total_due;
                $percentage = ($user->total_payable > 0) ? floor((($paidAmount / $user->total_payable) * 100) * 10) / 10 : 0;

                return [
                    'name' => $user->user_name,
                    'due' => $user->total_due,
                    'percentage' => $percentage,
                ];
            });

        return response()->json([
            'total_due' => $totalDue,
            'users' => $usersDue,
        ]);
    }

    // app/Http/Controllers/DashboardController.php

    public function getTargetData(Request $request)
    {
        $filter = $request->input('filter', 'this_year');
        $year = Carbon::now()->year;

        switch ($filter) {
            case 'last_year':
                $year = Carbon::now()->subYear()->year;
                break;
            case 'this_year':
            default:
                $year = Carbon::now()->year;
                break;
        }

        $achievedSales = Challan::join('quotations', 'challans.quotation_id', '=', 'quotations.id')
            ->whereYear('challans.created_at', $year)
            ->groupBy('quotations.user_id')
            ->select(
                'quotations.user_id',
                DB::raw('SUM(quotations.total) as achieved_amount')
            )->pluck('achieved_amount', 'user_id');

        $usersWithTargets = User::with(['saleTarget' => function ($query) use ($year) {
            $query->where('year', $year);
        }])
            ->whereHas('saleTarget', function ($query) use ($year) {
                $query->where('year', 'like', $year);
            })
            ->get();

        // 3. Combine the data for the chart
        $chartData = $usersWithTargets->map(function ($user) use ($achievedSales) {
            // --- FIX: Access the first item in the collection before getting the property ---
            $target = $user->saleTarget->first()?->target_amount ?? 0;
            $achieved = $achievedSales[$user->id] ?? 0;

            return [
                'x' => $user->name,
                'y' => $achieved,
                'goals' => [
                    [
                        'name' => 'Target',
                        'value' => $target,
                        'strokeWidth' => 5,
                        'strokeHeight' => 10,
                        'strokeColor' => '#775DD0'
                    ]
                ]
            ];
        });

        // 4. Calculate overall summary stats
        // --- FIX: Apply the same logic here for the total calculation ---
        $totalTarget = $usersWithTargets->sum(fn ($user) => $user->saleTarget->first()?->target_amount ?? 0);
        $totalAchieved = $achievedSales->sum();

        return response()->json([
            'year' => $year,
            'stats' => [
                'target' => $totalTarget,
                'achieved' => $totalAchieved,
                'remaining' => $totalTarget - $totalAchieved,
            ],
            'chartData' => $chartData,
        ]);
    }

    public function getQuotationData(Request $request)
    {
        // Start with the base query and eager load the user relationship
        // Only select the columns you need from the user table for efficiency
        $query = Quotation::query()->with('user:id,name');

        // Apply filters based on the request parameter
        switch ($request->input('filter', 'this_month')) {
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                break;

            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;

            case 'last_year':
                $query->whereYear('created_at', Carbon::now()->subYear()->year);
                break;

            case 'all':
                // No additional date constraints for 'all'
                break;
        }

        // Execute the query and select only necessary fields
        $quotations = $query->select('id', 'user_id', 'quotation_no', 'total', 'created_at')->get();

        // Return the data as a JSON response
        return response()->json($quotations);
    }
}
