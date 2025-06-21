<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id); // Auth::user() untuk mendapatkan user yang sedang login dan mengembalikan dalam bentuk objek, maka tentukan apa yang akan diambil? ambil id nya saja, nanti akan ada pengecekan author_id = id user yg login

        // pencarian post berdasarkan judul
        if(request('keyword')) {
            $posts->where('title', 'like', '%' . request('keyword') . '%');
        }
        return view('dashboard.index', ['posts' => $posts->paginate(5)->withQueryString()]); // gunakan 'withQueryString' agar tetap membawa query dan tidak mereset url / pagination
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Post::create([
            'title' => $request->title,
            'author_id' => Auth::user()->id,
            'category_id'=> $request->category_id,
            'slug'=> Str::slug($request->title), // menggunakan helper slug untuk dibuatkan otomatis berdasarkan title
            'body'=> $request->body,
        ]);

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
