@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-800']) }}>
        {{ $status }}
    </div>
@endif
