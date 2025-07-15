<?php

namespace App\Http\Controllers;

use App\Models\SaleTarget;
use App\Models\User;
use Illuminate\Http\Request;

class SaleTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targets = SaleTarget::with('user')->latest()->get();



        // return $targets;

        return view('dashboard.targets.index', compact('targets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('is_active', 1)->where('username', '<>', 'developer')->get();
        return view('dashboard.targets.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'target' => ['required', 'array', 'min:1'],
            'target.*.user_id' => ['required', 'integer', 'exists:users,id'],
            'target.*.start_month' => ['required', 'integer', 'between:1,12'],
            'target.*.start_year' => ['required', 'integer', 'min:'.date('Y'), 'max:'.date('Y') + 3],
            'target.*.end_month' => ['required', 'integer', 'between:1,12'],
            'target.*.end_year' => ['required', 'integer', 'min:'.date('Y'), 'max:'.date('Y') + 3],
            'target.*.target_amount' => ['required', 'numeric', 'gt:0'],
        ]);

        foreach ($validated['target'] as $data) {
            SaleTarget::create($data);
        }

        return redirect()->route('targets.index')->with('success', 'Sale Target Assigned To User');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleTarget $saleTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleTarget $target)
    {
        $users = User::where('is_active', 1)->where('username', '<>', 'developer')->get();
        return view('dashboard.targets.edit', compact('users', 'target'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleTarget $target)
    {


        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'start_month' => ['required', 'integer', 'between:1,12'],
            'start_year' => ['required', 'integer', 'min:'.date('Y'), 'max:'.date('Y') + 3],
            'end_month' => ['required', 'integer', 'between:1,12'],
            'end_year' => ['required', 'integer', 'min:'.date('Y'), 'max:'.date('Y') + 3],
            'target_amount' => ['required', 'numeric', 'gt:0'],
        ]);

        $target->update($validated);

        return redirect()->route('targets.index')->with('success', 'Target Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleTarget $target)
    {
        $target->delete();

        return redirect()->route('targets.index')->with('success','Target Deleted');
    }
}
