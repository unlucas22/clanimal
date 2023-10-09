<div class="p-6 bg-white rounded-lg shadow" style="min-height: 265px;border: {{ $color }} solid 2px;">
    
    {{ $icon ?? '' }}

    <a href="{{ $link }}">
        <h5 class="mb-2 text-2xl font-semibold tracking-tight" style="color: {{ $color }}">{{ $title }}</h5>
    </a>
    <div class="mb-3 text-3xl font-semibold text-black text-center">{{ $subtitle ?? '' }}</div>

    <a href="{{ $link }}" class="inline-flex items-center hover:underline" style="color: {{ $color }};">{{ $body ?? '' }}</a>
</div>
