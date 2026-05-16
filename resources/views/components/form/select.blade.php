@props([
'name',
'label' => null,
'options' => [],
'placeholder' => 'Select one'
])

@php
$id = $attributes->get('id') ?? $name;
$selected = old($name, $attributes->get('selected') ?? null);
@endphp

<div class="mb-4">
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium mb-1">{{ $label }}</label>
    @endif
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'border rounded px-3 py-2 w-full']) }}>
        @if($placeholder)
        <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($options as $value => $label)
        <option value="{{ $value }}" @selected((string)$value===(string)$selected)>{{ $label }}</option>
        @endforeach
    </select>
    @error($name)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>