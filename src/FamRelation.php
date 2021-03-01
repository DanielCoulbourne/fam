<?php

namespace Fam;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use RuntimeException;

class FamRelation extends Relation
{
    protected $original_limit;

    protected $orders = [];
    protected $limit = null;

    protected ?Closure $eager_callback = null;

    public static function fromBuilder(Builder $query)
    {
        return new static($query, $query->getModel());
    }


    public function getResults()
    {
        return $this->isManyRelation()
            ? $this->query->get()
            : $this->query->first();
    }

    public function whenEager(Closure $callback)
    {
        $this->eager_callback = $callback;

        return $this;
    }

    public function addConstraints()
    {
        if (!static::$constraints) {
            return;
        }
    }

    public function addEagerConstraints(array $models)
    {
        if (null === $this->eager_callback) {
            throw new RuntimeException('You didnt let me eager load so sorry no eager');
        }

        $this->prepareOrderForEager();
        $this->prepareLimitForEager();

        call_user_func($this->eager_callback, $this->query, $models);
    }

    public function initRelation(array $models, $relation)
    {
        // FIXME: fix this so it handles singles as well
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    public function match(array $models, Collection $results, $relation)
    {
        dd($results->toArray());
    }

    protected function isManyRelation()
    {
        return $this->getBaseQuery()->limit !== 1;
    }

    protected function prepareOrderForEager()
    {
        $this->orders = $this->getBaseQuery()->orders;

        $this->getBaseQuery()->orders = [];
    }

    protected function prepareLimitForEager()
    {
        $this->limit = $this->getBaseQuery()->limit;

        $this->getBaseQuery()->limit = null;
    }
}
