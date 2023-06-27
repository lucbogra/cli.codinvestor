<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AffiliateScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
      $investor = request()->user()->hasRole('Investor') ? request()->user()->investor : (request()->user()->hasRole('Member') ? request()->user()->member->investor : null);
      $builder->where('orderable_id', $investor->id)->where('orderable_type', 'App\Models\Investor');
    }
}
