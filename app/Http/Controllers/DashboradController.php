<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboradController extends Controller
{
    public function index()
    {


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
