<x-dashboard.layout.default title="Add New Technology">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('technologies.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                Technologies
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Add New Technology">
        <form action="{{ route('technologies.update',$technology->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="flex items-center justify-center">
                <div class="space-y-4 w-1/2 p-6 ">
                    <div class="gap-4 items-center">
                        <!-- Input Field -->
                        <x-ui.form.input id="tech-name" name="name" label="Technology Name"
                            placeholder="Enter Technology Name" class="w-full p-2 text-lg"
                            value="{{ $technology->name }}" required />

                        <!-- Save Button -->
                    </div>
                    <div>
                        <label for="text-area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Description
                        </label>
                        <textarea id="text-area" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write Image Description here...">{{ old('description', $technology->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-2 my-2 px-2">
                        <div>
                            <h1 class="text-xl font-bold dark:text-white">Upload Cover Image</h1>
                        </div>
                        <x-ui.form.image-upload name="cover_image" oldData="{{ $technology->cover_image ? asset($technology->cover_image) : '' }}" />
                    </div>

                    <div class="grid grid-cols-5 gap-2">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                        <button form="delete-form" type="button"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>

                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('technologies.destroy', $technology->id) }}" id="delete-form" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </x-ui.card>
</x-dashboard.layout.default>
