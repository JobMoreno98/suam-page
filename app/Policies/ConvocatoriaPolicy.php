<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Convocatoria;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConvocatoriaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Convocatoria');
    }

    public function view(AuthUser $authUser, Convocatoria $convocatoria): bool
    {
        return $authUser->can('View:Convocatoria');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Convocatoria');
    }

    public function update(AuthUser $authUser, Convocatoria $convocatoria): bool
    {
        return $authUser->can('Update:Convocatoria');
    }

    public function delete(AuthUser $authUser, Convocatoria $convocatoria): bool
    {
        return $authUser->can('Delete:Convocatoria');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Convocatoria');
    }

    public function restore(AuthUser $authUser, Convocatoria $convocatoria): bool
    {
        return $authUser->can('Restore:Convocatoria');
    }

    public function forceDelete(AuthUser $authUser, Convocatoria $convocatoria): bool
    {
        return $authUser->can('ForceDelete:Convocatoria');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Convocatoria');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Convocatoria');
    }

    public function replicate(AuthUser $authUser, Convocatoria $convocatoria): bool
    {
        return $authUser->can('Replicate:Convocatoria');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Convocatoria');
    }

}