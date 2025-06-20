@props(['href', 'current' => false, 'ariaCurrent' => false]) {{-- set default halaman menjadi false --}}

{{-- ? menentukan class yang akan ditambahkan ke <a> berdasarkan path url --}}
@php
    // $classes = $current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white';
    if ($current) {
        $classes = 'bg-gray-900 text-white';
        $ariaCurrent = 'page';
    } else {
        $classes = 'text-gray-300 hover:bg-gray-700 hover:text-white';
    }
@endphp

{{-- gabungkan class default dengan class hasil $classes diatas menggunakan merge --}}
<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'rounded-md px-3 py-2 text-sm font-medium ' . $classes,
        'arria-current' => $ariaCurrent,
    ]) }}>{{ $slot }}</a>

{{-- ? ini aktif --}}
{{-- rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white --}}

{{-- ? ini default --}}
{{-- rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white --}}

{{-- aria-current="page" --}}
