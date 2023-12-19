<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::selection()->paginate(PAGINATION_COUNT);
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with(['error' => 'try it later']);

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            Category::create($request->all());
            DB::commit();
            session()->flash('success', 'category created successfuly');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            return redirect()->route('home')->with(['error' => 'try it later']);
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
    public function edit(Category $category)
    {
        try {
            if (!$category) {
                return redirect()->route('home')->with(['error' => 'Not found this category']);
            }
            return view('categories.edit', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with(['error' => 'Try it later']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            if (!$category) {
                return redirect()->route('home')->with(['error' => 'Not found this category']);
            }
            DB::beginTransaction();
            $category->update($request->all());
            DB::commit();
            session()->flash('success', 'category updated successfully');

            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            return redirect()->route('home')->with(['error' => 'Try it later']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            if (!$category) {
                return redirect()->route('home')->with(['error' => 'Not found this category']);
            }
            DB::beginTransaction();
            $category->delete();
            DB::commit();
            session()->flash('success', 'Category deleted successfully');
            return redirect(route('categories.index'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with(['error' => 'Try it later']);
        }
    }
}
