<?php

namespace Fam;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

class FamRelation extends Relation
{

    public static function fromBuilder($query, $model)
    {
        return new static($query, $model);
    }

	/**
	 * @inheritDoc
	 */
	public function addConstraints()
	{
		// TODO: Implement addConstraints() method.
	}

	/**
	 * @inheritDoc
	 */
	public function addEagerConstraints(array $models)
	{
		// TODO: Implement addEagerConstraints() method.
	}

	/**
	 * @inheritDoc
	 */
	public function initRelation(array $models, $relation)
	{
		// TODO: Implement initRelation() method.
	}

	/**
	 * @inheritDoc
	 */
	public function match(array $models, Collection $results, $relation)
	{
		// TODO: Implement match() method.
	}

	/**
	 * @inheritDoc
	 */
	public function getResults()
	{
		// TODO: Implement getResults() method.
	}
}
