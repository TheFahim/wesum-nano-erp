<x-dashboard.layout.default title="New Challan">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('quotations.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.users-group class="h-3 w-3 me-2" />
                Quotation List
            </a>
        </li>
        <li class="inline-flex items-center">
            <a href="{{ route('quotations.show', $quotation->id) }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg> Quotation
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Chalan" />
    </x-dashboard.ui.bread-crumb>

    <div>
        <h2 class="mx-5 text-xl font-extrabold dark:text-white">Add New Challan</h2>

        <form class="space-y-3" action="{{ route('challans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-ui.card>
                <div class="p-6">
                    <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">

                    <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-md font-medium text-gray-500 dark:text-gray-400">Quotation #</dt>
                            <dd
                                class="mt-1 text-lg font-semibold text-blue-600 sm:mt-0 sm:col-span-2 dark:text-blue-400">
                                {{ $quotation->quotation_no }}
                            </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-md font-medium text-gray-500 dark:text-gray-400">Company Name</dt>
                            <dd class="mt-1 text-md text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-100">
                                {{ $quotation->customer->company_name }}
                            </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-md font-medium text-gray-500 dark:text-gray-400">Address</dt>
                            <dd class="mt-1 text-md text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-100">
                                {{ $quotation->customer->address }}
                            </dd>
                        </div>
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-md font-medium text-gray-500 dark:text-gray-400">BIN No.</dt>
                            <dd class="mt-1 text-md text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-100">
                                {{ $quotation->customer->bin_no }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-ui.card>

            <div
                class="mx-2 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 space-y-2">

                <div class="flex items-center justify-between">
                    <h2
                        class="mb-4 p-4 text-xl font-extrabold leading-none tracking-tight text-gray-900 md:text-xl dark:text-white">
                        Challan
                    </h2>

                </div>
                <div
                    class="min-w-max border-b bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                </div>

                <div class="mx-2 grid grid-cols-3 gap-4">
                    <div class="mx-2">
                        <x-ui.form.input name="challan_no" label="Challan No." placeholder="Ex. CH-0001"
                            class="w-full p-2 text-lg" value="{{ $quotation->quotation_no }}" required />
                    </div>
                    <div class="mx-2">
                        <x-ui.form.input name="po_no" label="PO No." placeholder="Ex. PO-1234"
                            class="w-full p-2 text-lg" required />
                    </div>
                    <div class="mx-2 relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none pt-5">
                            <x-ui.svg.calendar class="h-4 w-4" />
                        </div>
                        <x-ui.form.input id="datepicker" name="delivery_date" label="Delivery Date"
                            class="flowbite-datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    </div>
                </div>
            </div>

            <x-ui.card>
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 dark:text-white">Products</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($quotation->products as $product)
                                <tr>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->unit }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->quantity }}</td>
                                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->remarks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-ui.card>


            <x-ui.card>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mx-5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
            </x-ui.card>

        </form>
    </div>
</x-dashboard.layout.default>
