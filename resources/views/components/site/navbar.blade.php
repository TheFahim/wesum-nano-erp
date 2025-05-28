@php

    function active($route)
    {
        return request()->route()->named($route) ? 'font-bold' : '';
    }

    function aboutUs()
    {
        $aboutUsLink = '';


        if (request()->route()->named('site.teams') || request()->route()->named('site.galleries')) {
            $aboutUsLink = 'font-bold';
        }

        return $aboutUsLink;
    }

@endphp


<nav id="header" class="fixed w-full z-30 top-0 text-white shadow-lg">
    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
        <div class="pl-4">
            <a class="flex items-center toggleColour text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                href="{{ route('index') }}">
                <!--Icon from: http://www.potlabicons.com/ -->

                <img src="{{ asset('assets/images/HPC-logo.jpeg') }}" class="rounded-full h-12 me-3" alt="Site Logo" />
                <span
                    class="self-center text-2xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">DANIOX</span>

            </a>
        </div>
        <div class="block lg:hidden pr-4">
            <button id="nav-toggle"
                class="flex items-center p-1 text-white hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
        </div>
        <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto hidden mt-2 lg:mt-0 text-white bg-white lg:bg-transparent p-4 lg:p-0 z-20"
            id="nav-content">
            <ul class="list-reset lg:flex justify-end flex-1 items-center">
                <li class="mr-3">
                    <a class="inline-block text-lg py-2 px-4 {{ active('index') }} hover:font-bold no-underline"
                        href="{{ route('index') }}">Home</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block text-lg {{ active('site.techs') }} no-underline hover:font-bold py-2 px-4"
                        href="{{ route('site.techs') }}">Technologies</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block text-lg {{ active('site.services') }} {{ active('site.service')}} no-underline hover:font-bold py-2 px-4"
                        href="{{ route('site.services') }}">Service</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block text-lg {{ active('site.publication') }} no-underline hover:font-bold py-2 px-4"
                        href="{{ route('site.publication') }}">Publication</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block text-lg {{ active('site.news') }} no-underline hover:font-bold py-2 px-4"
                        href="{{ route('site.news') }}">News</a>
                </li>
                <li class="mr-3">
                    <a class="inline-block text-lg {{ active('site.blogs') }} no-underline hover:font-bold py-2 px-4"
                        href="{{ route('site.blogs') }}">Blog</a>
                </li>
                <li class="mr-3">
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-3 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0  md:p-0 md:w-auto dark:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent hover:font-bold {{aboutUs()}}">About Us
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg></button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar"
                        class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{ route('site.teams') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Team Memebers</a>
                            </li>
                            <li>
                                <a href="{{route('site.galleries')}}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Galleries</a>
                            </li>

                        </ul>

                    </div>
                </li>

            </ul>
            <a href="{{ route('site.contacts') }}"
                class="mx-auto text-lg lg:mx-0 hover:underline contact-btn text-gray-800 font-bold rounded-full mt-4 lg:mt-0 py-4 px-8 shadow opacity-75 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Contact us
            </a>
        </div>
    </div>
    <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
</nav>






<div class="mt-32"></div>

<script>
    const toggleBtn = document.getElementById('theme-toggle');
    if (toggleBtn) {

        let themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        let themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {

            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }

        });
    }
</script>
