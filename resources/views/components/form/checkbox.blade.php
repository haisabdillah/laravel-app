@props(['id', 'name', 'label', 'required' => false])

<div class="">
    <label for="{{ $id }}" class="inline-flex items-center">
        <input type="checkbox"
               id="{{ $id }}"
               name="{{ $name }}"
               {{$attributes->merge([
                   'class' => 'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 
                              focus:ring-2 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 
                              dark:focus:ring-offset-gray-800' . 
                              ($errors->has($name) ? ' border-red-500 focus:ring-red-500' : '')
               ])}}
               @if($required) required @endif 
               @if($errors->has($name)) autofocus @endif
        />
        <span class="ml-2 text-sm font-medium  ">{{ $label }} {{$required ? '*' : null}}</span>
    </label>
    @error($name)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>