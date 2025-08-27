@props(['checked' => false, 'disabled' => false, 'id' => null])

<span class="inline-flex items-center">
    {{-- Always send 0 when unchecked --}}
    <input type="hidden" name="{{ $attributes->get('name') }}" value="0">

    <input
        id="{{ $id ?? $attributes->get('name') }}"
        type="checkbox"
        value="1"
        @checked($checked)
    >
</span>
