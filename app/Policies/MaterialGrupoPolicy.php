<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MaterialGrupo;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialGrupoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MaterialGrupo');
    }

    public function view(AuthUser $authUser, MaterialGrupo $materialGrupo): bool
    {
        return $authUser->can('View:MaterialGrupo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MaterialGrupo');
    }

    public function update(AuthUser $authUser, MaterialGrupo $materialGrupo): bool
    {
        return $authUser->can('Update:MaterialGrupo');
    }

    public function delete(AuthUser $authUser, MaterialGrupo $materialGrupo): bool
    {
        return $authUser->can('Delete:MaterialGrupo');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MaterialGrupo');
    }

    public function restore(AuthUser $authUser, MaterialGrupo $materialGrupo): bool
    {
        return $authUser->can('Restore:MaterialGrupo');
    }

    public function forceDelete(AuthUser $authUser, MaterialGrupo $materialGrupo): bool
    {
        return $authUser->can('ForceDelete:MaterialGrupo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MaterialGrupo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MaterialGrupo');
    }

    public function replicate(AuthUser $authUser, MaterialGrupo $materialGrupo): bool
    {
        return $authUser->can('Replicate:MaterialGrupo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MaterialGrupo');
    }

}