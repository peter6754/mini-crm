<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $ticket->theme }}</h1>
                    <div class="flex items-center space-x-4">
                        @switch($ticket->status)
                            @case('new')
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    Новый
                                </span>
                                @break
                            @case('in_progress')
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    В работе
                                </span>
                                @break
                            @case('done')
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    Выполнен
                                </span>
                                @break
                        @endswitch
                        <a href="/admin"
                            class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                            &larr; Назад к списку
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Сообщение</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ticket->text }}</p>
                        </div>

                        @if($ticket->answered_at)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Ответ дан</h3>
                                <p class="text-sm text-gray-900 dark:text-white">
                                    {{ $ticket->answered_at->isoFormat('DD.MM.YYYY HH:mm') }}
                                </p>
                            </div>
                        @endif

                        @if($ticket->media->count() > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                    Вложения ({{ $ticket->media->count() }})
                                </h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($ticket->media as $media)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-xs">
                                                        {{ $media->file_name }}
                                                    </span>
                                                </div>
                                                <a href="{{ $media->getUrl() }}" target="_blank"
                                                    class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                                    Скачать
                                                </a>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $media->size }} bytes • {{ $media->mime_type }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Информация о клиенте</h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Имя</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $ticket->customer->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Телефон</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <a href="tel:{{ $ticket->customer->phone }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                        {{ $ticket->customer->phone }}
                                    </a>
                                </dd>
                            </div>
                            @if($ticket->customer->email)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a href="mailto:{{ $ticket->customer->email }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                            {{ $ticket->customer->email }}
                                        </a>
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Всего тикетов</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $ticket->customer->tickets->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Информация о тикете</h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Создан</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $ticket->created_at->isoFormat('DD.MM.YYYY HH:mm') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Обновлен</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $ticket->updated_at->isoFormat('DD.MM.YYYY HH:mm') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Статус</dt>
                                <dd class="mt-1">
                                    <form method="POST" action="/admin/tickets/{{ $ticket->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex flex-col space-y-2">
                                            <button type="submit" name="status" value="new"
                                                    class="px-3 py-2 text-sm font-medium rounded-md text-left @if($ticket->status === 'new') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @else bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 @endif transition-colors">
                                                новый
                                            </button>
                                            <button type="submit" name="status" value="in_progress"
                                                    class="px-3 py-2 text-sm font-medium rounded-md text-left @if($ticket->status === 'in_progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @else bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 @endif transition-colors">
                                                В работе
                                            </button>
                                            <button type="submit" name="status" value="done"
                                                    class="px-3 py-2 text-sm font-medium rounded-md text-left @if($ticket->status === 'done') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @else bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 @endif transition-colors">
                                                выполнен
                                            </button>
                                        </div>
                                    </form>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
