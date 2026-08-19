@props(['label', 'value'])

<div {{ $attributes->class(['flex items-center gap-3']) }}>
    <div class="p-2.5 bg-white text-navy rounded-xl shadow-sm border border-gray-100">
        {{ $icon ?? '' }}
    </div>
    <div>
        <span class="text-[10px] text-gray-400 font-medium block uppercase tracking-wider">
            {{ $label }}
        </span>
        <span class="font-bold text-navy">
            {{ $value }}
        </span>
    </div>
</div>