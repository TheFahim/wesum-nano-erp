<?php

namespace App\Http\Controllers;

use App\Models\PublicationArea;
use Illuminate\Http\Request;

class PublicationAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('publication list');
        return view('dashboard.publication_areas.index', [
            'publicationAreas' => PublicationArea::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserPermission('publication create');
        return view('dashboard.publication_areas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkUserPermission('publication create');

        $data = $request->validate([
            'name' => 'required'
        ]);

        PublicationArea::create($data);
        return redirect()->route('publication-areas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PublicationArea $publicationArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublicationArea $publicationArea)
    {
        $this->checkUserPermission('publication edit');
        return view('dashboard.publication_areas.edit', [
            'publicationArea' => $publicationArea
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublicationArea $publicationArea)
    {
        $this->checkUserPermission('publication edit');
        $data = $request->validate([
            'name' => 'required'
        ]);

        $publicationArea->update($data);
        return redirect()->route('publication-areas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublicationArea $publicationArea)
    {
        $this->checkUserPermission('publication delete');
        $publicationArea->delete();
        return redirect()->route('publication-areas.index')->with('success', 'Publication Area deleted successfully');
    }
}
