<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (Auth::getUser()->hasRole('admin')) {
            $expenses = Expense::with('user')->latest()->get();
        }

        else {
            $expenses = Expense::where('user_id', Auth::getUser()->id)->latest()->get();
        }
        return view('dashboard.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:d/m/Y',
            'expense' => 'required|array|min:1',
            'expense.*.type' => [
                'required',
                Rule::in(['transport', 'phone', 'others', 'food']) // Allowed types
            ],
            'expense.*.amount' => 'required|numeric|gt:0', // Must be > 0
            'expense.*.remarks' => 'nullable|string',
            'expense.*.voucher' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf,doc,docx|max:2048'
        ]);

        foreach ($request->expense as $data) {

            if ($data['voucher'] ?? false) {
                $data['voucher'] = $this->fileSave($data['voucher'], 'uploads/voucher', 'voucher');
            }

            Expense::create([
                'date' => Carbon::createFromFormat('d/m/Y', $validated['date'])->format('Y-m-d'),
                'type' => $data['type'],
                'amount' => $data['amount'],
                'remarks' => $data['remarks'],
                'voucher' => $data['voucher'] ?? '',
                'user_id' => Auth::getUser()->id
            ]);
        }

        return redirect()->back()->with('success', 'Expense Saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('dashboard.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            "date" => ['required', 'date_format:d/m/Y'],
            "type" => ['required',  Rule::in(['transport', 'phone', 'others', 'food'])],
            'amount' => 'required|numeric|gt:0', // Must be > 0
            'remarks' => 'nullable|string',
            'voucher' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf,doc,docx|max:2048'
        ]);

        $validated['voucher'] = $this->fileUpdate($request->voucher, 'uploads/voucher', $expense->voucher, 'voucher');

        $validated['date'] = Carbon::createFromFormat('d/m/Y', $validated['date'])->format('Y-m-d');

        $expense->update($validated);

        return redirect()->route('expense.index')->with('success', 'Expense Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        if (File::exists($expense->voucher)) {
            File::delete($expense->voucher);
        }

        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Expense Deleted');
    }
}
