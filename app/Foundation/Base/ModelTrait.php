<?php
namespace App\Foundation\Base;

use App\Models\User;
use Illuminate\Support\Arr;

trait ModelTrait
{

    public function auth(): User
    {
        /** @var User $auth */
        $auth = request()->user();
        return $auth;
    }

    public function hasActiveFilter(): bool
    {
        $has = Arr::first($this->fillable, function ($value) {
            return $value === "is_active";
        });
        return !$has ? false : true;
    }

    public function hasChainFilter(): bool
    {
        $has = Arr::first($this->fillable, function ($value) {
            return $value === "chain_id";
        });
        return !$has ? false : true;
    }

    public function hasRestaurantFilter(): bool
    {
        $has = Arr::first($this->fillable, function ($value) {
            return $value === "restaurant_id";
        });
        return !$has ? false : true;
    }
    public function hasCreatedBy(): bool
    {
        $has = Arr::first($this->fillable, function ($value) {
            return $value === "created_by";
        });
        return !$has ? false : true;
    }
}