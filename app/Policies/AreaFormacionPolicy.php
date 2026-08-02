<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AreaFormacion;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreaFormacionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AreaFormacion');
    }

    public function view(AuthUser $authUser, AreaFormacion $areaFormacion): bool
    {
        return $authUser->can('View:AreaFormacion');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AreaFormacion');
    }

    public function update(AuthUser $authUser, AreaFormacion $areaFormacion): bool
    {
        return $authUser->can('Update:AreaFormacion');
    }

    public function delete(AuthUser $authUser, AreaFormacion $areaFormacion): bool
    {
        return $authUser->can('Delete:AreaFormacion');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AreaFormacion');
    }

    public function restore(AuthUser $authUser, AreaFormacion $areaFormacion): bool
    {
        return $authUser->can('Restore:AreaFormacion');
    }

    public function forceDelete(AuthUser $authUser, AreaFormacion $areaFormacion): bool
    {
        return $authUser->can('ForceDelete:AreaFormacion');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AreaFormacion');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AreaFormacion');
    }

    public function replicate(AuthUser $authUser, AreaFormacion $areaFormacion): bool
    {
        return $authUser->can('Replicate:AreaFormacion');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AreaFormacion');
    }

}