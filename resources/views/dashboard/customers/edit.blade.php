<x-dashboard.layout.default title="Customer">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('expense.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.users-group class="h-3 w-3 me-2" />
                Customer - {{ $customer->customer_no }}
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Create" />
    </x-dashboard.ui.bread-crumb>

    <div>
        <h2 class="mx-5 text-xl font-extrabold dark:text-white">Edit Bill</h2>

        <form class="space-y-3" action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-ui.card>
                <div class="mx-2 grid grid-cols-3 space-y-3">
                    <div class="mx-2">
                        <x-ui.form.input
                            name="customer_no"
                            label="Customer ID"
                            placeholder="Ex. WC-0001"
                            class="w-full p-2 text-lg"
                            required
                            value="{{ $customer->customer_no }}"
                        />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input
                            name="customer_name"
                            label="Customer Name"
                            placeholder="Ex. Abdullah"
                            class="w-full p-2 text-lg"
                            required
                            value="{{ $customer->customer_name }}"
                        />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input
                            name="designation"
                            label="Designation"
                            placeholder="Ex. Sales Executive"
                            class="w-full p-2 text-lg"
                            value="{{ $customer->designation }}"
                        />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input
                            name="company_name"
                            label="Company Name"
                            placeholder="Ex. XYZ Corporation"
                            class="w-full p-2 text-lg"
                            required
                            value="{{ $customer->company_name }}"
                        />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input
                            name="address"
                            label="Address"
                            placeholder="House/Road/Village..."
                            class="w-full p-2 text-lg"
                            value="{{ $customer->address }}"
                        />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input
                            name="phone"
                            label="Phone"
                            placeholder="Ex. 018XXXXXXXX"
                            class="w-full p-2 text-lg"
                            value="{{ $customer->phone }}"
                        />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input
                            name="bin_no"
                            label="BIN No."
                            placeholder="Customer BIN no."
                            class="w-full p-2 text-lg"
                            value="{{ $customer->bin_no }}"
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
