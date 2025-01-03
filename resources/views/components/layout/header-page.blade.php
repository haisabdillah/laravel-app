@props(['title', 'breadcrumbs' => []])

<div class="contaner w-full flex-wrap pb-6 pt-4">
    <div class="flex">
        <div>
            <h2 class="mb-4 font-extrabold leading-none tracking-tight text-[25.888px] ">{{$title}}</h2>
            @if (!empty($breadcrumbs))
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{route('dashboard')}}" wire:navigate class="inline-flex items-center text-sm font-medium text-base-700 hover:text-blue-600 dark:text-base-400 dark:hover:text-base-200">
                          <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                          </svg>
                          Home
                        </a>
                      </li>
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="inline-flex items-center">
                            @if ($breadcrumb['icon'])
                                <a href="{{ $breadcrumb['url'] }}" wire:navigate class="inline-flex items-center text-sm font-medium text-base-700 hover:text-blue-600 dark:text-base-400 dark:hover:text-base-200">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                    </svg>
                                    {{ $breadcrumb['label'] }}
                                </a>
                            @elseif (isset($breadcrumb['current']) && $breadcrumb['current'])
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 text-base-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="ms-1 text-sm font-medium text-base-500 md:ms-2 dark:text-base-400">{{ $breadcrumb['label'] }}</span>
                                </div>
                            @else
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 text-base-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <a href="{{ $breadcrumb['url'] }}" wire:navigate class="ms-1 text-sm font-medium text-base-700 hover:text-blue-600 md:ms-2 dark:text-base-400 dark:hover:text-base-200">{{ $breadcrumb['label'] }}</a>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
            @endif
        </div>
        <div class="flex-1 pl-4 ">
            {{$slot}}
        </div>
    </div>
</div>