
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            // $table->unsignedBigInteger('author_id');
            // $table->foreign('author_id')->references('id')->on('users');
            $table->foreignId('author_id')->constrained(
                'users',
                indexName: 'posts_author_id'
            );
            $table->foreignId('category_id')->constrained(
                'categories', // ! ga harus menuliskan nama table secara eksplisit karena tabel categories akan otomatis dicarikan berdasarkan nama column foreign nya yaitu 'category_id'
                indexName: 'posts_category_id'
            );
            $table->string('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
