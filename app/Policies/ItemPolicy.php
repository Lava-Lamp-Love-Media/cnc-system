<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;

class ItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isCompanyAdmin();
    }

    public function view(User $user, Item $item): bool
    {
        return $user->company_id === $item->company_id;
    }

    public function create(User $user): bool
    {
        return $user->isCompanyAdmin();
    }

    public function update(User $user, Item $item): bool
    {
        return $user->company_id === $item->company_id;
    }

    public function delete(User $user, Item $item): bool
    {
        return $user->company_id === $item->company_id;
    }
}
