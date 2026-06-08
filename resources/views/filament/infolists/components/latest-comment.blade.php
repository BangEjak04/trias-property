<div class="space-y-4 transition-all">
    @if ($getState() && $getState()->count() > 0)
        @foreach ($getState() as $comment)
            <div class="py-4">
                <div class="flex items-start gap-x-4">
                    <div class="shrink-0">
                        <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white">
                            {{ $comment->user ? substr($comment->user->name, 0, 1) : '?' }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                <span>
                                    {{ $comment->user->name ?? 'Unknown User' }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    | {{ ($role = $comment->user?->getRoleNames()?->first()) ? Str::headline($role) : 'Unknown Role' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-2">
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </div>

                            @if (auth()->user()->hasRole(['super_admin']) || $comment->user_id === auth()->id())
                                <div class="flex gap-x-1">
                                    <!-- Delete Button -->
                                    <button type="button"
                                        wire:click="$dispatch('open-modal', { id: 'confirm-comment-deletion-{{ $comment->id }}' })"
                                        class="p-1 text-gray-400 hover:text-red-500 transition-colors rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                                        title="{{ __('application.comment.delete.title') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <x-filament::modal id="confirm-comment-deletion-{{ $comment->id }}"
                                        icon="heroicon-o-trash" icon-color="danger" heading="{{ __('application.comment.delete.heading') }}"
                                        width="md">
                                        <div class="py-4">
                                            {{ __('application.comment.delete.description') }}
                                        </div>

                                        <x-slot name="footerActions">
                                            <x-filament::button
                                                wire:click="$dispatch('close-modal', { id: 'confirm-comment-deletion-{{ $comment->id }}' })"
                                                color="gray">
                                                {{ __('application.comment.delete.action.cancel') }}
                                            </x-filament::button>

                                            <x-filament::button wire:click="handleDeleteComment({{ $comment->id }})"
                                                wire:loading.attr="disabled" color="danger">
                                                {{ __('application.comment.delete.action.confirm') }}
                                            </x-filament::button>
                                        </x-slot>
                                    </x-filament::modal>
                                </div>
                            @endif
                        </div>
                        <div
                            class="mt-2 prose prose-sm max-w-none dark:prose-invert text-gray-700 dark:text-white border-l-4 border-blue-200 dark:border-blue-800 pl-3">
                            {!! $comment->body !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div
            class="flex items-center justify-center gap-x-2 py-6 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-messages-square-icon lucide-messages-square">
                <path
                    d="M16 10a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 14.286V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                <path
                    d="M20 9a2 2 0 0 1 2 2v10.286a.71.71 0 0 1-1.212.502l-2.202-2.202A2 2 0 0 0 17.172 19H10a2 2 0 0 1-2-2v-1" />
            </svg>
            <span class="text-sm font-medium">{{ __('application.comment.no_comments') }}</span>
        </div>
    @endif
</div>
