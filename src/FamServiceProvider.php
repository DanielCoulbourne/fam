<?php

namespace Fam;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class FamServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Builder::macro('asRelationship', function() {
            return FamRelation::fromBuilder($this);
        });
    }
}
