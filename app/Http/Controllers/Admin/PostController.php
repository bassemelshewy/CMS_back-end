<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\checkCategory;
use App\Models\Tag;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(checkCategory::class)->only('create');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = Post::selection()->paginate(PAGINATION_COUNT);
            return view('posts.index', compact('posts'));
        } catch (\Exception $ex) {
            return redirect()->route('home')->with('error', 'Try it later');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::selection()->paginate(PAGINATION_COUNT);
        $tags = Tag::selection()->paginate(PAGINATION_COUNT);
        return view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            // return $request->all();
            $imageName = '';
            if ($request->hasFile('image')) {
                $imageName = uploadImage('Posts', $request->file('image'));
            }
            DB::beginTransaction();
            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'image' => $imageName,
                'category_id' => $request->categoryID,
                'user_id' => Auth::user()->id
            ]);

            if ($request->tags) {
                $post->tags()->attach($request->tags);
            }
            // attach for store and sync or syncWithoutDetaching for update mostly
            // If you want to add new tags without detaching existing ones, use syncWithoutDetaching.
            // If you only want to attach new tags without considering existing ones, use attach.
            // If you want to completely replace the tags with the ones provided, use sync.

            DB::commit();

            session()->flash('success', 'Post created successfuly');

            return redirect()->route('posts.index');
        } catch (\Exception $ex) {
            // DB::rollBack();
            // return $ex;
            return redirect()->route('home')->with('error', 'Try it later');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::selection()->paginate(PAGINATION_COUNT);
        $tags = Tag::selection()->paginate(PAGINATION_COUNT);
        return view('posts.create', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        try {
            $data = $request->only('title', 'description', 'content', 'categoryID');

            if ($request->hasFile('image')) {
                // dump(basename($post->image));
                removeOldImage($post->image, 'Posts');
                $imageName = uploadImage($request->file('image'), 'Posts');
                $data['image'] = $imageName;
            }
            DB::beginTransaction();
            $post->update($data);

            if ($request->tags) {
                $post->tags()->sync($request->tags);
            }


            // attach for store and sync or syncWithoutDetaching for update mostly
            // If you want to add new tags without detaching existing ones, use syncWithoutDetaching.
            // If you only want to attach new tags without considering existing ones, use attach.
            // If you want to completely replace the tags with the ones provided, use sync.

            DB::commit();

            session()->flash('success', 'Post updated successfuly');

            return redirect()->route('posts.index');
        } catch (\Exception $ex) {
            // DB::rollBack();
            // return $ex;
            return redirect()->route('posts.index')->with('error', 'Try it later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::withTrashed()->where('id', $id)->first();
            if ($post->trashed()) {
                // Storage::disk('public')->delete($post->image);
                $image = Str::after($post->image, 'uploads/Posts/');
                $image = public_path('uploads' . DIRECTORY_SEPARATOR . 'Posts/' . $image); // to reach to public folder
                if (file_exists($image)) {
                    unlink($image); //delete from folder
                }
                DB::beginTransaction();
                $post->forceDelete();
                DB::commit();
                session()->flash('success', 'post deleted successfully');
            } else {
                DB::beginTransaction();
                $post->delete();
                DB::commit();
                session()->flash('success', 'post trashed successfully');
            }
            return redirect()->route('posts.index');
        } catch (\Exception $ex) {
            return redirect()->route('home')->with('error', 'Try it later');
        }
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->paginate(PAGINATION_COUNT);
        return view('posts.index', compact('posts'));
    }

    public function restore($id)
    {
        Post::withTrashed()->where('id', $id)->restore();
        session()->flash('success', 'post restored successfully');
        return redirect()->route('posts.index');
    }
}
