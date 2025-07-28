<x-dashboard.layout.default title="Dashboard">


    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.home class="h-3 w-3" />
                Dashboard
            </a>
        </li>
        <x-dashboard.ui.bread-crumb-list name="Home" />
    </x-dashboard.ui.bread-crumb>

    <div class="grid grid-cols-3 gap-4">

        <x-ui.card heading="Payement Summary">

            <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                    <dl>
                        <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Due</dt>
                        <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($bill[0]->total_due, 0, '.', ',') }} &#2547;
                    </dl>

                </div>

                <div class="grid grid-cols-2 py-3 my-5">
                    <dl>
                        <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Bill</dt>
                        <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">
                            {{ number_format($bill[0]->total_bill, 0, '.', ',') }} &#2547;</dd>
                    </dl>
                    <dl>
                        <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Received</dt>
                        <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500">
                            {{ number_format($bill[0]->total_paid, 0, '.', ',') }} &#2547;</dd>
                    </dl>
                </div>


                <div class="w-full h-6 my-5 bg-gray-200 rounded-full dark:bg-gray-700">
                    <div class="h-6 bg-blue-600 text-center text-blue-100 text-md rounded-full dark:bg-blue-500"
                        style="width: {{ number_format($bill[0]->paid_percentage, 0, '.', ',') }}%">
                        {{ number_format($bill[0]->paid_percentage, 0, '.', ',') }}%</div>
                </div>

                <div class="my-5"></div>
                {{-- <div id="bar-chart"></div> --}}

                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <div></div>
                        <!-- Dropdown menu -->
                    </div>

                </div>
            </div>
            <div class="grid grid-cols-2 px-4">
                <div></div>
                <a href="{{ route('received-bills.index') }}"
                    class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                    View payments
                    <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </a>
            </div>
        </x-ui.card>

        <x-ui.card heading="Expense Summary">



            <div x-data="expenseChartComponent" x-init="init()" @click.away="isDropdownOpen = false" class="relative">

                <!-- Donut Chart -->
                <div class="py-6" x-ref="chartContainer">
                    <!-- Loading state is handled by the chart rendering logic -->
                </div>

                <div
                    class="grid grid-cols-1 items-center border-t border-gray-200 justify-between dark:border-gray-700">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button @click="isDropdownOpen = !isDropdownOpen"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            <span x-text="buttonText"></span>
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu (Now controlled by Alpine) -->
                        <div x-show="isDropdownOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="z-10 absolute bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700"
                            style="display: none;"> {{-- `style="display: none;"` prevents flash of content on page load --}}
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">

                                <li @click="selectPeriod('today', 'Today'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                                </li>
                                <li @click="selectPeriod('last_7_days', 'Last 7 days'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        7 days</a>
                                </li>
                                <li @click="selectPeriod('this_month', 'This Month'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">This
                                        Month</a>
                                </li>
                                <li @click="selectPeriod('last_month', 'Last Month'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        Month</a>
                                </li>
                                <li @click="selectPeriod('last_6_month', 'Last 6 Month'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        6 Month</a>
                                </li>
                                <li @click="selectPeriod('this_year', 'This Year'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">This
                                        Year</a>
                                </li>
                                <li @click="selectPeriod('last_year', 'Last Year'); isDropdownOpen = false;">
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                        Year</a>
                                </li>
                            </ul>
                        </div>

                        <a href="{{ route('expense.index') }}"
                            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                            See all expenses
                            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>


        </x-ui.card>
        <div id="target-chart">

        </div>



    </div>

</x-dashboard.layout.default>
