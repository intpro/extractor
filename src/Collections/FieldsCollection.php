<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Taxonomy\Collections\NamedCollection;
use \Interpro\Extractor\Contracts\Collections\FieldsCollection as FieldsCollectionInterface;
use Interpro\Extractor\Contracts\Fields\Field;
use Interpro\Extractor\Exception\ExtractorException;

class FieldsCollection extends NamedCollection implements FieldsCollectionInterface
{
    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\Field
     */
    public function getFieldByName($field_name)
    {
        return parent::getByName($field_name);
    }

    /**
     * @param \Interpro\Extractor\Contracts\Fields\Field
     *
     * @return void
     */
    public function addField(Field $field)
    {
        parent::addByName($field);
    }

    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Fields\AField
     */
    public function getAFieldByName($field_name)
    {
        return parent::getByName($field_name);
    }

    protected function notFoundAction($name)
    {
        throw new ExtractorException('Не найдено поле по имени '.$name.'!');
    }

}
