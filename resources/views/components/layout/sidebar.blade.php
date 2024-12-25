<?php
  $navlinks = [
            [
                'name' => 'Dashboard',
                'route' => 'dashboard',
                'icon' => 'fa-gauge',
            ],
            [
                'name' => 'Users',
                'route' => 'users.index',
                'icon' => 'fa-users',
            ],
            [
                'name' => 'Roles',
                'route' => 'roles.index',
                'permission' => 'roles.view',
                'icon' => 'fa-key',
            ],
        ];
?>
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-base-200 sm:translate-x-0 dark:bg-base-800 dark:border-base-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-base-800">
      <ul class="space-y-2 font-medium">
         @foreach ($navlinks as $item)
         @if (isset($item['permission']))
            @can($item['permission'])
            <li>
               <a href="{{route($item['route'])}}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-base-100 dark:hover:bg-base-700 group">
                  <i class="fa-solid {{$item['icon']}}"></i>
                  <span class="ms-3">{{$item['name']}}</span>
               </a>
            </li>
            @endcan
         @else
         <li>
            <a href="{{route($item['route'])}}" wire:navigate class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-base-100 dark:hover:bg-base-700 group">
               <i class="fa-solid {{$item['icon']}}"></i>
               <span class="ms-3">{{$item['name']}}</span>
            </a>
         </li>
         @endif
         @endforeach
        
      </ul>
   </div>
</aside>