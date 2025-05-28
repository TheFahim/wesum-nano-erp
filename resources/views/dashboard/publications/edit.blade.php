<x-dashboard.layout.default title="Edit Publication">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('publications.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                Publications
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Edit" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Edit Publication">
        <form action="{{ route('publications.update', $publication->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mx-5 space-y-2">
                <div class="grid grid-cols-3 space-y-3">
                    <div class="px-2 col-span-3 mb-3">
                        <x-ui.form.input id="publication-name" name="name" label="Publication Name"
                            placeholder="Enter Full Publication Name" class="w-full p-2 text-lg" required
                            value="{{ old('name', $publication->name) }}" />
                    </div>
                    <div class="px-2">
                        <x-ui.form.simple-select id="publication-area" name="publication_area_id"
                            label="Publication Area" required>
                            @foreach ($publicationAreas as $pubArea)
                                <option value="{{ $pubArea->id }}"
                                    {{ $publication->publication_area_id == $pubArea->id ? 'selected' : '' }}>
                                    {{ $pubArea->name }}
                                </option>
                            @endforeach
                        </x-ui.form.simple-select>
                    </div>

                    <div class="px-2 col-span-2">
                        <x-ui.form.input id="title" name="title" label="Title" placeholder="Enter Title"
                            class="w-full p-2 text-lg" required value="{{ old('title', $publication->title) }}" />
                    </div>

                    <div class="px-2">
                        <x-ui.form.simple-select id="year" name="year" label="Year" placeholder="Enter Title"
                            class="w-full p-2 text-lg" required>
                            @for ($i = date('Y'); $i >= 1980; $i--)
                                <option value="{{ $i }}" {{ $publication->year == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </x-ui.form.simple-select>
                    </div>

                    <div class="w-full max-w-3xl space-y-1 col-span-2" x-data="clonableInputs">
                        <div class="flex items-center">
                            <h1 class="text-grey-800 dark:text-white mx-2">
                                Authors
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium px-1 py-0.5 rounded dark:bg-red-900 dark:text-red-300">required
                                </span>
                            </h1>
                            <button type="button" class="px-2 py-1 mx-2 dark:text-white rounded hover:bg-gray-600"
                                @click="addRow">
                                <x-ui.svg.circle-plus class="w-6 h-6 " />
                            </button>
                        </div>

                        <!-- Input Rows -->
                        <template x-for="(row, index) in rows" :key="index">
                            <div class="grid grid-cols-9 items-center">

                                <!-- Input Field -->
                                <div class="px-2 col-span-8">
                                    <x-ui.form.input x-bind:name="'authors[' + index + '][name]'" x-model="row.name"
                                        type="text" placeholder="Author Name" class="px-4 py-2 border rounded " />
                                </div>

                                <!-- Remove Button -->
                                <div class="px-1">
                                    <button type="button"
                                        class="col-span-2 flex items-center justify-center p-2 bg-red-500 text-white rounded hover:bg-red-600"
                                        @click="rows.splice(index, 1)" x-show="rows.length > 1">
                                        <x-ui.svg.close class="h-6 w-6" />
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    @error('authors')
                        <div class="w-2/3">
                            <p class="text-xs text-red-500 font-semibold mt-1 text-left">{{ $message }}</p>
                        </div>
                    @enderror

                    <div class="col-span-3 px-2 my-2">
                        <x-ui.form.input id="link" name="link" label="Publication Link"
                            placeholder="Enter Publication Link" class="w-full p-2 text-lg"
                            value="{{ old('link', $publication->link) }}" />
                    </div>

                    <div class="col-span-2 my-2 px-2">
                        <div>
                            <h1 class="text-xl font-bold dark:text-white">Upload Cover Image</h1>
                        </div>
                        <x-ui.form.image-upload name="cover_image"
                            oldData="{{ $publication->cover_image ? asset($publication->cover_image) : '' }}" />
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-2">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                    @can('publication delete')
                        <button form="delete-form" type="button"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>
                    @endcan

                </div>
            </div>
        </form>


        <form method="POST" action="{{ route('publications.destroy', $publication->id) }}" id="delete-form"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </x-ui.card>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clonableInputs', () => ({
                rows: [...{!! json_encode($publication->authors) !!}],

                addRow() {
                    this.rows.push({
                        name: ''
                    });
                }
            }));
        });
    </script>
</x-dashboard.layout.default>
