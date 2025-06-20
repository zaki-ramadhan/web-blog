<x-layout :title="$title">

    <main
        class="pt-8 pb-16 px-6 lg:pt-16 lg:pb-24 bg-white shadow-lg shadow-gray-200/80 rounded-xl dark:bg-gray-900 antialiased">
        <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
            <article
                class="mx-auto w-full max-w-4xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                <a href="/posts"
                    class="text-sm inline-flex items-center font-medium text-primary-700 dark:text-primary-500 hover:underline">
                    <svg class="mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Back to All Posts
                </a>
                <header class="my-4 lg:mb-6 not-format">
                    <address class="flex items-center mb-6 not-italic">
                        <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                            <img class="mr-5 w-18 h-18 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                                alt="{{ $post->author->name }}">
                            <div>
                                <a href="/posts?author={{ $post->author->username }}" rel="author"
                                    class="text-xl font-bold text-gray-900 dark:text-white">{{ $post->author->name }}</a>
                                <a href="/posts?category={{ $post->category->slug }}" class="block my-1.5">
                                    <span
                                        class="{{ $post->category->color }} text-xs text-gray-700  font-medium inline-flex items-center px-2.5 py-1 rounded dark:bg-primary-200 dark:text-primary-800">
                                        {{ $post->category->name }}
                                    </span>
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </address>
                    <h1
                        class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                        {{ $post->title }}</h1>
                </header>
                <p class=" text-gray-400 leading-7 indent-12 text-justify">{{ $post->body }}</p>
            </article>
        </div>
    </main>
</x-layout>
