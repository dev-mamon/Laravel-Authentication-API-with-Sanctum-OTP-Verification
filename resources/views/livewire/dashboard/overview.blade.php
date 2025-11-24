<main class="flex-1 overflow-y-auto p-6">
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-500 mt-1">
                Welcome back! Here's your overview.
            </p>

            {{-- Welcome Message --}}
            <div class="mt-4 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-md">
                <p class="text-sm">
                    Hello, <span class="font-semibold">{{ auth()->user()->name ?? 'User' }}</span>!
                    We're glad to have you back. Check out your latest updates and settings below.
                </p>
            </div>
        </div>
    </div>
</main>
