<?php

namespace Interpro\Extractor\Contracts\Db;

use Interpro\Core\Contracts\Mediatable;
use Interpro\Core\Contracts\Taxonomy\Fields\Field;

interface Joiner extends Mediatable
{
    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Fields\Field $field
     * @param array $join_array
     *
     * @return mixed
     */
    public function joinByField(Field $field, $join_array);
}
