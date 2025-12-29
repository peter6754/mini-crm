<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                <p class="mt-2 text-gray-600">Welcome to the admin panel, {{ auth()->user()->name }}!</p>
            </div>
        </div>
    </div>
</x-app-layout>
