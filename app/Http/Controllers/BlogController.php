<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->checkUserPermission('blogs list');

        $blogs = News::where('type', 2)->latest()->get();

        return view('dashboard.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->checkUserPermission('blogs create');

        return view('dashboard.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->checkUserPermission('blogs create');

        $data = $request->validate([
            'title' => ['required', 'min:3'],
            'author' => ['min:3', 'nullable'],
            'body' => ['min:3', 'required'],
            'cover_image' => ['nullable', 'image', 'max:2048']
        ]);

        $data['cover_image'] = $this->fileSave($request->cover_image, 'uploads/blog', 'blog-cover');
        $data['type'] = 2;
        News::create($data);

        return redirect()->route('blogs.index')->with('success', 'Blog Post Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $blog)
    {

        $this->checkUserPermission('blogs edit');

        return view('dashboard.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $blog)
    {
        $this->checkUserPermission('blogs edit');

        $data = $request->validate([
            'title' => ['required', 'min:3'],
            'author' => ['min:3', 'nullable'],
            'body' => ['min:3', 'required'],
            'cover_image' => ['nullable', 'image', 'max:2048']
        ]);


        $data['cover_image'] = $this->fileUpdate($request->file('cover_image'), 'uploads/blog', $blog->cover_image, 'blog-cover');

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Blog Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $blog)
    {

        $this->checkUserPermission('blogs delete');

        if (File::exists($blog->cover_image)) {
            File::delete($blog->cover_image);
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog Post Deleted');
    }
}
