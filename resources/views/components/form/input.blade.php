@props([
'name',
'label' => null,
'type' => 'text',
'value' => null,
'placeholder' => '',
])

@php
$id = $attributes->get('id') ?? $name;
$value = old($name, $value);
@endphp

<div class="mb-4">
    @if($label)
    <label for="{{ $id }}" class="mb-1 block text-sm font-medium text-[#4D2D52]">{{ $label }}</label>
    @endif
    @if($type === 'file')
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        {{ $attributes->merge(['class' => 'w-full rounded-xl border border-[#DA98E0] bg-white px-3 py-2 text-[#4D2D52] file:mr-3 file:rounded-lg file:border-0 file:bg-[#AC6C45] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-[#4D2D52] focus:outline-none focus:ring-2 focus:ring-[#DA98E0]']) }} />
    @else
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full rounded-xl border border-[#DA98E0] bg-white px-3 py-2 text-[#4D2D52] placeholder:text-[#4D2D52]/60 focus:border-[#4D2D52] focus:outline-none focus:ring-2 focus:ring-[#DA98E0]']) }} />
    @endif
    @error($name)
    <p class="mt-1 text-sm text-[#B90053]">{{ $message }}</p>
    @enderror
</div>
