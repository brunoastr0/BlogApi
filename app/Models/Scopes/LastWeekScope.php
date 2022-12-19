<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class LastWeekScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->whereBetween('created_at', [carbon('1 week ago'), now()])
            ->latest()
            ->limit(10);
    }
}
