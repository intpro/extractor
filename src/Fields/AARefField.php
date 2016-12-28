<?php

namespace Interpro\Extractor\Fields;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Db\AMapper;
use Interpro\Extractor\Contracts\Fields\RefField as RefFieldInterface;
use Interpro\Extractor\Contracts\Items\AggrItem;
use Interpro\Core\Contracts\Taxonomy\Fields\RefField as RefFieldMeta;

class AARefField implements RefFieldInterface
{
    use FieldSameTrait;

    private $ref;
    private $field;
    private $mapper;

    /**
     * @param \Interpro\Extractor\Contracts\Items\AggrItem $owner
     * @param \Interpro\Core\Contracts\Taxonomy\Fields\OwnField $field
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     *
     * @return void
     */
    public function __construct(AggrItem $owner, RefFieldMeta $field, ARef $ref, AMapper $mapper)
    {
        $this->name  = $field->getName();
        $this->owner = $owner;
        $this->field = $field;
        $this->ref   = $ref;
        $this->mapper = $mapper;
    }

    /**
     * @return \Interpro\Core\Contracts\Ref\ARef
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->ref->getId();
    }

    /**
     * @return \Interpro\Extractor\Contracts\Items\AItem
     */
    public function getItem()
    {
        return $this->mapper->getByRef($this->ref, true);
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\RefField
     */
    public function getFieldMeta()
    {
        return $this->field;
    }
}
