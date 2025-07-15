<x-dashboard.layout.default title="Edit Expense">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('expense.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.users-group class="h-3 w-3 me-2" />
                Expense
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Edit" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Edit Expense">
        <div class="flex flex-col items-center justify-center">
            <form action="{{ route('expense.update', $expense->id) }}" method="POST" enctype="multipart/form-data"
                class="w-full max-w-md">
                @csrf
                @method('PATCH')
                <div class="space-y-2 mx-5">
                    <div class="px-2 space-y-3">

                        <label for="expense-datepicker"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Date
                            <span
                                class="bg-red-100 text-red-800 text-xs font-medium px-1 py-0.5 rounded dark:bg-red-900 dark:text-red-300">required
                            </span>

                        </label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <x-ui.svg.calendar class="h-4 w-4" />
                            </div>
                            <input id="expense-datepicker" name="date" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date" value="{{ $expense->date }}">
                        </div>

                        <div class="relative max-w-sm">
                            <x-ui.form.simple-select name="type" label="Expense Type" required
                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100">
                                <option {{ $expense->type == 'transport' ? 'selected' : '' }} value="transport">
                                    Transport</option>
                                <option {{ $expense->type == 'food' ? 'selected' : '' }} value="food">Food</option>
                                <option {{ $expense->type == 'phone' ? 'selected' : '' }} value="phone">
                                    Phone</option>
                                <option {{ $expense->type == 'others' ? 'selected' : '' }} value="others">
                                    Others</option>
                            </x-ui.form.simple-select>
                        </div>

                        <div class="relative max-w-sm">
                            <x-ui.form.input label="Amount" name="amount" type="number" value="{{ $expense->amount }}"
                                required />
                        </div>

                        <div class="relative max-w-sm">
                            <x-ui.form.input label="Remarks" name="remarks" value="{{ $expense->remarks }}"
                                type="Text" />
                        </div>

                        <div class="relative max-w-sm">
                            <x-ui.form.image-upload name="voucher"
                                oldData="{{ $expense->voucher ? asset($expense->voucher) : '' }}" />
                        </div>


                    </div>
                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 my-10 mx-5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                <button form="delete-form" type="button"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>
            </form>
        </div>

        <form method="POST" action="{{ route('expense.destroy', $expense->id) }}" id="delete-form"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </x-ui.card>

</x-dashboard.layout.default>
