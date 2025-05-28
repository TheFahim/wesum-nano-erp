<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('technology list');



        $techs = auth()->user()->technologies;


        return view('dashboard.technologies.index', compact('techs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserPermission('technology create');
        return view('dashboard.technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkUserPermission('technology create');
        $validated = $request->validate([

        ]);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('cover_image')) {
            # code...
            $validated['cover_image'] = $this->fileSave($request->cover_image, 'uploads/tech', 'tech');
        }

        $tech = Technology::create($validated);

        Auth::user()->technologies()->attach($tech->id);

        return redirect()->route('technologies.index')->with('success', 'Technology created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technology $technology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technology $technology)
    {
        $this->checkUserPermission('technology edit');
        return view('dashboard.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        $this->checkUserPermission('technology edit');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['cover_image'] = $this->fileUpdate($request->cover_image, 'uploads/tech', $technology->cover_image, 'tech');


        $technology->update($validated);

        return redirect()->route('technologies.index')->with('success', 'Technology updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $this->checkUserPermission('technology delete');
        if (File::exists($technology->cover_image)) {
            File::delete($technology->cover_image);
        }

        $technology->delete();

        return redirect()->route('technologies.index')->with('success', 'Entry Deleted');
    }
}
