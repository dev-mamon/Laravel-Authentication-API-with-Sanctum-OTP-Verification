<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    @livewireStyles
</head>

<body>
    <div class="flex h-screen overflow-hidden">
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 lg:hidden"></div>

        <button id="mobileSidebarButton" class="lg:hidden p-2 text-gray-800 bg-white rounded-md fixed top-3 left-4 z-10">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <aside id="sidebar"
            class="bg-[hsl(222,47%,11%)] text-[hsl(210,40%,98%)] shadow-xl transition-all duration-300 fixed lg:static -translate-x-full lg:translate-x-0 z-50 w-64 h-screen"
            data-collapsed="false">

            <div class="flex h-16 items-center justify-center border-b border-[hsl(222,47%,15%)]">
                <div class="flex items-center gap-3">
                    <svg id="sidebarIcon" class="hidden h-6 w-6 text-[hsl(217,91%,60%)]"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                        <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                        <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                        <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                    </svg>
                    <h1 id="sidebarTitle" class="text-xl font-bold text-[hsl(217,91%,60%)]">
                        AdminPro
                    </h1>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 no-scrollbar">
                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a wire:navigate href="{{ route('dashboard') }}"
                            class="sidebar_links flex items-center gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-layout-dashboard h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                            </svg>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- Fashion -->
                    <li>
                        <a href="{{ route('fashions') }}"
                            class="sidebar_links flex items-center gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-layout-dashboard h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                            </svg>
                            <span class="sidebar-text">Fashion</span>
                        </a>
                    </li>
                    {{--
                    <!-- Home -->
                    <li>
                        <button onclick="toggleDropdown(this)"
                            class="sidebar_links flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)]">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-home h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9.5L12 3l9 6.5V21a1 1 0 0 1-1 1h-6v-6H10v6H4a1 1 0 0 1-1-1z"></path>
                                </svg>
                                <span class="sidebar-text">Home</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="lucide lucide-chevron-right h-4 w-4 dropdown-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu hidden ml-6 space-y-1">
                            <li>
                                <a wire:navigate href="/pages/login"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Banner Section
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/pages/register"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    How It Works
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Journaling -->
                    <li>
                        <button onclick="toggleDropdown(this)"
                            class="sidebar_links flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)]">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-notebook h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M4 19V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v14"></path>
                                    <path d="M8 7h6"></path>
                                    <path d="M8 11h6"></path>
                                    <path d="M8 15h6"></path>
                                </svg>
                                <span class="sidebar-text">Journaling</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="lucide lucide-chevron-right h-4 w-4 dropdown-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu hidden ml-6 space-y-1">
                            <li>
                                <a wire:navigate href="/journal/banner"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Banner Section
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/journal/how-it-works"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    How It Works
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Fashion -->
                    <li>
                        <button onclick="toggleDropdown(this)"
                            class="sidebar_links flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)]">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-shirt h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M4 3l5 2 3-2 3 2 5-2v4l-3 2v12H7V9L4 7V3z"></path>
                                </svg>
                                <span class="sidebar-text">Fashion</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="lucide lucide-chevron-right h-4 w-4 dropdown-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu hidden ml-6 space-y-1">
                            <li>
                                <a wire:navigate href="/fashion/banner"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Banner Section
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/fashion/how-it-works"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    How It Works
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Finance -->
                    <li>
                        <button onclick="toggleDropdown(this)"
                            class="sidebar_links flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)]">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-wallet h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M2 7h20v10H2z"></path>
                                    <path d="M16 13h2"></path>
                                </svg>
                                <span class="sidebar-text">Finance</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="lucide lucide-chevron-right h-4 w-4 dropdown-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu hidden ml-6 space-y-1">
                            <li>
                                <a wire:navigate href="/finance/banner"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Banner Section
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/finance/how-it-works"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    How It Works
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Creative Design -->
                    <li>
                        <button onclick="toggleDropdown(this)"
                            class="sidebar_links flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)]">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-palette h-5 w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="13.5" cy="6.5" r=".5"></circle>
                                    <circle cx="17.5" cy="10.5" r=".5"></circle>
                                    <circle cx="8.5" cy="7.5" r=".5"></circle>
                                    <circle cx="6.5" cy="12.5" r=".5"></circle>
                                    <path d="M12 3a9 9 0 1 0 0 18c2 0 3-1 3-2s-1-2-2-2-2-1-2-2 1-2 2-2 2-1 2-2-1-2-2-2">
                                    </path>
                                </svg>
                                <span class="sidebar-text">Creative Design</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="lucide lucide-chevron-right h-4 w-4 dropdown-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu hidden ml-6 space-y-1">
                            <li>
                                <a wire:navigate href="/creative/banner"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Banner Section
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="/creative/how-it-works"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    How It Works
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </nav>

        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex h-16 items-center justify-between border-b bg-white px-6 shadow-sm">
                <div class="flex items-center gap-4 flex-1">
                    <button id="toggleSidebarButton"
                        class="inline-flex items-center justify-center rounded-md text-sm font-medium hover:bg-gray-100 h-10 w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-menu h-5 w-5">
                            <line x1="4" x2="20" y1="12" y2="12"></line>
                            <line x1="4" x2="20" y1="6" y2="6"></line>
                            <line x1="4" x2="20" y1="18" y2="18"></line>
                        </svg>
                    </button>
                    <div class="relative max-w-md w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-search absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input type="search"
                            class="w-full rounded-full border-none bg-gray-100 px-10 py-2 text-sm focus:ring-2 focus:ring-[hsl(217,91%,60%)]"
                            placeholder="Search..." />
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button
                        class="relative h-10 w-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                        <i class="fas fa-bell text-gray-700 text-lg"></i>
                        <span
                            class="absolute top-1 right-1 h-4 w-4 bg-blue-600 text-white text-[10px] rounded-full flex items-center justify-center">3</span>
                    </button>

                    <div class="relative">
                        <button id="profileButton"
                            class="flex items-center gap-2 hover:bg-gray-100 rounded-full px-2 py-1 transition">
                            <img src="https://i.pravatar.cc/40" alt="Profile"
                                class="h-8 w-8 rounded-full border border-gray-200" />
                            <span class="text-sm font-medium text-gray-800 hidden md:block">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs hidden md:block"></i>
                        </button>

                        <div id="profileDropdown"
                            class="hidden absolute right-0 mt-3 w-60 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@admin.com' }}</p>
                            </div>
                            <button
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                <i class="fas fa-cog w-4"></i> Settings
                            </button>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                    <i class="fas fa-sign-out-alt w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>

</html>
