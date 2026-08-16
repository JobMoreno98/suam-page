<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Publicacion;
use Illuminate\Auth\Access\HandlesAuthorization;

class PublicacionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Publicacion');
    }

    public function view(AuthUser $authUser, Publicacion $publicacion): bool
    {
        return $authUser->can('View:Publicacion');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Publicacion');
    }

    public function update(AuthUser $authUser, Publicacion $publicacion): bool
    {
        return $authUser->can('Update:Publicacion');
    }

    public function delete(AuthUser $authUser, Publicacion $publicacion): bool
    {
        return $authUser->can('Delete:Publicacion');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Publicacion');
    }

    public function restore(AuthUser $authUser, Publicacion $publicacion): bool
    {
        return $authUser->can('Restore:Publicacion');
    }

    public function forceDelete(AuthUser $authUser, Publicacion $publicacion): bool
    {
        return $authUser->can('ForceDelete:Publicacion');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Publicacion');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Publicacion');
    }

    public function replicate(AuthUser $authUser, Publicacion $publicacion): bool
    {
        return $authUser->can('Replicate:Publicacion');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Publicacion');
    }

}