<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\PublicationArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('publication list');
        $publications = Publication::with('publicationArea')->latest()->get();
        return view('dashboard.publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserPermission('publication create');
        $publicationAreas = PublicationArea::all();
        return view('dashboard.publications.create', compact('publicationAreas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkUserPermission('publication create');
        $publicationData = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'title' => ['required', 'min:3', 'max:255'],
            'authors' => ['required', 'array'],
            'authors.*.name' => ['required', 'min:3', 'max:255'],
            'link' => ['nullable', 'url'],
            'publication_area_id' => ['required', 'exists:publication_areas,id'],
            'year' => ['required', 'numeric', 'min:1900', 'max:'.date('Y')],
            'cover_image' => ['nullable', 'image', 'max:2048', FileRule::types(['png', 'jpg', 'jpeg', 'svg', 'gif', 'webp'])]
        ]);


        if ($request->file('cover_image')) {
            $publicationData['cover_image'] = $this->fileSave($request->file('cover_image'), 'uploads/publications', 'pub-cover');
        }

        Publication::create($publicationData);

        return redirect()->route('publications.index')->with('success', 'Publication created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication)
    {
        $this->checkUserPermission('publication edit');
        $publicationAreas = PublicationArea::all();
        $selectedPA = $publication->publication_area_id;
        return view('dashboard.publications.edit', compact('publication', 'publicationAreas', 'selectedPA'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Publication $publication)
    {
        $this->checkUserPermission('publication edit');
        $publicationData = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'title' => ['required', 'min:3', 'max:255'],
            'authors' => ['required', 'array'],
            'authors.*.name' => ['required', 'min:3', 'max:255'],
            'link' => ['nullable', 'url'],
            'publication_area_id' => ['required', 'exists:publication_areas,id'],
            'year' => ['required', 'numeric', 'min:1900', 'max:'.date('Y')],
            'cover_image' => ['nullable', 'image', 'max:2048', FileRule::types(['png', 'jpg', 'jpeg', 'svg', 'gif', 'webp'])]
        ]);

        $publicationData['cover_image'] = $this->fileUpdate($request->file('cover_image'), 'uploads/publications', $publication->cover_image, 'pub-cover');

        $publication->update($publicationData);

        return redirect()->route('publications.index')->with('success', 'Publication updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication)
    {
        $this->checkUserPermission('publication delete');
        if (File::exists($publication->cover_image)) {
            File::delete($publication->cover_image);
        }

        $publication->delete();

        return redirect()->route('publications.index')->with('success', 'Publication deleted successfully');
    }
}
