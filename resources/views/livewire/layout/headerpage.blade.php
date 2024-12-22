<?php
use function Livewire\Volt\state;
    state(['title' => '']);
?>
<div class="contaner w-full mb-4">
        <!-- <x-breadcrumb :items="$breadcrumbs ?? []"></x-breadcrumb> -->
        <h2 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-3xl dark:text-white">{{$title}}</h2>
</div>