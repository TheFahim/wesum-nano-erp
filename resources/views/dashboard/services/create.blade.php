<x-dashboard.layout.default title="Add a Service">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('services.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                Services
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Add New Service">
        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-2 mx-5">
                <div class="grid grid-cols-2 space-y-5">
                    <div class="px-2 mt-5">
                        <x-ui.form.input id="serv-name" name="name" label="Service Name" placeholder="Enter Name"
                            class="w-full p-2 text-lg" required />
                    </div>
                    <div class="px-2">
                        <x-ui.form.simple-select id="serv-tech" name="technology_id" label="Technology" required>
                            @foreach ($technologies as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                            @endforeach
                        </x-ui.form.simple-select>
                    </div>


                    <div class="px-2">
                        <x-ui.form.input id="email" name="email" label="Email" class="w-full p-2 text-lg"
                            required />
                    </div>
                    <div class="px-2">
                        <x-ui.form.input id="phone" name="phone" label="Phone" class="w-full p-2 text-lg" />
                    </div>

                    <div class="px-2">
                        <x-ui.form.image-upload name="cover_image" />
                    </div>

                    <div class="col-span-2 my-2 px-2">
                        <label for="text-area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Description
                        </label>
                        <textarea id="text-area" rows="4" name="description"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
            </div>
        </form>

    </x-ui.card>

</x-dashboard.layout.default>
