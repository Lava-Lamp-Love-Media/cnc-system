<?php

namespace App\Policies;

use App\Models\PurchaseOrder;
use App\Models\User;

class PurchaseOrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isCompanyAdmin();
    }

    public function view(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->company_id === $purchaseOrder->company_id;
    }

    public function create(User $user): bool
    {
        return $user->isCompanyAdmin();
    }

    public function update(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->company_id === $purchaseOrder->company_id;
    }

    public function delete(User $user, PurchaseOrder $purchaseOrder): bool
    {
        return $user->company_id === $purchaseOrder->company_id
            && $purchaseOrder->status !== 'received';
    }
}
