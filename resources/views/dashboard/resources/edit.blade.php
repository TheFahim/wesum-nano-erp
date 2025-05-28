<x-dashboard.layout.default title="Edit Resource">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('resource.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.image class="h-3 w-3 me-2" />
                Resources
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>



    <form action="{{ route('resource.update', $resource->id) }}" method="POST" id="gallery-form">
        <x-ui.card heading="Eidt Resource">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-3 space-x-2 mx-3">
                <div>
                    <x-ui.form.input id="resource-name" name="name" label="Resource Name"
                        placeholder="Enter Resource Name" class="w-full p-2 text-lg" value="{{$resource->name}}" required />
                </div>

                <div class="mt-1">
                    <x-ui.form.simple-select id="service" name="service_id" label="Select Service" class="w-full"
                        required>
                        @foreach ($services as $item)
                            <option value="{{ $item->id }}" {{$item->id == $resource->service_id ? 'selected' : ''}}>{{ $item->name }}</option>
                        @endforeach
                    </x-ui.form.simple-select>
                </div>



                {{-- <x-ui.wysiwyg-example /> --}}

                <div class="mt-2">

                    <button type="submit" id="save-button"
                        class="w-1/4 h-2/3 mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                </div>
            </div>

        </x-ui.card>
    </form>



</x-dashboard.layout.default>
