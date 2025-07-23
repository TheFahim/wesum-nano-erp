<x-dashboard.layout.default :title="'Quotation - ' . $quotation->quotation_no">

    <x-dashboard.ui.bread-crumb>
        <li class="inline-flex items-center">
            <a href="{{ route('quotations.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-ui.svg.users-group class="h-3 w-3 me-2" />
                Quotation List
            </a>
        </li>

        <x-dashboard.ui.bread-crumb-list name="Quotation" />
    </x-dashboard.ui.bread-crumb>

    <div class="bg-gray-100 p-8 font-sans">

        {{-- The main container for the quotation, styled to look like a sheet of paper --}}
        <div class="flex justify-between p-4">

            <button id="printBtn" type="button"
                class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                        d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z" />
                </svg>

                <span>&nbsp;&nbsp;Print</span>
            </button>
            <a href="{{ route('challans.create', ['quotation_id' => $quotation->id]) }}"
                class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Proceed To Challan

                <svg class="w-6 h-6 text-gray-800 dark:text-white ml-1" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 12H5m14 0-4 4m4-4-4-4" />
                </svg>
            </a>
        </div>
        <div id="q-invoice" class="max-w-4xl mx-auto bg-white p-8 shadow-lg">

            <!-- Section 1: Header (Logo, Company Name, and Quotation Details) -->
            <header class="flex justify-between items-start mb-8">
                <!-- Left Side: Logo and Company Name -->
                <div>
                    {{-- You can replace this with your actual logo --}}
                    {{-- <img src="{{ asset('path/to/your/logo.png') }}" alt="Company Logo" class="h-16 mb-2"> --}}
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

                <!-- Right Side: Quotation Title and Details -->
                <div class="text-right">
                    <h2 class="text-2xl font-bold text-blue-600 mb-4">Quotation</h2>
                    <div class="grid grid-cols-2 text-sm">
                        <div class="font-bold p-1 text-left">DATE</div>
                        <div class="border border-gray-400 p-1">{{ $quotation->created_at->format('d/m/Y') }}</div>

                        <div class="font-bold p-1 text-left">Ref</div>
                        <div class="border border-gray-400 p-1 bg-blue-100 font-semibold">{{ $quotation->quotation_no }}
                        </div>

                        <div class="font-bold p-1 text-left">CUSTOMER ID</div>
                        <div class="border border-gray-400 p-1">{{ $quotation->customer->customer_no }}</div>

                        <div class="font-bold p-1 text-left">DUE DATE</div>
                        <div class="border border-gray-400 p-1">
                            {{ $quotation->due_date ? \Carbon\Carbon::parse($quotation->due_date)->format('d/m/Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Section 2: Contact Information -->
            <section class="grid grid-cols-2 gap-8 mb-8 text-sm">
                <!-- Left Side: Your Company's Contact Details -->
                <div>
                    <h3 class="bg-blue-900 text-white font-bold p-2">Contact Details</h3>
                    <div class="border border-gray-400 p-3 space-y-1">
                        <p><strong class="w-16 inline-block">Name</strong> : {{ $quotation->user->name }}</p>
                        <p><strong class="w-16 inline-block">Phone</strong> : {{ $quotation->user->phone }}</p>
                        <p><strong class="w-16 inline-block">Web Site</strong> <a href="https://wesumcorporation.com/"
                                class="text-blue-600 hover:underline" target="_blank"> :
                                https://wesumcorporation.com</a></p>
                        <p><strong class="w-16 inline-block">Address</strong> : 78/1, Hasanlen, Dattapara, Tongi,
                            Gazipur.</p>
                        <p> </p>

                    </div>
                </div>

                <!-- Right Side: Customer's Information ("Kind Atten.") -->
                <div>
                    <h3 class="bg-blue-900 text-white font-bold p-2">Kind Atten.</h3>
                    <div class="border border-gray-400 p-3 space-y-1">
                        <p><strong class="w-24 inline-block">Name</strong> : {{ $quotation->customer->customer_name }}
                        </p>
                        <p><strong class="w-24 inline-block">Designation</strong>
                            : {{ $quotation->customer->designation }}</p>
                        <p><strong class="w-24 inline-block">Company</strong>
                            : {{ $quotation->customer->company_name }}</p>
                        <p><strong class="w-24 inline-block">Address</strong>
                            : {{ $quotation->customer->address }}</p>
                        <p><strong class="w-24 inline-block">Phone</strong> : {{ $quotation->customer->phone }}</p>
                    </div>
                </div>
            </section>



            <!-- Section 4: Products Table -->
            <section>
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 w-12">SL</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-left w-1/4">ITEM NAME</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-left">SPECIFICATIONS</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-right w-24">UNIT PRICE
                            </th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-right w-16">QTY</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-center w-20">Unit</th>
                            <th class="bg-blue-900 text-white p-2 border border-gray-500 text-right w-28">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotation->products as $product)
                            <tr>
                                <td class="border border-gray-400 p-2 text-center align-top">{{ $loop->iteration }}
                                </td>
                                <td class="border border-gray-400 p-2 align-top font-bold">{{ $product->name }}</td>
                                {{-- Using whitespace-pre-wrap to respect new lines from the textarea --}}
                                <td class="border border-gray-400 p-2 align-top ">
                                    {!! $product->specs !!}</td>
                                <td class="border border-gray-400 p-2 text-right align-top">
                                    {{ number_format($product->price, 2) }}</td>
                                <td class="border border-gray-400 p-2 text-right align-top">{{ $product->quantity }}
                                </td>
                                <td class="border border-gray-400 p-2 text-center align-top">{{ $product->unit }}</td>
                                <td class="border border-gray-400 p-2 text-right align-top font-bold">
                                    {{ number_format($product->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot id="pageFooter">
                        <tr>
                            <td>
                                <div>&nbsp;</div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </section>



            <!-- Section 5: Totals -->
            <section class="flex mt-8 text-sm place-content-between">
                <div class="w-1/3 text-center place-content-end">
                    {{-- You can place a signature image here if you have one --}}
                    <img src="{{ asset('assets/images/wesum-sign.jpeg') }}" class="h- mx-auto">
                    <div class="border-t border-gray-600 mt-1">
                        <p class="text-sm font-semibold">Authorized Signature</p>
                    </div>
                </div>
                <div class="w-1/3 justify-end">
                    <div class="grid grid-cols-2">
                        <div class="font-bold p-2">SUBTOTAL</div>
                        <div class="text-right p-2 font-semibold">{{ number_format($quotation->subtotal, 2) }} &#2547;</div>
                        <div class="font-bold p-2">VAT ({{ (int) $quotation->vat }}%)</div>
                        <div class="text-right p-2 font-semibold">
                            {{ number_format($quotation->subtotal * ($quotation->vat / 100), 2) }} &#2547;</div>
                        <div class="font-bold p-2 bg-gray-200">GRAND TOTAL</div>
                        <div class="text-right p-2 bg-gray-200 font-bold">{{ number_format($quotation->total, 2) }} &#2547;
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 6: Terms & Conditions -->
            <section class="mt-8">
                <h3 class="bg-blue-900 text-white font-bold p-2 mb-4">Terms & Conditions</h3>
                <ul class="list-disc list-inside text-sm space-y-2 text-gray-700">
                    <li>Mushuk 6.3 will be provided with a bill Copy.</li>
                    <li>Payment will be due prior to delivery of service and goods.</li>
                    <li>The Quotation Value Including VAT, AIT & Transportation.</li>
                    <li>BEFTN / Cheque in favor of Wesum corporation.</li>
                    <li>Delivery Time 3-4 weeks after getting PO. </li>
                    <li>The Quotation value valid 12 days after submission.</li>
                </ul>
            </section>

            <!-- Section 7: Document Footer -->
            <footer
                class="mt-12 pt-4 border-t border-gray-300 text-xs text-gray-600 flex justify-between items-center">
                <div class="mx-auto space-x-4">
                    <div class="text-center">
                        <div>
                            If you have any questions about this price quote, please contact
                        </div>
                        <div>
                            [Name: {{ $quotation->user->name }}, Phone: {{ $quotation->user->phone }}, E-mail:
                            wesum@wesumcorporation.com]
                        </div>
                        <div class="font-bold mt-2">
                            Thank You For Your Business!
                        </div>
                    </div>
                </div>
                {{-- You can add page numbers here if this is a multi-page document --}}
                {{-- <div class="text-right">Page 1 of 1</div> --}}
            </footer>

        </div>

    </div>
    <script>
        document.querySelector('#printBtn').addEventListener('click', function() {
            $('#q-invoice').printThis({
                importCSS: true,
                importStyle: true
            });
        });
    </script>

</x-dashboard.layout.default>
