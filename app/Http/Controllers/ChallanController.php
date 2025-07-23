<?php

namespace App\Http\Controllers;

use App\Models\Challan;
use App\Models\Quotation;
use Illuminate\Http\Request;

class ChallanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $challans = Challan::with(['quotation', 'quotation.customer'])->latest()->get();

        return view('dashboard.challans.index', compact('challans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $quotationId = $request->query('quotation_id');

        $quotation = Quotation::find($quotationId)->load(['products', 'customer']);

        return view('dashboard.challans.create', compact('quotation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
            'challan_no' => 'required|string|max:255|unique:challans,challan_no',
            'po_no' => 'required|string|max:255|unique:challans,po_no',
            'delivery_date' => 'required|date_format:d/m/Y',
        ]);

        $challan = Challan::create([
            'quotation_id' => $validated['quotation_id'],
            'challan_no' => $validated['challan_no'],
            'po_no' => $validated['po_no'],
            'delivery_date' => $validated['delivery_date'] ? \Carbon\Carbon::createFromFormat('d/m/Y', $validated['delivery_date'])->format('Y-m-d') : null,
        ]);

        return redirect()->route('challans.show', $challan->id)->with('success', 'Challan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Challan $challan)
    {
        $challan->load(['quotation', 'quotation.products', 'quotation.customer']);

        return view('dashboard.challans.show', compact('challan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Challan $challan)
    {
        $challan->load(['quotation', 'quotation.customer']);

        return view('dashboard.challans.edit', compact('challan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Challan $challan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challan $challan)
    {
        //
    }
}
