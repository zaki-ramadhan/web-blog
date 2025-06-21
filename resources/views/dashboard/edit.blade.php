<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- kirim data $posts sebagai props (:posts) agar bisa terbaca di component table --}}
                    <x-posts.edit :post="$post" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
