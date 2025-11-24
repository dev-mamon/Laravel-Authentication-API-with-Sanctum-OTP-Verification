        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-[hsl(222,47%,11%)] text-[hsl(210,40%,98%)] shadow-xl transition-all duration-300 fixed lg:static -translate-x-full lg:translate-x-0 z-50 w-64 h-screen"
            data-collapsed="false">
            <!-- Sidebar Header -->
            <div class="flex h-16 items-center justify-center border-b border-[hsl(222,47%,15%)]">
                <div class="flex items-center gap-3">
                    <svg id="sidebarIcon" class="hidden h-6 w-6 text-[hsl(217,91%,60%)]" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
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
                        <a href="index.html"
                            class="sidebar_links flex items-center gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-layout-dashboard h-5 w-5 flex-shrink-0">
                                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                            </svg>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <p>content management system __</p>
                    <li>
                        <a href="index.html"
                            class="sidebar_links flex items-center gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-layout-dashboard h-5 w-5 flex-shrink-0">
                                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                            </svg>
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- Pages Dropdown -->
                    <li>
                        <button onclick="toggleDropdown(this)"
                            class="sidebar_links flex w-full items-center justify-between gap-3 rounded-lg px-3 py-2 transition-colors hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)]">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-package h-5 w-5 flex-shrink-0">
                                    <path
                                        d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z">
                                    </path>
                                    <path d="M12 22V12"></path>
                                    <path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path>
                                    <path d="m7.5 4.27 9 5.15"></path>
                                </svg>
                                <span class="sidebar-text">Pages</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-chevron-right h-4 w-4 dropdown-icon">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu hidden ml-6 space-y-1">
                            <li>
                                <a href="/pages/login"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href="/pages/register"
                                    class="block px-3 py-2 text-sm hover:bg-[hsl(222,47%,20%)] hover:text-[hsl(217,91%,60%)] rounded-lg sidebar-text">
                                    Register
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

        </aside>
