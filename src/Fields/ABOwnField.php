<?php

namespace Interpro\Extractor\Fields;

use Interpro\Extractor\Contracts\Fields\AggrOwnField as AggrOwnFieldInterface;
use Interpro\Core\Contracts\Taxonomy\Fields\OwnField as OwnFieldMeta;
use Interpro\Extractor\Contracts\Items\AggrOwnItem;
use Interpro\Extractor\Contracts\Items\AItem;

class ABOwnField implements AggrOwnFieldInterface
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
     * @return \Interpro\Extractor\Contracts\Items\AggrOwnItem
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\Field
     */
    public function getFieldMeta()
    {
        return $this->field;
    }

    /**
     * @param \Interpro\Extractor\Contracts\Items\AggrOwnItem
     *
     * @return void
     */
    public function setItem(AggrOwnItem $ownItem)
    {
        $this->item = $ownItem;
    }
}
