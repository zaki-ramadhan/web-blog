<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;


class Post extends Model
{

    use HasFactory; //agar bisa menjalankan factory

    // agar data bisa diisi melalui 'tinker'. maka perlu menuliskan kolom apa saja yang boleh diisi atau jangan diisi
    protected $fillable = ['title', 'slug', 'author', 'body']; // ini bisa diisi dengan nama kolom yang BOLEH diisi (kalo kosong artinya semua kolom boleh diisi)

    // ! untuk mengguankan eager loading, cukup di model saja, maka di route tidak perlu menuliskan lagi
    protected $with = ['author', 'category']; // gunakan keyword 'with' untuk eager loading relasi yang ada di model ini

    // protected $guarded = ['id']; // ini bisa diisi dengan nama kolom yang TIDAK BOLEH  diisi (kalo kosong artinya semua kolom ga boleh diisi)

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // query scope
    // #[Scope]
    public function scopeFilter(Builder $query, array $filters)
    {

        // kalo query atau inputan 'search' bernilai true / ada isinya, maka jalankan fungsi callback
        // mencari data post all
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        // mencari data dan mengecek apakah sedang ada di postingan berdasarkan kategori
        // jika iya berarti cari berdasarkan kategori juga
        // kondisi ini akan jalan ketika ada query / true, sama seperti yang atas
        $query->when($filters['category'] ?? false, function ($query, $category) {
            return $query->whereHas(
                'category',
                fn(Builder $query) =>
                $query->where(  'slug', $category)
            );
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            return $query->whereHas(
                'author',
                fn(Builder $query) =>
                $query->where('username', $author)
            );
        });
    }
}
