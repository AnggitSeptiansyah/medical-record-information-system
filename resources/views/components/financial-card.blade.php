<div class="bg-gradient-to-br from-{{ $color }}-50 to-{{ $color }}-100 overflow-hidden shadow-lg sm:rounded-lg border border-{{ $color }}-200">
    <div class="p-6">
        <div class="flex items-center justify-between mb-2">
            <p class="text-sm font-medium text-{{ $color }}-800">{{ $title }}</p>
            @if($trend)
                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-{{ $color }}-200 text-{{ $color }}-800">
                    {{ $trend }}
                </span>
            @endif
        </div>
        
        <div class="flex items-baseline">
            <p class="text-2xl font-bold text-{{ $color }}-900">
                {{ $amount }}
            </p>
        </div>

        @if($subtitle)
            <p class="text-xs text-{{ $color }}-700 mt-2">{{ $subtitle }}</p>
        @endif
    </div>
</div>