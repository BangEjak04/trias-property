<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Produk Knowledge Developer
        </x-slot>
        <x-slot name="icon">
            <x-filament::icon icon="heroicon-o-link" class="h-5 w-5 text-gray-400" />
        </x-slot>

        @php
            $items = $this->getProductKnowledges();
        @endphp

        @if ($items->isEmpty())
            <p class="text-sm text-gray-400 italic">
                Belum ada produk yang ditambahkan.
            </p>
        @else
            <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach ($items as $item)
                    <li>
                        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer"
                            class="flex items-center justify-between gap-3 py-3 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 hover:underline transition">
                            <span>{{ $item->name }}</span>
                            <x-heroicon-m-arrow-top-right-on-square class="h-4 w-4 shrink-0 text-gray-400" />
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
