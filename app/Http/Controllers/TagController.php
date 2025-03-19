<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Diplay all tags
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags,tag_name',
        ]);
        
        Tag::firstOrCreate([
            'tag_name' => $request->input('tag_name'),
        ]);

        notify()->success('Tag created successfully');

        return redirect()->route('tags.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
        $tag = Tag::findOrFail($tag->id);
        return view('tags.show', compact('tag'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
        $tag = Tag::findOrFail($tag->id);
        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
        $tag->update(['tag_name' => $request->input('tag_name')]);
        
        notify()->success('Tag updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
        $tag->delete();
        notify()->success('Tag deleted successfully');
    }
}
