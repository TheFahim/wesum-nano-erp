<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Service;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('resource list');

        $resources = Resource::whereHas('service', function ($query) {
            $query->whereIn('technology_id', auth()->user()->technologies->pluck('id'));
        })->get();

        return view('dashboard.resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $this->checkUserPermission('resource create');
        $services = Service::all();

        return view('dashboard.resources.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkUserPermission('resource create');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);


        Resource::create([
            'name' => $validated['name'],
            'service_id' => $validated['service_id']
        ]);

        return redirect()->route('resource.index')->with('success', 'Resource created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        $this->checkUserPermission('resource edit');

        $services = Service::all();

        return view('dashboard.resources.edit', compact('resource', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $this->checkUserPermission('resource edit');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
        ]);


        $resource->update([
            'name' => $validated['name'],
            'service_id' => $validated['service_id']
        ]);

        return redirect()->route('resource.index')->with('success', 'Resource Updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $this->checkUserPermission('resource delete');
        $resource->delete();

        return redirect()->route('resource.index')->with('success', 'Resource Deleted successfully.');
    }
}
