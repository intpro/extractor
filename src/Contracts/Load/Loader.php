<?php

namespace Interpro\Extractor\Contracts\Load;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Collections\RefFilter;

interface Loader
{
    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     * @param \Interpro\Extractor\Contracts\Collections\RefFilter $refFilter
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapGroupCollection
     */
    public function loadGroupCollectionAsSub($type, $selection_name, RefFilter $refFilter);

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function loadGroupCollection($type, $selection_name);

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     *
     * @return int
     */
    public function countGroup($type, $selection_name);

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param bool $asUnitMember
     *
     * @return \Interpro\Extractor\Items\AItem
     */
    public function loadItem(ARef $ref, $asUnitMember = false);
}
