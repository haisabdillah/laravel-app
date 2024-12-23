<?php
use App\Models\User;

use function Livewire\Volt\computed;
use function Livewire\Volt\state;
use function Livewire\Volt\title;
use function Livewire\Volt\updating;
use function Livewire\Volt\usesPagination;

usesPagination();


title(fn () => $this->title);

state(['title' => 'Users']);
state(['search' => ''])->url();

$dataTable = computed(function () {
    return User::when($this->search, function ($q) {
        $q->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%');
    })->orderByDesc('id')->paginate(10);
});

updating(['search' => fn () => $this->resetPage()]);

$delete = function ($id) {
    User::find($id)->delete();
    session()->flash('success', 'User deleted successfully');
    $this->dispatch('close-modal-delete');
};

?>
<div>
    <x-layout.header-page title="{{$title}}" :breadcrumbs="[['url' => '#', 'label' => 'Users', 'icon' => false, 'current' => true]]">
        <div class="flex h-full justify-end space-x-2 items-end mb-4">
            <x-primary-button href="{{route('users.create')}}" wire:navigate > <i class="fa-solid fa-plus me-2"></i> Add User</x-primary-button>
            <x-search-input wire:model.live="search" :value="$search"></x-search-input>
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
                            Email
                        </th>
                        <th scope="col">
                            Role
                        </th>
                        <th scope="col">
                            Status
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
                        <td>
                            {{$item->email}}
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                           <x-badge color="{{$item->status ? 'green' : 'gray'}}">{{$item->status ? "Active" : "Deactive"}}</x-badge>
                        </td>
                        <td clas="flex items-center space-x-2">
                            <x-action-edit href="{{route('users.edit',$item->id)}}" wire:navigate></x-action-edit>
                            <x-action-delete x-bind="modalDeleteButton" data-route="delete" data-id="{{$item->id}}"></x-action-delete>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
         <!-- Pagination -->
         <div class="mt-4">
            {{ $this->dataTable->links() }} <!-- This renders pagination links -->
        </div>
        <x-modal.delete></x-modal.delete>
    
</div>
