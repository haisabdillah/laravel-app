<?php
use function Livewire\Volt\{layout,title,computed,state,usesPagination,with,updating};
use App\Models\User;
usesPagination();
layout('layouts.app');
title('Users');

state(['search' => '','cursor' => ''])->url();

$dataTable = computed(function () {
    return User::when($this->search, function($q) {
    $q->where('name', 'like', '%'.$this->search.'%')
    ->orWhere('email', 'like', '%'.$this->search.'%');
    })->orderByDesc('id')->paginate(10);
});

updating(['search' => fn () => $this->resetPage()]);

$delete = function($id){
    User::find($id)->delete();
    session()->flash('success', 'User deleted successfully');
};
 

?>

<div class="container">
    <div class="flex w-full justify-between items-center mb-4">
        <x-primary-button href="{{route('users.create')}}" wire:navigate >Create</x-primary-button>
        <x-search-input wire:model.live="search" :value="$search"></x-search-input>
    </div>
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
                        <x-action-delete wire:click="delete({{$item->id}})"></x-action-delete>
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
</div>
