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

    <x-ui.card class="h-screen">
        <section class="bg-white dark:bg-gray-800">
            <div class="gap-16 items-center py-8 px-4 mx-auto max-w-screen-xl lg:grid lg:grid-cols-2 lg:py-16 lg:px-6">
                <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">We didn't
                        reinvent the wheel</h2>
                    <p class="mb-4">We are strategists, designers and developers. Innovators and problem solvers.
                        Small enough to be simple and quick, but big enough to deliver the scope you want at the pace
                        you need. Small enough to be simple and quick, but big enough to deliver the scope you want at
                        the pace you need.</p>
                    <p>We are strategists, designers and developers. Innovators and problem solvers. Small enough to be
                        simple and quick.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-8">
                    <img class="w-full rounded-lg"
                        src="{{ asset('assets/images/office-long-2.png') }}"
                        alt="office content 1">
                    <img class="mt-4 w-full lg:mt-10 rounded-lg"
                        src="{{ asset('assets/images/office-long-1.png') }}"
                        alt="office content 2">
                </div>
            </div>
        </section>

    </x-ui.card>
    </div>

</x-dashboard.layout.default>
