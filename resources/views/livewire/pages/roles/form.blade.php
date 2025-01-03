<?php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;


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
state(['data', 'name' => '','permissions' => []]);
state(['title' => 'Add Role']);


state(['selectPermissions' => function() {
    $permissions = Permission::orderBy('id')->pluck("name");
    $structuredPermissions = [];

    foreach ($permissions as $value) {
         $splitPermission = explode('.', $value);
         $structuredPermissions[$splitPermission[0]][] = $splitPermission[1];
    }
    return $structuredPermissions;
}]);


rules(fn () => [
    'name' => 'required|string|max:30|unique:roles,name'.($this->data ? ','.$this->data->id : ''),
    'permissions' => 'required|array',
]);

mount(function ($role = null) {
    if ($role) {
        abort_if(!$this->authCanEdit, 403);
        $role = Role::with('permissions')->find($role);
        $this->title = 'Edit Role';
        $this->data = $role;
        $this->name = $role->name;
        $this->permissions = $role->getAllPermissions()->pluck('name')->toArray();
    }else{
        abort_if(!$this->authCanCreate, 403);
    }
});

$store = function () {
    $validate = $this->validate();
    if ($this->data) {
        $this->data->update(Arr::except($validate,['permissions']));
        $this->data->syncPermissions($validate['permissions']);
        session()->flash('success', 'Role updated successfully');
    } else {
        $role=Role::create(Arr::except($validate,['permissions']));
        $role->syncPermissions($validate['permissions']);
        session()->flash('success', 'Role created successfully');
    }
    $this->redirectRoute('roles.index', navigate: true);
}

?>
<div>
    <x-layout.header-page :title="$title" :breadcrumbs="[['url' => route('roles.index'), 'label' => 'Roles', 'icon' => false],['url' => '', 'label' => $title, 'icon' => false,'current' => true]]"/>
    <div class="container">
        <form wire:submit.prevent="store">
            <x-form.input wire:model="name" class="max-w-md"  name="name" id="name" label="Name" required   />
            <div class="relative overflow-x-auto">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                               
                            </td>
                            <td>
                               
                            </td>
                            <td>
                                <div class="text-blue-500 hover:underline hover:cursor-pointer"> All | None </div>
                            </td>
                        </tr>
                        @foreach ($selectPermissions as $key => $item)
                        <tr>
                            <td>
                                {{ucFirst($key)}}
                            </td>
                            <td>
                                <div class="flex space-x-2 justify-start items-center">
                                @foreach ($item as $action )
                                    <x-form.checkbox wire:model="permissions"  :value="$key.'.'.$action"  :label="ucFirst($action)" name="permissions[]" id="permission-{{$key}}-{{$action}}"  />
                                @endforeach
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                               <div class="text-blue-500 hover:underline hover:cursor-pointer"> All | None </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
