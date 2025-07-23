<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Challan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::with(['challan', 'challan.quotation', 'challan.quotation.customer'])
            ->latest()
            ->get();

        return view('dashboard.bills.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $challan_id = request()->query('challan_id');

        $challan = Challan::find($challan_id);

        $challan->load('quotation', 'quotation.products');

        return view('dashboard.bills.create', compact('challan'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bill_no' => 'required|string|max:255|unique:bills,bill_no',
            'challan_id' => 'required|exists:challans,id',
        ]);

        $total = Challan::find($validated['challan_id'])
            ->quotation->total;

        $validated['payable'] = $total;
        $validated['paid'] = 0;
        $validated['due'] = $total;

        $bill = Bill::create($validated);

        return redirect()->route('bills.show', $bill->id)->with('success', 'Bill created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        $bill->load('challan', 'challan.quotation', 'challan.quotation.products');

        return view('dashboard.bills.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        return view('dashboard.bills.edit', compact('bill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        $validated = $request->validate([
            'bill_no' => ['required', 'string', 'max:255',Rule::unique('bills', 'bill_no')->ignore($bill->id)],
        ]);

        $bill->update($validated);

        return redirect()->route('bills.index')->with('success', 'Bill No updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function search(Request $request)
    {

        $bills = Bill::select('id', 'bill_no')->limit(10)->get();

        return response()->json($bills);
    }
}
