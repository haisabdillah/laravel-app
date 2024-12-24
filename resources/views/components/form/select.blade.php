@props(['id', 'name', 'label', 'options', 'selected' => '', 'class' => '', 'placeholder' => null, 'required' => false])

<div class="mb-5">
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-base-900 dark:text-white">{{ $label }} {{$required ? '*' : null}}</label>
    <select id="{{ $id }}" name="{{ $name }}  @if($required) required @endif  @if($errors->has($name)) autofocus @endif"
            {{ $attributes->merge([
                'class' => 'bg-base-50 text-base-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 dark:bg-base-700 dark:border-base-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' . 
                ($errors->has($name) ? ' border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-600 dark:focus:ring-red-600 dark:focus:border-red-600' : '') 
            ]) }}>
        <option value="" selected>{{ $placeholder ?? 'Select '.$label }}</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
