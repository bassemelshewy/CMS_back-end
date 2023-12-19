<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::selection()->paginate(PAGINATION_COUNT);
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            DB::beginTransaction();
            Tag::create($request->all())->with(['success' => 'Tag created successfully']);
            DB::commit();
            return redirect()->route('tags.index');
        } catch (\Exception $ex) {
            return redirect()->route('tags.index')->with(['error' => 'Try it later']);
        }
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
    public function edit(Tag $tag)
    {
        try {
            if (!$tag)
                return redirect()->route('tags.index')->with(['error' => 'This tag does not exist']);
            return view('tags.edit', compact('tag'));
        }catch (\Exception $ex){
            return redirect()->route('tags.index')->with(['error' => 'Try it later']);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            if (!$tag)
                return redirect()->route('tags.index')->with(['error' => 'This tag does not exist']);
            $tag->update($request->all());
            return redirect()->route('tags.index')->with(['success' => 'Tag updated successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('tags.index')->with(['error'=> 'Try it later']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        try {
            if (!$tag)
                return redirect()->route('tags.index')->with(['error' => 'This tag does not exist']);
            $tag->delete();
            return redirect()->route('tags.index')->with(['success'=> 'Tag deleted successfully']);
        } catch (\Exception $ex) {
            return redirect()->route('tags.index')->with(['error'=> 'Try it later']);
        }
    }
}
