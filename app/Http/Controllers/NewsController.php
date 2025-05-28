<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkUserPermission('news list');
        $news = News::where('type', 1)->latest()->get();
        return view('dashboard.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkUserPermission('news create');
        return view('dashboard.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkUserPermission('news create');
        $newsData = $request->validate([
            'title' => ['required'],
            'author' => ['nullable'],
            'cover_image' => ['nullable'],
            'link' => ['required', 'url'],
        ]);
        if ($request->hasFile('cover_image')) {
            $newsData['cover_image'] = $this->fileSave($request->file('cover_image'), 'uploads/news', 'news-cover');
        }

        News::create($newsData);
        return redirect()->route('news.index')->with('success', 'News created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $this->checkUserPermission('news edit');
        return view('dashboard.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $this->checkUserPermission('news edit');
        $newsData = $request->validate([
            'title' => ['required'],
            'author' => ['nullable'],
            'cover_image' => ['nullable', FileRule::image()],
            'link' => ['nullable', 'url'],
        ]);

        $newsData['cover_image'] = $this->fileUpdate($request->file('cover_image'), 'uploads/news', $news->cover_image, 'news-cover');


        $news->update($newsData);
        return redirect()->route('news.index')->with('success', 'News updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->checkUserPermission('news delete');
        if (File::exists($news->cover_image)) {
            File::delete($news->cover_image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted successfully');
    }
}
