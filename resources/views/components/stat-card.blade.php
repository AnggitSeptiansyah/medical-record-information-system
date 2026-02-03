<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-{{ $color }}-500 rounded-md p-3">
                {{ $icon }}
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($value) }}</p>
            </div>
        </div>
    </div>
</div>