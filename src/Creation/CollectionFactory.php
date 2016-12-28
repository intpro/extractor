<?php

namespace Interpro\Extractor\Creation;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\Extractor\Collections\FieldsCollection;
use Interpro\Extractor\Collections\GroupCollection;
use Interpro\Extractor\Collections\MapGroupCollection;
use Interpro\Extractor\Collections\OwnsCollection;
use Interpro\Extractor\Collections\RefFilter;
use Interpro\Extractor\Collections\RefsCollection;
use Interpro\Extractor\Collections\GroupsCollectionSet;
use Interpro\Extractor\Collections\SubVarCollection;
use Interpro\Extractor\Contracts\Load\Loader;
use Interpro\Extractor\Contracts\Creation\CollectionFactory as CollectionFactoryInterface;

class CollectionFactory implements CollectionFactoryInterface
{
    private $loader;

    /**
     * @param \Interpro\Extractor\Contracts\Load\Loader $loader
     *
     * @return void
     */
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     *
     * @return \Interpro\Extractor\Contracts\Collections\SubVarCollection
     */
    public function createSubVarCollection(ARef $ref)
    {
        $collection = new SubVarCollection($ref, $this);

        return $collection;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $groupType
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function createGroupCollection(GroupType $groupType)
    {
        $collection = new GroupCollection($groupType);

        return $collection;
    }

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     */
    public function createCollectionSet(ARef $ref, $ref_name)
    {
        $refFilter = new RefFilter($ref, $ref_name);

        $set = new GroupsCollectionSet($refFilter, $this->loader);

        return $set;
    }

    /**
     * @return \Interpro\Extractor\Collections\FieldsCollection
     */
    public function createFieldsCollection()
    {
        $collection = new FieldsCollection();

        return $collection;
    }

    /**
     * @return \Interpro\Extractor\Collections\OwnsCollection
     */
    public function createOwnsCollection()
    {
        $collection = new OwnsCollection();

        return $collection;
    }

    /**
     * @return \Interpro\Extractor\Collections\RefsCollection
     */
    public function createRefsCollection()
    {
        $collection = new RefsCollection();

        return $collection;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $groupType
     *
     * @return \Interpro\Extractor\Collections\MapGroupCollection
     */
    public function createMapGroupCollection(GroupType $groupType)
    {
        $collection = new MapGroupCollection($groupType, $this);

        return $collection;
    }

}
