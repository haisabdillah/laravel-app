<?php
use function Livewire\Volt\{layout,state,rules,mount};
use App\Models\User;

layout('layouts.app');

//Form State
state(['data','name' => '','email' => '','password' => '','status'=> '']);

//Select State
state(['selectStatus' => [0=>'Inactive',1=>'Active']]);


rules(fn()=> [
    'name' => 'required|string|max:30',
    'email' => 'required|email|max:30|unique:users'.($this->data ? ',email,'.$this->data->id : ''),
    'password' => ($this->data ? 'nullable' : 'required' ).'|string|min:8',
    'status' => 'required|boolean'
]);


mount(function ($user = null) {
    if ($user) {
        $user = User::find($user);
        $this->data = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
    }
});

$store = function(){
    $validate = $this->validate();
    $validate['password'] = $validate['password'] ? bcrypt($validate['password']) : $this->data->password;
    if ($this->data) {
        $this->data->update($validate);
        session()->flash('success', 'User updated successfully');
    }
    else {
        User::create($validate);
        session()->flash('success', 'User created successfully');
    }
    $this->redirectRoute('users.index',navigate:true);
}


?>

<div class="container">
    <form class="max-w-md" wire:submit.prevent="store">
        <x-form-select wire:model="status" name="status" id="status" label="Status" :options="$selectStatus" required />
        <x-form-input wire:model="name" name="name" id="name" label="Name" required   />
        <x-form-input wire:model="email" name="email" id="email" label="Email" type="email" required  />
        <x-form-input wire:model="password" name="password" id="password" label="Password" type="password"  required={{!isset($data)}}  />
        <x-primary-button type="submit">Save</x-primary-button>
    </form>
</div>
