<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-base-800 dark:bg-base-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-base-700 dark:hover:bg-white focus:bg-base-700 dark:focus:bg-white active:bg-base-900 dark:active:bg-base-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition no-wrap ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
