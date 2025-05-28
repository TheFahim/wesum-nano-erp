<x-dashboard.layout.default title="View Contact">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('contacts.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.envelope class="h-4 w-4 me-2" />
                Contacts
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Show" />

    </x-dashboard.ui.bread-crumb>
    <x-ui.card class="mx-auto">
        <h2 class="text-xl px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Contact Details</h2>
        <hr class="border-t border-gray-300 w-full">

        <div class="relative overflow-x-auto sm:rounded-lg py-3 px-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-white">
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Name</th>
                        <td class="px-6 py-4">{{ $contact->name }}</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Email</th>
                        <td class="px-6 py-4">{{ $contact->email }}</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Subject</th>
                        <td class="px-6 py-4">{{ $contact->subject }}</td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Message</th>
                        <td class="px-6 py-4">{{ $contact->message }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex gap-4 p-4">
            @can('contact delete')
                <form action="{{ route('contacts.destroy', $contact->id) }}" id="delete-button" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        cla500 text-white px-4 py-2 rounded hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 delete-button"
                        form="delete-button">Delete</button>
                </form>
            @endcan
            <a href="#"
                class="flex items-center gap-2 text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-4 py-2">
                <span>Reply</span>
            </a>
        </div>

    </x-ui.card>

</x-dashboard.layout.default>
