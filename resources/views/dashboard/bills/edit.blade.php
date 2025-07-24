<x-dashboard.layout.default title="Edit Bill">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('bills.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                Bills
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Edit Bill No." />
    </x-dashboard.ui.bread-crumb>

    <div>
        <h2 class="mx-5 text-xl font-extrabold dark:text-white">Edit Bill</h2>

        <form class="space-y-3" action="{{ route('bills.update', $bill->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-ui.card>
                <div class="grid grid-cols-3 p-6">
                    <div>

                        <x-ui.form.input
                            name="bill_no"
                            label="Bill No."
                            placeholder="Ex. BILL-0001"
                            class="w-full p-2 text-lg"
                            value="{{ old('bill_no', $bill->bill_no) }}"
                            required
                        />
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mx-5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Update</button>
            </x-ui.card>
        </form>
    </div>
</x-dashboard.layout.default>
