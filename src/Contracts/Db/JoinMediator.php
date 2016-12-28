<?php

namespace Interpro\Extractor\Contracts\Db;

use Interpro\Core\Contracts\Taxonomy\Fields\Field;

interface JoinMediator
{
    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Fields\Field $field
     * @param array $join_array
     *
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function externalJoin(Field $field, $join_array);

    /**
     * @param \Interpro\Extractor\Contracts\Db\Joiner
     *
     * @return void
     */
    public function registerJoiner(Joiner $joiner);
}
