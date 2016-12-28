<?php

namespace Interpro\Extractor\Contracts\Creation;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;

interface CollectionFactory
{
    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     *
     * @return \Interpro\Extractor\Contracts\Collections\SubVarCollection
     */
    public function createSubVarCollection(ARef $ref);

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     */
    public function createCollectionSet(ARef $ref, $ref_name);

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $groupType
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function createGroupCollection(GroupType $groupType);

    /**
     * @return \Interpro\Extractor\Collections\FieldsCollection
     */
    public function createFieldsCollection();

    /**
     * @return \Interpro\Extractor\Collections\OwnsCollection
     */
    public function createOwnsCollection();

    /**
     * @return \Interpro\Extractor\Collections\RefsCollection
     */
    public function createRefsCollection();

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $groupType
     *
     * @return \Interpro\Extractor\Collections\MapGroupCollection
     */
    public function createMapGroupCollection(GroupType $groupType);

}
