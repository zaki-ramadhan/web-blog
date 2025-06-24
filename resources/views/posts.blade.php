<x-layout :title="$title">

    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:pb-16 lg:px-6">
        <form class="max-w-md mx-auto mb-8">

            {{-- ? input hidden category & author --}}
            {{-- jika ada request ke category --}}
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            {{-- jika ada request ke author --}}
            @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
            @endif

            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:outline-1 focus:outline-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search post title..." name="search" autocomplete="off"/>
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

        {{ $posts->links() }}

        <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3 mt-6">

            {{-- gunakan 'forelse' agar bisa memberi kondisi jika tidak ada data yang dikembalikan --}}
            @forelse ($posts as $post)
                <article
                    class="p-6 pb-4.5 bg-white rounded-xl border border-gray-200 shadow-lg shadow-gray-200/70 dark:bg-gray-800 dark:border-gray-700 flex flex-col">
                    <div class="text-xs flex justify-between items-center mb-3 text-gray-500">
                        <a href="/posts?category={{ $post->category->slug }}">
                            <span
                                class="{{ $post->category->color }} text-gray-700 font-medium inline-flex items-center px-2.5 py-1 rounded dark:bg-primary-200 dark:text-primary-800">
                                {{ $post->category->name }}
                            </span>
                        </a>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <h2 class="mb-2 text-2xl line-clamp-2 font-bold tracking-tight text-gray-900 dark:text-white">
                        <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                    </h2>
                    <div class="mb-5 leading-6 text-sm font-light text-gray-500 line-clamp-3 dark:text-gray-400 grow">
                        {!! $post->body !!}
                    </div>

                    {{-- footer article --}}
                    <div class="flex justify-between items-center">
                        <a href="/posts?author={{ $post->author->username }}">
                            <div class="flex items-center space-x-3">
                                <img class="w-7 h-7 rounded-full object-cover"
                                    src="{{ $post->author->avatar ? asset('storage/' . $post->author->avatar) : asset('../img/default-avatar.jpeg') }}"
                                    alt="{{ $post->author->name }}" />
                                <span
                                    class="font-medium pr-7 text-xs hover:underline hover:underline-offset-2 dark:text-white line-clamp-1">
                                    {{ $post->author->name }}
                                </span>
                            </div>
                        </a>
                        <a href="/posts/{{ $post->slug }}"
                            class="text-xs text-nowrap inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                            Read more
                            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </article>

                {{-- ketika pencarian tidak mengembalikan data --}}
            @empty
                <div class="md:col-span-2 lg:col-span-3 flex justify-center">
                    <div id="alert-additional-content-2"
                        class="p-4 mb-4 max-w-md align-self-center text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <div class="flex items-center">
                            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Peringatan: Data Tidak Ditemukan!</h3>
                        </div>
                        <div class="mt-2 mb-4 text-sm">
                            Maaf, kami tidak dapat menemukan data postingan yang Anda cari. Coba periksa kembali kata
                            kunci pencarian Anda atau sesuaikan filter yang digunakan.
                        </div>
                        <div class="flex">
                            <a href="/posts"
                                class="text-white bg-red-800 hover:bg-red-900 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <svg class="mr-1 w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
