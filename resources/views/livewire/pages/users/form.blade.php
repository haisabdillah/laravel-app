<?php
use App\Models\User;
use Spatie\Permission\Models\Role;
use function Livewire\Volt\mount;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\title;
use Illuminate\Support\Arr;

title(fn () => $this->title);
state(['title' => 'Add User']);


//Form State
state(['data', 'name', 'email', 'password', 'status','role']);


//Select State
state(['selectStatus' => [0 => 'Inactive', 1 => 'Active'],
        'selectRole' => Role::pluck('name','name')
      ]);

rules(fn () => [
    'name' => 'required|string|max:30',
    'email' => 'required|email|max:30|unique:users'.($this->data ? ',email,'.$this->data->id : ''),
    'password' => ($this->data ? 'nullable' : 'required').'|string|min:8',
    'status' => 'required|boolean',
    'role' => 'required|exists:roles,name',
]);

mount(function ($user = null) {
    if ($user) {
        $user = User::with('roles')->find($user);
        $this->title = 'Edit User';
        $this->data = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->role = $user->getRoleNames()[0] ?? null;
    }
});

$store = function () {
    $validate = $this->validate();
    $validate['password'] = $validate['password'] ? bcrypt($validate['password']) : $this->data->password;
    if ($this->data) {
        $this->data->update(Arr::except($validate, ['role']));
        $this->data->syncRoles([$validate['role']]);
        session()->flash('success', 'User updated successfully');
    } else {
        $user = User::create(Arr::except($validate, ['role']));
        $user->syncRoles([$validate['role']]);
        session()->flash('success', 'User created successfully');
    }
    $this->redirectRoute('users.index', navigate: true);
}

?>
<div>
    <x-layout.header-page :title="$title" :breadcrumbs="[['url' => route('users.index'), 'label' => 'Users', 'icon' => false],['url' => '', 'label' => $title, 'icon' => false,'current' => true]]"/>
    <div class="container">
     
        <form class="max-w-md" wire:submit.prevent="store">
            <x-form.select wire:model="status" name="status" id="status" label="Status" :options="$selectStatus" required />
            <x-form.select wire:model="role" name="role" id="role" label="Role" :options="$selectRole" required />
            <x-form.input wire:model="name" name="name" id="name" label="Name" required   />
            <x-form.input wire:model="email" name="email" id="email" label="Email" type="email" required  />
            <x-form.input wire:model="password" name="password" id="password" label="Password" type="password"  required={{!isset($data)}}  />
            <div class="flex space-x-2">
                <a href="{{ route('users.index') }}" wire:navigate>
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
