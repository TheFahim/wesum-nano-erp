<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('gallery list');

        $galleries = Gallery::latest()->get();

        return view('dashboard.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserPermission('gallery create');

        return view('dashboard.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->checkUserPermission('gallery create');

        $galleryData =  $request->validate(
            [
                'title' => ['required', 'min:3'],
                'images' => [
                    'required',
                    'array',
                ],
                'images.*' => [
                    'file',
                    'max:2048',
                    FileRule::types(['png', 'jpg', 'jpeg', 'svg', 'gif', 'webp']),
                ],
                'description' => ['nullable', 'min:3'],
            ],
            [
                'images.required' => 'Please upload at least one image.', // Custom message for required
                'images.*.mimes' => 'Each file must be a valid image type (png, jpg, jpeg, svg, gif, webp).',
                'images.*.max' => 'Each file must not exceed 2MB in size.', // Custom message for file size
            ]
        );

        $imagePaths = [];

        if ($request->images ?? false) {
            foreach ($request->images as $image) {
                $imagePaths[] = $this->fileSave($image, 'uploads/gallery', 'gallery');
            }
        }

        // return $imagePaths;

        Gallery::create([
            'title' => $galleryData['title'],
            'description' => $galleryData['description'],
            'images' => $imagePaths,
        ]);

        return redirect()->route('galleries.index')->with('success', 'Gallery Created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {

        $this->checkUserPermission('gallery edit');

        $gallerImages = array_map(function ($image) {
            return asset($image);
        }, $gallery->images);

        return view('dashboard.gallery.edit', compact('gallery', 'gallerImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {

        $this->checkUserPermission('gallery edit');

        $galleryData =  $request->validate(
            [
                        'title' => ['required', 'min:3'],
                        'images' => [
                            'required',
                            'array',
                        ],
                        'images.*' => [
                            'file',
                            'max:2048',
                            FileRule::types(['png', 'jpg', 'jpeg', 'svg', 'gif', 'webp']),
                        ],
                        'description' => ['nullable', 'min:3'],
                    ],
            [
                        'images.required' => 'Please upload at least one image.', // Custom message for required
                        'images.*.mimes' => 'Each file must be a valid image type (png, jpg, jpeg, svg, gif, webp).',
                        'images.*.max' => 'Each file must not exceed 2MB in size.', // Custom message for file size
                    ]
        );




        $existingImageNames = $gallery->images ?? [];


        $uploadedImageNames = [];

        // add images whose names are not in the existing images
        foreach ($request->images as $image) {
            $imageName = "uploads/gallery/{$image->getClientOriginalName()}";
            if (!in_array($imageName, $existingImageNames)) {
                $imageLocation = $this->fileSave($image, 'uploads/gallery', 'gallery');

                $uploadedImageNames[] = $imageLocation;
            } else {
                $uploadedImageNames[] = $imageName;
            }

        }

        // if existing images are not in the uploaded images, delete them
        $imagesToDelete = array_diff($existingImageNames, $uploadedImageNames);

        if (count($imagesToDelete) > 0) {

            foreach ($imagesToDelete as $image) {

                if (File::exists($image)) {
                    File::delete($image);
                }

            }

        }

        $gallery->update([
            'title' => $galleryData['title'],
            'description' => $galleryData['description'],
            'images' => $uploadedImageNames,
        ]);

        return redirect()->route('galleries.index')->with('success', 'Gallery Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {

        $this->checkUserPermission('gallery delete');


        foreach ($gallery->images as $image) {
            if (File::exists($image)) {
                File::delete($image);
            }
        }

        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gallery Deleted');

    }
}
