<?php

namespace Interpro\Extractor\Items;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Collections\FieldsCollection as FieldsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\OwnsCollection as OwnsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\RefsCollection as RefsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\SubVarCollection;
use Interpro\Extractor\Contracts\Items\GroupItem as GroupItemInterface;

class GroupItem extends AItem implements GroupItemInterface
{
    private $ref;

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param \Interpro\Extractor\Contracts\Collections\FieldsCollection $fields
     * @param \Interpro\Extractor\Contracts\Collections\OwnsCollection $owns
     * @param \Interpro\Extractor\Contracts\Collections\RefsCollection $refs
     * @param \Interpro\Extractor\Contracts\Collections\SubVarCollection $subVar
     *
     * @return void
     */
    public function __construct(ARef $ref, FieldsCollectionInterface $fields, OwnsCollectionInterface $owns, RefsCollectionInterface $refs, SubVarCollection $subVar)
    {
        $this->ref = $ref;

        parent::__construct($fields, $owns, $refs, $subVar);
    }

    /**
     * @return \Interpro\Core\Contracts\Ref\ARef
     */
    public function getSelfRef()
    {
        return $this->ref;
    }

    /**
     * @return \Interpro\Core\Taxonomy\Types\GroupType
     */
    public function getType()
    {
        return $this->ref->getType();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'id_'.$this->getOwn('id')->getItem()->getValue();
    }

}
