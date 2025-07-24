<x-dashboard.layout.default title="Edit Expense">
    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('targets.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                User Targets
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Edit" />
    </x-dashboard.ui.bread-crumb>

    <x-ui.card heading="Edit Target">
        <div class="flex flex-col items-center justify-center">
            <form action="{{ route('targets.update', $target->id) }}" method="POST" enctype="multipart/form-data"
                class="w-full max-w-md">
                @csrf
                @method('PATCH')
                <div class="space-y-5">
                    <!-- Dropdown Select -->
                    <div>
                        <x-ui.form.simple-select label="User" name="user_id"
                            class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100" required>
                            @foreach ($users as $user)
                                <option {{ $target->user_id == $user->id ? 'selected' : '' }}
                                    value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </x-ui.form.simple-select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-ui.form.simple-select label="From" name="start_month"
                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100"
                                required>
                                <option {{ $target->start_month == '1' ? 'selected' : '' }} value="1">
                                    Jan</option>
                                <option {{ $target->start_month == '2' ? 'selected' : '' }} value="2">
                                    Feb</option>
                                <option {{ $target->start_month == '3' ? 'selected' : '' }} value="3">
                                    Mar</option>
                                <option {{ $target->start_month == '4' ? 'selected' : '' }} value="4">
                                    Apr</option>
                                <option {{ $target->start_month == '5' ? 'selected' : '' }} value="5">
                                    May</option>
                                <option {{ $target->start_month == '6' ? 'selected' : '' }} value="6">
                                    Jun</option>
                                <option {{ $target->start_month == '7' ? 'selected' : '' }} value="7">
                                    Jul</option>
                                <option {{ $target->start_month == '8' ? 'selected' : '' }} value="8">
                                    Aug</option>
                                <option {{ $target->start_month == '9' ? 'selected' : '' }} value="9">
                                    Sep</option>
                                <option {{ $target->start_month == '10' ? 'selected' : '' }} value="10">
                                    Oct</option>
                                <option {{ $target->start_month == '11' ? 'selected' : '' }} value="11">
                                    Nov</option>
                                <option {{ $target->start_month == '12' ? 'selected' : '' }} value="12">
                                    Dec</option>
                            </x-ui.form.simple-select>
                        </div>
                        <div>

                            <x-ui.form.simple-select name="start_year" label=" "
                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100">
                                @for ($year = now()->year; $year <= now()->year + 2; $year++)
                                    <option {{ $target->start_year == $year ? 'selected' : '' }}
                                        value="{{ $year }}">
                                        {{ $year }}
                                    </option>
                                @endfor

                            </x-ui.form.simple-select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-ui.form.simple-select label="From" name="end_month"
                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100"
                                required>
                                <option {{ $target->end_month == '1' ? 'selected' : '' }} value="1">
                                    Jan</option>
                                <option {{ $target->end_month == '2' ? 'selected' : '' }} value="2">
                                    Feb</option>
                                <option {{ $target->end_month == '3' ? 'selected' : '' }} value="3">
                                    Mar</option>
                                <option {{ $target->end_month == '4' ? 'selected' : '' }} value="4">
                                    Apr</option>
                                <option {{ $target->end_month == '5' ? 'selected' : '' }} value="5">
                                    May</option>
                                <option {{ $target->end_month == '6' ? 'selected' : '' }} value="6">
                                    Jun</option>
                                <option {{ $target->end_month == '7' ? 'selected' : '' }} value="7">
                                    Jul</option>
                                <option {{ $target->end_month == '8' ? 'selected' : '' }} value="8">
                                    Aug</option>
                                <option {{ $target->end_month == '9' ? 'selected' : '' }} value="9">
                                    Sep</option>
                                <option {{ $target->end_month == '10' ? 'selected' : '' }} value="10">
                                    Oct</option>
                                <option {{ $target->end_month == '11' ? 'selected' : '' }} value="11">
                                    Nov</option>
                                <option {{ $target->end_month == '12' ? 'selected' : '' }} value="12">
                                    Dec</option>
                            </x-ui.form.simple-select>
                        </div>
                        <div>

                            <x-ui.form.simple-select name="end_year" label=" "
                                class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100">
                                @for ($year = now()->year; $year <= now()->year + 2; $year++)
                                    <option {{ $target->end_year == $year ? 'selected' : '' }}
                                        value="{{ $year }}">
                                        {{ $year }}
                                    </option>
                                @endfor

                            </x-ui.form.simple-select>
                        </div>
                    </div>

                    <!-- Input Field -->
                    <div class=" col-span-2">
                        <x-ui.form.input label="Target Amount" name="target_amount"
                            type="number" placeholder="Amount (Tk)"
                            class="px-4 py-2 border rounded bg-gray-50 dark:bg-gray-800 dark:text-gray-100" value="{{ $target->target_amount }}" required />
                    </div>

                </div>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 my-10 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 save-button">Save</button>
                <button form="delete-form" type="button"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 m-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 delete-button">Delete</button>
            </form>
        </div>

        <form method="POST" action="{{ route('targets.destroy', $target->id) }}" id="delete-form" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </x-ui.card>

</x-dashboard.layout.default>
