<textarea
    {{ $attributes }}
    x-data="{ resize: () => { $el.style.height = `5px`; $el.style.height = $el.scrollHeight + `px` } }"
    x-init="resize()"
    x-on:input="resize()"
    wire:ignore
></textarea>
