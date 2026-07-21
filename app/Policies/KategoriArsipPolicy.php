<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KategoriArsip;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriArsipPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KategoriArsip');
    }

    public function view(AuthUser $authUser, KategoriArsip $kategoriArsip): bool
    {
        return $authUser->can('View:KategoriArsip');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KategoriArsip');
    }

    public function update(AuthUser $authUser, KategoriArsip $kategoriArsip): bool
    {
        return $authUser->can('Update:KategoriArsip');
    }

    public function delete(AuthUser $authUser, KategoriArsip $kategoriArsip): bool
    {
        return $authUser->can('Delete:KategoriArsip');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KategoriArsip');
    }

    public function restore(AuthUser $authUser, KategoriArsip $kategoriArsip): bool
    {
        return $authUser->can('Restore:KategoriArsip');
    }

    public function forceDelete(AuthUser $authUser, KategoriArsip $kategoriArsip): bool
    {
        return $authUser->can('ForceDelete:KategoriArsip');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KategoriArsip');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KategoriArsip');
    }

    public function replicate(AuthUser $authUser, KategoriArsip $kategoriArsip): bool
    {
        return $authUser->can('Replicate:KategoriArsip');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KategoriArsip');
    }

}