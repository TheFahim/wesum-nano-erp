<x-dashboard.layout.default :title="'Challan - ' . $challan->challan_no">

    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('challans.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.book class="h-3 w-3 me-2" />
                Challans
            </a>
        </li>

        <x-dashboard.ui.bread-crumb-list name="Challan" />
    </x-dashboard.ui.bread-crumb>

    {{-- Wrap the component in Alpine.js data scope --}}
    <div x-data="{ showPrices: false }" class="bg-gray-100 p-8 font-sans">
        {{-- Action Bar for Print Button --}}
        <div class="flex justify-between p-4">
            {{-- Left-side buttons group --}}
            <div class="flex items-center space-x-2">
                <button id="printBtn" type="button"
                    class="print:hidden inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                            d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z" />
                    </svg>
                    <span>  Print</span>
                </button>

                {{-- New Alpine.js Toggle Button --}}
                @role('admin')

                <button @click="showPrices = !showPrices" type="button"
                    class="print:hidden inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 0010.004 0M6 7l3-1m6 1l-3-1m0 0l3 9a5.002 5.002 0 0010.004 0M18 7l-3-1m-6 11v-1a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6">
                        </path>
                    </svg>
                    <span x-text="showPrices ? 'Hide Prices' : 'Compare Prices'">Compare Prices</span>
                </button>
                @endrole
            </div>

            {{-- Right-side button --}}
            @if (!$hasBill)
                <a href="{{ route('bills.create', ['challan_id' => $challan->id]) }}"
                    class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Proceed To Bill
                    <svg class="w-6 h-6 text-gray-800 dark:text-white ml-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 12H5m14 0-4 4m4-4-4-4" />
                    </svg>
                </a>
            @else
                <a href="{{ route('bills.show', $challan->bill->id) }}"
                    class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Show Bill
                    <svg class="w-6 h-6 text-gray-800 dark:text-white ml-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 12H5m14 0-4 4m4-4-4-4" />
                    </svg>
                </a>
            @endif
        </div>
        <div id="challan-invoice" class="max-w-4xl mx-auto bg-white p-8 shadow-lg">

            <!-- Header -->
            <header class="flex justify-between items-start mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-12 h-12 border-2 border-black rounded-full flex items-center justify-center">
                            <div
                                class="w-8 h-8 border border-black rounded-full flex items-center justify-center font-bold text-xl">
                                W</div>
                        </div>
                        <h1 class="text-2xl font-serif font-bold tracking-wider">
                            <span class="text-blue-900">WESUM</span>
                            <span class="text-red-700">CORPORATION</span>
                        </h1>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold text-blue-600 mb-4">Challan</h2>
                    <div class="grid grid-cols-2 text-sm">

                        <div class="font-bold p-1 text-left">Challan No</div>
                        <div class="border border-gray-400 p-1 bg-blue-100 font-semibold">{{ $challan->challan_no }}
                        </div>
                        <div class="font-bold p-1 text-left">CUSTOMER ID</div>
                        <div class="border border-gray-400 p-1">{{ $challan->quotation->customer->customer_no }}</div>
                        <div class="font-bold p-1 text-left">PO No</div>
                        <div class="border border-gray-400 p-1 bg-blue-100 font-semibold">{{ $challan->po_no }}
                        </div>
                        <div class="font-bold p-1 text-left">DELIVERY DATE</div>
                        <div class="border border-gray-400 p-1">
                            {{ $challan->delivery_date ? \Carbon\Carbon::parse($challan->delivery_date)->format('d/m/Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contact Information -->
            <section class="grid grid-cols-2 gap-8 mb-8 text-sm">
                <div>
                    <h3 class="bg-blue-900 text-white font-bold p-2">Delivered By</h3>
                    <div class="border border-gray-400 p-3 space-y-1">
                        <p><strong class="w-full inline-block">WESUM CORPORATION</strong></p>
                        <p><strong class="w-16 inline-block">Phone</strong> : {{ $challan->quotation->user->phone }}</p>
                        <p><strong class="w-16 inline-block">Web Site</strong> <a href="https://wesumcorporation.com/"
                                class="text-blue-600 hover:underline"> : https://wesumcorporation.com</a></p>
                        <p><strong class="w-16 inline-block">Address</strong> : 78/1, Hasanlen, Dattapara, Tongi,
                            Gazipur.</p>
                        <p><strong class="w-16 inline-block">BIN no.</strong> : 006482594-0102</p>
                        <p> </p>

                    </div>
                </div>
                <div>
                    <h3 class="bg-blue-900 text-white font-bold p-2">Bill To</h3>
                    <div class="border border-gray-400 p-3 space-y-1">
                        <p><strong class="w-24 inline-block">Company</strong> :
                            {{ $challan->quotation->customer->company_name }}</p>
                        <p><strong class="w-24 inline-block">Address</strong> :
                            {{ $challan->quotation->customer->address }}</p>
                        <p><strong class="w-24 inline-block">Phone</strong> :
                            {{ $challan->quotation->customer->phone }}</p>
                        <p><strong class="w-24 inline-block">BIN no.</strong> :
                            {{ $challan->quotation->customer->bin_no }}</p>
                        </p>
                        <p> </p>
                        <p> </p>
                    </div>
                </div>
            </section>

            <!-- Products Table -->
            <section>
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 w-12">SL</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-left">ITEM NAME</th>
                            {{-- Conditionally shown price columns --}}
                            <th x-show="showPrices" x-transition
                                class="bg-green-700 text-white p-2 border border-gray-500 text-right">Unit Price</th>
                            <th x-show="showPrices" x-transition
                                class="bg-green-700 text-white p-2 border border-gray-500 text-right">Buying Price</th>
                            {{-- End of conditional columns --}}
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-right w-16">QTY</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-center w-20">Unit</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-left w-32">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($challan->quotation->products as $product)
                            <tr>
                                <td class="border border-gray-400 p-2 text-center align-top">{{ $loop->iteration }}
                                </td>
                                <td class="border border-gray-400 p-2 align-top font-bold">{{ $product->name }}</td>
                                {{-- Conditionally shown price columns --}}
                                <td x-show="showPrices" x-transition
                                    class="border border-gray-400 p-2 text-right align-top">
                                    {{ number_format($product->price, 2) }}</td>
                                <td x-show="showPrices" x-transition
                                    class="border border-gray-400 p-2 text-right align-top">
                                    {{ number_format($product->buying_price, 2) }}</td>
                                {{-- End of conditional columns --}}
                                <td class="border border-gray-400 p-2 text-right align-top">{{ $product->quantity }}
                                </td>
                                <td class="border border-gray-400 p-2 text-center align-top">{{ $product->unit }}</td>
                                <td class="border border-gray-400 p-2 align-top">{{ $product->remarks ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            <!-- Footer: Signature and Notes -->
            {{-- <section class="flex mt-8 text-sm place-content-between"> ... </section> --}}

            <!-- Terms & Conditions -->
            <section class="mt-8">
                <h3 class="bg-blue-900 text-white font-bold p-2 mb-4">Notes</h3>
                <ul class="list-disc list-inside text-sm space-y-2 text-gray-700">
                    <li>Goods delivered as per above details.</li>
                    <li>Please check and confirm receipt of goods in good condition.</li>
                    <li>Any discrepancy should be reported within 24 hours of delivery.</li>
                </ul>
            </section>

            <!-- Document Footer -->
            <footer
                class="mt-12 pt-4 border-t border-gray-300 text-xs text-gray-600 flex justify-between items-center">
                <div class="mx-auto space-x-4">
                    <div class="text-center">
                        <div>
                            For any queries regarding this challan, please contact
                        </div>
                        <div>
                            [Name: {{ $challan->quotation->user->name }}, Phone:
                            {{ $challan->quotation->user->phone }}, E-mail: wesum@wesumcorporation.com]
                        </div>
                        <div class="font-bold mt-2">
                            Thank You!
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        document.querySelector('#printBtn').addEventListener('click', function() {
            $('#challan-invoice').printThis({
                importCSS: true,
                importStyle: true
            });
        });
    </script>
</x-dashboard.layout.default>
