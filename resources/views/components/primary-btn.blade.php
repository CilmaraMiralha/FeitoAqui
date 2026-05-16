@props([
    'name'=>null,
    'type'=>'submit',
    'variant' => 'neutral',
])

@php
    $baseClasses = 'inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-semibold text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
    $variantClasses = match ($variant) {
        'confirm' => 'bg-[#5D8550] hover:bg-[#4f7344] focus:ring-[#5D8550]',
        'danger' => 'bg-[#B90053] hover:bg-[#9b0047] focus:ring-[#B90053]',
        default => 'bg-[#AC6C45] hover:bg-[#925A39] focus:ring-[#AC6C45]',
    };
@endphp

<div>
    <button name="{{ $name }}" type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses]) }}>
        {{ $slot }}
    </button>
</div>
