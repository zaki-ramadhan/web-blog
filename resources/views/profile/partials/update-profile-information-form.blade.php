{{-- style css --}}
{{-- cdn filepond css --}}
@push('style')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
@endpush

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- tambahkan multipart/form-data agar bisa mengirim data teks dan gambar atau jenis data lainnya --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)"
                required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Upload avatar --}}
        <label class="block mb-3 text-sm font-medium text-gray-800 dark:text-white" for="avatar">Upload
            avatar</label>
        <div>
            <img id="avatar-preview" class="rounded-full w-20 h-auto aspect-square object-cover"
                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.jpeg') }}"
                alt="{{ $user->name }}">
        </div>
        <input
            class="@error('avatar') bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 file:bg-red-500 hover:file:bg-red-600 @enderror block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:file:bg-gray-700 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            aria-describedby="avatar_help" id="avatar" name="avatar" type="file"
            accept="image/jpg, image/png, image/jpeg"> {{-- input hanya menerima jenis file2 image tadi --}}
        <div class="-mt-3 text-sm text-gray-500 dark:text-gray-300" id="avatar_help">.png, .jpeg, or .jpg</div>
        @error('avatar')
            <p class="-mt-4 text-xs text-red-600 dark:text-red-500">{{ $message }}</p>
        @enderror



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@push('script')
    <script>
        //untuk preview avatar ketika blm submit
        const input = document.getElementById('avatar');
        const previewPhoto = () => {
            const file = input.files;
            if (file) {
                const fileReader = new FileReader();
                const preview = document.getElementById('avatar-preview');
                fileReader.onload = function(event) {
                    preview.setAttribute('src', event.target.result);
                }
                fileReader.readAsDataURL(file[0]);
            }
        }
        input.addEventListener("change", previewPhoto);
    </script>

    // filepond js
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    <script>
        // Register filebond plugins
        // Register the preview img plugin
        FilePond.registerPlugin(FilePondPluginImagePreview);
        // Register the type validation
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        // Register the size validation
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        // Register the image transform
        FilePond.registerPlugin(FilePondPluginImageTransform);
        // Register the image resizer
        FilePond.registerPlugin(FilePondPluginImageResize);


        const inputElement = document.querySelector('#avatar');
        const pond = FilePond.create(inputElement, {
            acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
            maxFileSize: '5MB',
            imageResizeTargetWidth: '600',
            imageResizeMode: 'contain',
            imageResizeUpscale: false,
            server: {
                headers: {
                    // perlu membawa token agar bisa bekerja
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '/upload'
            }
        });
    </script>
@endpush
