<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:post list', ['only' => ['index', 'show']]);
        $this->middleware('can:post create', ['only' => ['create', 'store']]);
        $this->middleware('can:post edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:post delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $posts = (new Post)->newQuery();
        $posts->latest();
        $posts = $posts->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Post/Index', [
            'posts' => $posts,
            'can' => [
                'create' => Auth::user()->can('post create'),
                'edit' => Auth::user()->can('post edit'),
                'delete' => Auth::user()->can('post delete'),
            ]
        ]);
    }

    public function create(): Response
    {
        //Get all Category
        $category = Category::pluck('name');

//        dd($category);

        //Return View Component
        return Inertia::render('Admin/Post/Create', [
            'category' => $category
        ]);

    }

    public function store(PostRequest $request): RedirectResponse
    {
        //Validation Rule / Post Request
        $request->validated($request->all());

        //Upload Image Posts
        $image = $request->file('image')->store('images/post', 'public');

        //Create Post Eloquent
        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'slug' => $request->slug,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $image,
            'tags' => $request->tags,
            'status' => $request->status,
        ]);

        //Redirect Back
        return to_route('post.index')->with("message", "Berhasil Menambah Post");

    }

    public function edit($id): Response
    {
        //Get Post By ID
        $posts = Post::all();
        $post = $posts->find($id);

        //Get all Category
        $category = Category::pluck('name');

        //Return View Component
        return Inertia::render('Admin/Post/Edit', [
            'post' => $post,
            'category' => $category
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        /*Validate All Update Request Post*/
        $request->validated($request->all());

        if ($request->file('image')) {
            /*If Image Available, Run Storage Delete*/
            Storage::delete('public/' . $post->image);
            //Upload New Image Posts
            $image = $request->file('image')->store('images/post', 'public');

            /*Update Image*/
            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'category' => $request->category,
                'description' => $request->description,
                'image' => $image,
                'tags' => $request->tags,
                'status' => $request->status,
            ]);

        } else {

            /*Not Update Image*/
            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'category' => $request->category,
                'description' => $request->description,
//                'image' => $image,
                'tags' => $request->tags,
                'status' => $request->status,
            ]);

        }

        //Redirect Back
        return to_route('post.index')->with("message", "Berhasil Mengubah Post");
    }

    public function destroy($id): RedirectResponse
    {
        //Get Post By ID
        $posts = Post::all();
        $post = $posts->find($id);

        /*Run Delete Post By ID*/
        $post->delete();

        /*Run Storage Delete*/
        Storage::delete('public/' . $post->image);

        //Redirect Back
        return to_route('post.index')->with("message", "Berhasil Menghapus Post");
    }
}
