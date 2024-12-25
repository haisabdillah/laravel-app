<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\Models\User;

class GeneratePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        Role::updateOrCreate(['name' => 'superadmin'], ['name' => 'superadmin']);
        $permissions = [
            "users",
            "roles"
        ];
        foreach ($permissions as $value) {
            $actions = ['view', 'create', 'edit', 'delete'];
            foreach ($actions as $action) {
                $permissionName = "{$value}.{$action}";
                \Spatie\Permission\Models\Permission::updateOrCreate(['name' => $permissionName], ['name' => $permissionName]);
            }
        }

        $user = User::where('email','admin@admin.com')->first();
        if (!$user) {
           $user =  User::factory()->create([
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'status' => 1,
            ]);
            $user->syncRoles('superadmin');
        }
    }
}
