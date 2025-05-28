<x-dashboard.layout.default title="Edit blog post">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('blogs.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                Blogs
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Create a Blog Post">
        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mx-5 space-y-2">
                <div class="grid grid-cols-2">
                    <div class="px-2 mb-3">
                        <x-ui.form.input id="title" name="title" label="Blog Title" placeholder="Enter Blog Title"
                            class="w-full p-2 text-lg" value="{{ $blog->title }}" required />
                    </div>
                    <div class="px-2  mb-3">
                        <x-ui.form.input id="author" name="author" label="Blog Author"
                            placeholder="Enter Author Name" class="w-full p-2 text-lg" value="{{ $blog->author }}" />
                    </div>


                    <div class="my-2 px-2">
                        <div>
                            <h1 class="text-xl font-bold dark:text-white">Upload Cover Image</h1>
                        </div>
                        <x-ui.form.image-upload name="cover_image"
                            oldData="{{ $blog->cover_image ? asset($blog->cover_image) : '' }}" />
                    </div>

                    <div class="col-span-2 m-3">
                        <textarea id="blog-content" name="body">{{ $blog->body }}</textarea>
                    </div>

                </div>


                <div class="grid grid-cols-7 gap-2">
                    <button type="submit" id="blog-save"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 mx-2">Save</button>
                    @can('blogs delete')
                        <button form="delete-form" type="button"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>
                    @endcan

                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('blogs.destroy', $blog->id) }}" id="delete-form" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </x-ui.card>


</x-dashboard.layout.default>
