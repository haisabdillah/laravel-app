<?php
use Spatie\Permission\Models\Role;

use function Livewire\Volt\computed;
use function Livewire\Volt\state;
use function Livewire\Volt\title;
use function Livewire\Volt\updating;
use function Livewire\Volt\usesPagination;

usesPagination();


title(fn () => $this->title);

state(['title' => 'Roles']);

$dataTable = computed(function () {
    return Role::select('id','name')->get();
});

$delete = function ($id) {
    Role::find($id)->delete();
    session()->flash('success', 'Role deleted successfully');
    $this->dispatch('close-modal-delete');
};

?>
<div>
    <x-layout.header-page title="{{$title}}" :breadcrumbs="[['url' => '#', 'label' => 'Roles', 'icon' => false, 'current' => true]]">
        <div class="flex h-full justify-end space-x-2 items-end mb-4">
            <x-primary-button href="{{route('roles.create')}}" wire:navigate > <i class="fa-solid fa-plus me-2"></i> Add Role</x-primary-button>
        </div>
    </x-layout.header-page>
   
        <div class="relative overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->dataTable as $item)
                    <tr>
                        <th scope="col">
                            {{$item->name}}
                        </th>
                        <td clas="flex items-center space-x-2">
                            <x-action-edit href="{{route('roles.edit',$item->id)}}" wire:navigate></x-action-edit>
                            <x-action-delete x-bind="modalDeleteButton" data-route="delete" data-id="{{$item->id}}"></x-action-delete>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <x-modal.delete></x-modal.delete>
   
</div>
