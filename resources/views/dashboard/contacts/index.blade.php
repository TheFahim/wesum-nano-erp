<x-dashboard.layout.default title="Contacts">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('contacts.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.envelope class="h-4 w-4 me-2" />
                Contacts
            </a>
        </li>
    </x-dashboard.ui.bread-crumb>

    <x-ui.card class="mx-auto">

        <div class="relative overflow-x-auto sm:rounded-lg py-3 px-2">
            <table id="contacts" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-white datatable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-300 dark:bg-gray-500 dark:text-gray-400">
                    <tr class="dark:text-white">
                        <th scope="col" class="px-6 py-3">
                            <span class="flex items-center">
                                S/L
                                <x-ui.svg.sort-column class="w-4 h-4 ms-1" />
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="flex items-center">
                                Name
                                <x-ui.svg.sort-column class="w-4 h-4 ms-1" />
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="flex items-center">
                                Email
                                <x-ui.svg.sort-column class="w-4 h-4 ms-1" />
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="flex items-center">
                                Subject
                                <x-ui.svg.sort-column class="w-4 h-4 ms-1" />
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="flex items-center">
                                Message
                                <x-ui.svg.sort-column class="w-4 h-4 ms-1" />
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Delete</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ Str::limit($contact->name, 20) }}
                            </th>
                            <td class="px-6 py-4">
                                {{ Str::limit($contact->email, 30) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($contact->subject, 30) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Str::limit($contact->message, 50) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('contacts.show', $contact->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                            </td>
                            <td>
                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" id="delete-form-{{ $contact->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" form="delete-form-{{ $contact->id }}"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline delete-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-dashboard.layout.default>
