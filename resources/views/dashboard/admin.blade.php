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

    <div class="p-4">
        <div x-data="topSummery" class="grid grid-cols-5 gap-4">

            <div class ='mx-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700'>

                <h2
                    class="bg-green-700 p-1.5 text-center text-xl font-extrabold leading-none tracking-tight md:text-xl text-white  border-b border-gray-200 dark:border-gray-700">
                    Sell Revenue
                </h2>

                <div x-text="`${sellRevenue} ৳`"
                    class="p-6 text-center text-2xl font-bold text-gray-900 dark:text-white">

                </div>
                <div class="p-4 flex items-center text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Warning</span>
                    <div>
                        <span class="font-medium" x-text="`${buyingPriceLeft} Buying Price Left`"></span>
                    </div>
                </div>

            </div>
            <div class ='mx-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700'>

                <h2 class="p-1.5 text-center text-xl font-extrabold leading-none tracking-tight md:text-xl text-white  border-b border-gray-200 dark:border-gray-700"
                    style="background-color: rgb(227 160 8 / var(--tw-bg-opacity))">
                    Expense
                </h2>
                <div x-text="`${totalExpense} ৳`"
                    class="p-6 text-center text-2xl font-bold text-gray-900 dark:text-white"></div>


            </div>
            <div class="mx-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                <h2
                    class="bg-green-700 p-1.5 text-center text-xl font-extrabold leading-none tracking-tight md:text-xl text-white  border-b border-gray-200 dark:border-gray-700">
                    Collectable Bill
                </h2>
                <div x-text="`${collectableBill} ৳`"
                    class="p-6 text-center text-2xl font-bold text-gray-900 dark:text-white">

                </div>



            </div>
            <div class ='mx-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700'>

                <h2
                    class="bg-green-700 p-1.5 text-center text-xl font-extrabold leading-none tracking-tight md:text-xl text-white  border-b border-gray-200 dark:border-gray-700">
                    Received Bill
                </h2>

                <div x-text="`${totalPaid} ৳`" class="p-6 text-center text-2xl font-bold text-gray-900 dark:text-white">

                </div>
            </div>
            <div class ='mx-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700'>

                <h2 class="p-1.5 text-center text-xl font-extrabold leading-none tracking-tight md:text-xl text-white  border-b border-gray-200 dark:border-gray-700"
                    style="background-color: rgb(227 160 8 / var(--tw-bg-opacity))">
                    Due
                </h2>
                <div x-text="`${totalDue} ৳`" class="p-6 text-center text-2xl font-bold text-gray-900 dark:text-white">
                </div>
            </div>

        </div>

        <div class="grid grid-cols-3 mx-2 gap-4 mt-4">


            <div x-data="expenseAdmin"
                class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 flex flex-col min-h-[450px]">
                <div class="grid grid-cols-2 py-3">
                    <dl>
                        <dt class="text-base font-normal dark:text-gray-200 text-gray-700 pb-1">Expense</dt>
                        <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500"
                            x-text="expense ?   expense + ' ৳' : '0৳'"></dd>
                    </dl>
                </div>

                <div id="bar-chart" class="flex-grow"></div>
                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button @click="isDropdownOpen = !isDropdownOpen"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            <span x-text="selectedFilter.label"></span>
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div x-show="isDropdownOpen" @click.away="isDropdownOpen = false"
                            class="z-10 absolute bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700"
                            style="display: none;">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <template x-for="filter in filters" :key="filter.value">
                                    <li>
                                        <a href="#" @click.prevent="selectFilter(filter)"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            x-text="filter.label"></a>
                                    </li>
                                </template>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>


            <div x-data="dueAdmin"
                class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 flex flex-col min-h-[450px]">

                <!-- Main Content -->
                <div class="flex-grow">
                    <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                        <dl>
                            <dt class="text-base font-normal text-gray-700 dark:text-gray-200 pb-1">Total Due</dt>
                            <dd class="leading-none text-xl font-bold text-gray-900 dark:text-white"
                                x-text="formatCurrency(totalDue)"></dd>
                        </dl>
                    </div>

                    <!-- Dynamic User Progress Bars -->
                    <div class="space-y-5 mt-5">
                        <template x-for="user in users" :key="user.name">
                            <div class="grid grid-cols-5 items-center gap-4 cursor-pointer"
                                @mouseenter="showTooltip($event, user.due, user.name)" @mouseleave="hideTooltip()">

                                <div class="col-span-2 dark:text-white p-1 text-xs truncate" x-text="user.name"></div>
                                <!-- Display Due Amount next to the name -->
                                <div class="col-span-3 w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="h-6 bg-blue-600 text-center text-white text-xs rounded-full dark:bg-blue-500 flex items-center justify-center"
                                        :style="`width: ${user.percentage}%`">
                                        <span x-text="`${user.percentage}%`"></span>
                                    </div>
                                </div>

                            </div>
                        </template>
                    </div>

                </div>

                <!-- Footer with Dropdown (No changes needed here) -->
                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <!-- Button -->
                        <button @click="isDropdownOpen = !isDropdownOpen"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            <span x-text="selectedFilter.label"></span>
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div x-show="isDropdownOpen" @click.away="isDropdownOpen = false"
                            class="z-10 absolute bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700"
                            style="display: none;">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton">
                                <template x-for="filter in filters" :key="filter.value">
                                    <li>
                                        <a href="#" @click.prevent="selectFilter(filter)"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            x-text="filter.label"></a>
                                    </li>
                                </template>
                            </ul>
                        </div>

                    </div>
                </div>


                <!-- Tooltip -->
                <!-- Tooltip -->
                <div x-show="tooltip.show" x-transition :style="`top: ${tooltip.y}px; left: ${tooltip.x}px;`"
                    class="fixed z-20 px-3 py-2 bg-gray-900 text-white text-xs rounded-md shadow-lg dark:bg-gray-100 dark:text-gray-900"
                    style="display:none;">

                    <!-- User Name as Title -->
                    <div class="font-bold text-sm mb-1" x-text="tooltip.userName"></div>
                    <!-- Due Amount as Body -->
                    <div x-text="`Due: ${tooltip.dueAmount}`"></div>
                </div>
            </div>

            <div x-data="targetAdmin"
                class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 flex flex-col min-h-[250px]">

                <!-- Main Content -->
                <div class="flex-grow">
                    <!-- Year Display -->
                    <div class="text-gray-700 dark:text-gray-200 my-1">Target Year</div>
                    <dd class="leading-none text-xl font-bold text-gray-900 dark:text-white mb-4" x-text="year"></dd>

                    <!-- Stats Summary -->
                    <div class="grid grid-cols-3 gap-4 py-3">
                        <dl>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Target</dt>
                            <dd class="leading-none text-sm font-bold text-blue-500 dark:text-blue-400"
                                x-text="formatCurrency(stats.target)"></dd>
                        </dl>
                        <dl>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Achieved</dt>
                            <dd class="leading-none text-sm font-bold text-green-600 dark:text-green-500"
                                x-text="formatCurrency(stats.achieved)"></dd>
                        </dl>
                        <dl>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Remaining</dt>
                            <dd class="leading-none text-sm font-bold text-red-600 dark:text-red-500"
                                x-text="formatCurrency(stats.remaining)"></dd>
                        </dl>
                    </div>

                    <!-- ApexChart will mount here -->
                    <div id="target-chart"></div>
                </div>

                <!-- Footer with Buttons -->
                <div
                    class="relative flex justify-between items-center pt-5 border-t border-gray-200 dark:border-gray-700">
                    <!-- Dropdown Button -->
                    <button @click="isDropdownOpen = !isDropdownOpen"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        <span x-text="selectedFilter.label"></span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="isDropdownOpen" @click.away="isDropdownOpen = false" x-transition
                        class="z-10 absolute bottom-12 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700"
                        style="display: none;">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <template x-for="filter in filters" :key="filter.value">
                                <li>
                                    <a href="#" @click.prevent="selectFilter(filter)"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        x-text="filter.label"></a>
                                </li>
                            </template>
                        </ul>
                    </div>


                </div>
            </div>

            <div x-data="adminQuotation" class="col-span-3 bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">



                {{-- The chart will be rendered here. x-show prevents a flash of unstyled content. --}}
                <div id="quotation" x-ref="quotationChart"></div>

                {{-- The filter UI you provided, now wired up with Alpine.js --}}
                <div
                    class="relative flex justify-between items-center pt-5 mt-4 border-t border-gray-200 dark:border-gray-700">
                    <!-- Dropdown Button -->
                    <button @click="isDropdownOpen = !isDropdownOpen"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        <span x-text="selectedFilter.label"></span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="isDropdownOpen" @click.away="isDropdownOpen = false" x-transition
                        class="z-10 absolute bottom-12 bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700"
                        style="display: none;">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <template x-for="filter in filters" :key="filter.value">
                                <li>
                                    <a href="#" @click.prevent="selectFilter(filter)"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        :class="{ 'bg-gray-100 dark:bg-gray-600': selectedFilter.value === filter.value }"
                                        x-text="filter.label"></a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>



        </div>
    </div>


</x-dashboard.layout.default>
