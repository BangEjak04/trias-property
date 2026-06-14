<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ProductKnowledge;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductKnowledgePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductKnowledge');
    }

    public function view(AuthUser $authUser, ProductKnowledge $productKnowledge): bool
    {
        return $authUser->can('View:ProductKnowledge');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductKnowledge');
    }

    public function update(AuthUser $authUser, ProductKnowledge $productKnowledge): bool
    {
        return $authUser->can('Update:ProductKnowledge');
    }

    public function delete(AuthUser $authUser, ProductKnowledge $productKnowledge): bool
    {
        return $authUser->can('Delete:ProductKnowledge');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ProductKnowledge');
    }

    public function restore(AuthUser $authUser, ProductKnowledge $productKnowledge): bool
    {
        return $authUser->can('Restore:ProductKnowledge');
    }

    public function forceDelete(AuthUser $authUser, ProductKnowledge $productKnowledge): bool
    {
        return $authUser->can('ForceDelete:ProductKnowledge');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductKnowledge');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductKnowledge');
    }

    public function replicate(AuthUser $authUser, ProductKnowledge $productKnowledge): bool
    {
        return $authUser->can('Replicate:ProductKnowledge');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductKnowledge');
    }

}