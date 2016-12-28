<?php

namespace Interpro\Extractor\Fields;

use Interpro\Extractor\Contracts\Fields\OwnField as OwnFieldInterface;
use Interpro\Extractor\Contracts\Items\AItem;
use Interpro\Core\Contracts\Taxonomy\Fields\OwnField as OwnFieldMeta;
use Interpro\Extractor\Contracts\Items\OwnItem;

class ACOwnField implements OwnFieldInterface
{
    use FieldSameTrait;

    private $item;
    private $field;

    /**
     * @param \Interpro\Extractor\Contracts\Items\AItem $owner
     * @param \Interpro\Core\Contracts\Taxonomy\Fields\OwnField $field
     *
     * @return void
     */
    public function __construct(AItem $owner, OwnFieldMeta $field)
    {
        $this->name = $field->getName();
        $this->owner = $owner;
        $this->field = $field;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\Field
     */
    public function getFieldMeta()
    {
        return $this->field;
    }

    /**
     * @return \Interpro\Extractor\Contracts\Items\OwnItem
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getItem()->getValue();
    }

    /**
     * @param \Interpro\Extractor\Contracts\Items\COwnItem
     *
     * @return void
     */
    public function setItem(OwnItem $ownItem)
    {
        $this->item = $ownItem;
    }
}
