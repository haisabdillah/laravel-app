<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

trait PermissionTrait
{
    public function hasPermission($permission)
    {
        $user = Auth::user();
        if (!$user || !$user->can($permission)) {
            return abort(403, 'Unauthorized action.');
        }
        return true;
    }
}
