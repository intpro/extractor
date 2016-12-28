<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Collections\OwnsCollection as OwnsCollectionInterface;
use Interpro\Extractor\Contracts\Fields\OwnField;
use Interpro\Extractor\Exception\ExtractorException;

class OwnsCollection extends NamedCollection implements OwnsCollectionInterface
{
    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\OwnField
     */
    public function getOwnByName($field_name)
    {
        return parent::getByName($field_name);
    }

    /**
     * @param \Interpro\Extractor\Contracts\Fields\OwnField
     *
     * @return void
     */
    public function addOwn(OwnField $ownField)
    {
        parent::addByName($ownField);
    }

    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Fields\AOwnField
     */
    public function getAOwnByName($field_name)
    {
        return parent::getByName($field_name);
    }

    protected function notFoundAction($name)
    {
        throw new ExtractorException('Не найдено поле по имени '.$name.'!');
    }

}
