<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Админ панель</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Добро пожаловать, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="/admin/tickets"
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Тикеты</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                {{ \App\Models\Ticket::count() }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">Перейти к списку
                            &rarr;</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>