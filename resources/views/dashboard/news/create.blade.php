<x-dashboard.layout.default title="Add a New News Article">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('news.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                News
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Add News Article">
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mx-5 space-y-2">
                <div class="grid grid-cols-3 space-y-3">
                    <div class="px-2 col-span-3 mb-3">
                        <x-ui.form.input id="title" name="title" label="News Title" placeholder="Enter News Title"
                            class="w-full p-2 text-lg" required />
                    </div>
                    <div class="px-2 col-span-3 mb-3">
                        <x-ui.form.input id="author" name="author" label="News Author"
                            placeholder="Enter Author Name" class="w-full p-2 text-lg" />
                    </div>


                    <div class="col-span-3 px-2 my-2">
                        <x-ui.form.input id="link" name="link" label="News Link" placeholder="Enter News Link"
                            class="w-full p-2 text-lg" required/>
                    </div>

                    <div class="col-span-2 my-2 px-2">
                        <div>
                            <h1 class="text-xl font-bold dark:text-white">Upload Cover Image</h1>
                        </div>
                        <x-ui.form.image-upload name="cover_image" />
                    </div>

                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button mx-2">Save</button>
            </div>
        </form>

    </x-ui.card>


</x-dashboard.layout.default>
