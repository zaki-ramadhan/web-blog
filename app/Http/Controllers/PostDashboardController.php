<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id); // Auth::user() untuk mendapatkan user yang sedang login dan mengembalikan dalam bentuk objek, maka tentukan apa yang akan diambil? ambil id nya saja, nanti akan ada pengecekan author_id = id user yg login

        // pencarian post berdasarkan judul
        if (request('keyword')) {
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
        

        // ? validate begini messagenya menggunakan bawaan laravel
        // $request->validate([
        //     'title' => 'required|unique:posts|min:4|max:255', // unique mengacu pada tabel posts
        //     'category_id' => 'required',
        //     'body' => 'required',
        // ]);
        
        // kalo mau buat messagenya custom menggunakan class 'Validator::make'
        Validator::make($request->all(), [
            'title' => 'required|unique:posts|min:4|max:255', // unique mengacu pada tabel posts
            'category_id' => 'required',
            'body' => 'required',
        ], [
            // isi pesan error custom
            'title.required' => 'Field :attribute harus diisi',
            'category_id.required' => 'Pilih salah satu :attribute',
            'body.required' => 'Field :attribute harus diisi',
        ],[
            // atribut name di custom untuk ditampilkan di error message lebih enak
            'title' => 'judul',
            'category_id' => 'kategori',
            'body' => 'pesan'
        ])->validate();

        // ! Pesan error message juga bisa diubah ke bahasa indonesia dengan menggunakan perintah artisan lang:publish, dan melakukan perubahan isi pesannya disana
        // ! Pesan error message juga bisa diubah ke bahasa indonesia dengan menggunakan perintah artisan lang:publish, dan melakukan perubahan isi pesannya disana
        // ! Pesan error message juga bisa diubah ke bahasa indonesia dengan menggunakan perintah artisan lang:publish, dan melakukan perubahan isi pesannya disana

        Post::create([
            'title' => $request->title,
            'author_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title), // menggunakan helper slug untuk dibuatkan otomatis berdasarkan title
            'body' => $request->body,
        ]);

        return redirect('/dashboard')->with(['success' => 'Data baru berhasil ditambahkan!']); // sekalian membawa pesan / flash message, pesan sementara di session
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
    public function edit(Post $post)
    {
        return view('dashboard.edit', ['post'=> $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validasi
        $request->validate(
            [
            'title' => 'required|min:4|max:255|unique:posts, title' . $post->id, // untuk mengatasi / mengabaikan unique data agar tidak error ketika data lain diubah tapi data unique itu tetap sama / tidak berubah / meng-ignore kan, maka gunakan cara penulisan seperti ini (unique:posts dipindahkan ke akhir) lalu tambahkan field input yang mana dan diconcat / digabungkan dengan id
            'category_id' => 'required',
            'body' => 'required',
        ]);

        // Update Post
        $post->update([
            'title' => $request->title,
            'author_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
        ]);

        // Redirect
        return redirect('/dashboard')->with(['success'=> 'Data post berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/dashboard')->with(['success' => 'Data berhasil dihapus!']);
    }
}
