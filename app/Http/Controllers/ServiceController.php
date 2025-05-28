<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('service list');

        $services = Service::whereIn('technology_id', auth()->user()->technologies->pluck('id'))->get();
        return view('dashboard.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserPermission('service create');
        $technologies = Technology::all();
        return view('dashboard.services.create', compact('technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkUserPermission('service create');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email'],
            'phone' => 'nullable|string|max:20',
            'technology_id' => 'required|exists:technologies,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->fileSave($request->cover_image, 'uploads/service', 'srv');
        }

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $this->checkUserPermission('service edit');
        //
        $technologies = Technology::all();
        return view('dashboard.services.edit', compact('service', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $this->checkUserPermission('service edit');
        //

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email'],
            'phone' => 'nullable|string|max:20',
            'technology_id' => 'required|exists:technologies,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $validated['cover_image'] = $this->fileUpdate($request->cover_image, 'uploads/service', $service->cover_image, 'srv');

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->checkUserPermission('service delete');

        if (File::exists($service->cover_image)) {
            File::delete($service->cover_image);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
