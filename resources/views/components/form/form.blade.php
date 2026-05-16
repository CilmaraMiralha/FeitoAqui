@props([
'action'=> null,
'method'=> null,
])


<form method="{{ $method }}" action="{{ $action }}" enctype="multipart/form-data" class="space-y-4">
    {{ $slot }}
</form>
