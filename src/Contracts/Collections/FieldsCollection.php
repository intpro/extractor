<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Fields\Field;

interface FieldsCollection extends NamedCollection
{
    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\Field
     */
    public function getFieldByName($field_name);

    /**
     * @param \Interpro\Extractor\Contracts\Fields\Field
     *
     * @return void
     */
    public function addField(Field $field);

}
