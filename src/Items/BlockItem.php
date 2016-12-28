<?php

namespace Interpro\Extractor\Items;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Items\BlockItem as BlockItemInterface;
use Interpro\Extractor\Contracts\Collections\FieldsCollection as FieldsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\OwnsCollection as OwnsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\RefsCollection as RefsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\SubVarCollection;

class BlockItem extends AItem implements BlockItemInterface
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Interpro\Core\Taxonomy\Types\BlockType
     */
    public function getType()
    {
        return $this->ref->getType();
    }

    /**
     * @param string $group_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     *
     * Получение группы непосредственно подчиненной блоку
     */
    public function getGroupFlat($group_name, $selection_name = 'group')
    {
        return $this->getGroupCustom($group_name, 'block_name', $selection_name);
    }

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     *
     * Получение коллекции подчиненных блоку коллекций Групп
     */
    public function getGroupSetFlat()
    {
        return $this->getGroupSetCustom('block_name');
    }

}
