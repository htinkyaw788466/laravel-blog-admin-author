<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $limit=5;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tags=Tag::all();
        $tags=Tag::all();
        return view('admin.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required'
        ]);

        $tag=new Tag();
        $tag->name=$request->name;
        $tag->slug=str_slug($request->name);
        $tag->save();
        return redirect()->route('admin.tag.index')
               ->with('successMsg','tag created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag=Tag::findOrFail($id);
        return view('admin.tag.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tag=Tag::find($id);
        $tag->name=$request->name;
        $tag->slug=str_slug($request->name);
        $tag->save();
        return redirect()->route('admin.tag.index')
               ->with('successMsg','tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag=Tag::find($id);
        $tag->delete();
        return redirect()->route('admin.tag.index')
               ->with('successMsg','tag deleted successfully');

    }
}
