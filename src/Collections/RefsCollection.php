<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Collections\RefsCollection as RefsCollectionInterface;
use Interpro\Extractor\Contracts\Fields\RefField;
use Interpro\Extractor\Exception\ExtractorException;

class RefsCollection extends NamedCollection implements RefsCollectionInterface
{
    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\RefField
     */
    public function getRefByName($field_name)
    {
        return parent::getByName($field_name);
    }

    /**
     * @param \Interpro\Extractor\Contracts\Fields\RefField
     *
     * @return void
     */
    public function addRef(RefField $refField)
    {
        parent::addByName($refField);
    }

    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Fields\AARefField
     */
    public function getAARefByName($field_name)
    {
        return parent::getByName($field_name);
    }

    protected function notFoundAction($name)
    {
        throw new ExtractorException('Не найдена ссылка по имени '.$name.'!');
    }

}
