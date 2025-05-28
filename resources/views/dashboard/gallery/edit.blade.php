<x-dashboard.layout.default title="Edit Gallery Images">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('galleries.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.image class="h-3 w-3 me-2" />
                Galleries
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Edit" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Upload Image" x-data="dragableImage" @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop($event)" data-id="dropzone">
        <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="m-5 space-y-3 place-items-center">
                <div class="w-2/3">
                    <x-ui.form.input id="gallery-title" name="title" label="Gallery Title"
                        value="{{ $gallery->title }}" placeholder="Enter Gallery Title" class="w-full p-4 text-lg"
                        required />
                </div>

                <div class="w-2/3">
                    <label class="dark:text-white text-gray-900 text-left">Upload One or More Image (Under 2MB) <span
                            class="bg-red-100 text-red-800 text-xs font-medium px-1 py-0.5 rounded dark:bg-red-900 dark:text-red-300">required
                        </span></label>
                </div>

                <div class="w-2/3 gap-4">
                    <x-ui.form.image-upload id="dropzone" name="images[]" required multiple
                        oldData="{{ json_encode($gallery->images ? $gallerImages : []) }}" />
                </div>

                @error('images')
                    <div class="w-2/3">
                        <p class="text-xs text-red-500 font-semibold mt-1 text-left">{{ $message }}</p>
                    </div>
                @enderror

                @if ($errors->has('images.*'))
                    @foreach ($errors->get('images.*') as $message)
                        <div class="w-2/3">
                            <p class="text-xs text-red-500 font-semibold mt-1 text-left">An Error Occured Uploading the
                                File. Please Check the File Size and try again.</p>
                        </div>
                    @endforeach
                @endif


                <div class="col-span-3 my-2 px-2 w-2/3">
                    <label for="text-area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Description
                    </label>
                    <textarea id="text-area" rows="4" name="description"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write Image Description here...">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- <x-ui.wysiwyg-example /> --}}

                <button type="submit" id="save-button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                @can('gallery delete')
                    <button form="delete-form" type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>
                @endcan

            </div>
        </form>

        <form method="POST" action="{{ route('galleries.destroy', $gallery->id) }}" id="delete-form" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </x-ui.card>



</x-dashboard.layout.default>
