<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div {{ $getExtraAttributeBag() }}>
        @php
            $file = $getState();
        @endphp

        @if ($file)
            @php
                $extension = Str::lower(Str::afterLast($file, '.'));
                $url = Storage::disk('local')->temporaryUrl($file, now()->addMinutes(30));
            @endphp

            @if ($extension === 'pdf')
                <embed type="application/pdf" src="{{ $url }}" class="w-full h-96">
            @elseif(in_array($extension, ['jpg', 'jpeg', 'png']))
                <img src="{{ $url }}" alt="{{ $file }}" class="w-full max-h-96 object-cover">
            @else
                <a href="{{ $url }}" class="text-sm text-primary-500 underline" target="_blank">
                    Download file
                </a>
            @endif
        @endif
    </div>
</x-dynamic-component>
