<?php
use Spatie\Permission\Models\Role;

use function Livewire\Volt\mount;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\title;

//Permission State
state([
    'authCanCreate' => auth()->user()->can('roles.create'),
    'authCanEdit' => auth()->user()->can('roles.edit'),
]);

title(fn () => $this->title);

//Form State
state(['data', 'name' => '']);
state(['title' => 'Add Role']);


rules(fn () => [
    'name' => 'required|string|max:30|unique:roles,name'.($this->data ? ','.$this->data->id : ''),
]);

mount(function ($role = null) {
    if ($role) {
        abort_if(!$this->authCanEdit, 403);
        $role = Role::find($role);
        $this->title = 'Edit Role';
        $this->data = $role;
        $this->name = $role->name;
    }else{
        abort_if(!$this->authCanCreate, 403);
    }
});

$store = function () {
    $validate = $this->validate();
    if ($this->data) {
        $this->data->update($validate);
        session()->flash('success', 'Role updated successfully');
    } else {
        Role::create($validate);
        session()->flash('success', 'Role created successfully');
    }
    $this->redirectRoute('roles.index', navigate: true);
}

?>
<div>
    <x-layout.header-page :title="$title" :breadcrumbs="[['url' => route('roles.index'), 'label' => 'Roles', 'icon' => false],['url' => '', 'label' => $title, 'icon' => false,'current' => true]]"/>
    <div class="container">
        <form class="max-w-md" wire:submit.prevent="store">
            <x-form.input wire:model="name" name="name" id="name" label="Name" required   />
            <div class="flex space-x-2">
                <a href="{{ route('roles.index') }}" wire:navigate>
                    <x-secondary-button type="button"> <!-- Set a fixed width -->
                        <i class="fa-solid fa-arrow-left me-2"></i>Cancel
                    </x-secondary-button>
                </a>
                <x-primary-button type="submit"> <!-- Set the same fixed width -->
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
