<div>
    @isset($label)
        <label for="{{ $name }}">
            {{ $label }}:
        </label> <br>
    @endisset

    <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder  }}"
            class="@if($errors->has($name)) error-border @endif {{ $class }}"
            value="{{ old($name) }}"
    >
    @error($name) <div class="error">{{ $message }}</div> @enderror
</div>