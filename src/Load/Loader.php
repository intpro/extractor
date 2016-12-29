<?php

namespace Interpro\Extractor\Load;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Load\Loader as LoaderInterface;
use Interpro\Extractor\Contracts\Collections\RefFilter;
use Interpro\Extractor\Contracts\Db\MappersMediator;
use Interpro\Extractor\Contracts\Selection\Tuner;

class Loader implements LoaderInterface
{
    private $mappersMediator;
    private $tuner;
    private $selections = [];
    private $counts = [];

    /**
     * @param \Interpro\Extractor\Contracts\Db\MappersMediator $mappersMediator
     * @param \Interpro\Extractor\Contracts\Selection\Tuner $tuner
     *
     * @return void
     */
    public function __construct(MappersMediator $mappersMediator, Tuner $tuner)
    {
        $this->mappersMediator = $mappersMediator;
        $this->tuner           = $tuner;
    }

    private function exists($key)
    {
        return array_key_exists($key, $this->selections);
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapGroupCollection
     */
    private function getCollection($type, $selection_name)
    {
        $group_name = $type->getName();
        $key = $group_name.'_'.$selection_name;

        if(!$this->exists($key))
        {
            $family = $type->getFamily();
            $Amapper = $this->mappersMediator->getAMapper($family);
            $selectionUnit = $this->tuner->getSelection($group_name, $selection_name);
            $AMapCollection = $Amapper->select($selectionUnit);
            $this->selections[$key] = $AMapCollection;
        }

        return $this->selections[$key];
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapGroupCollection
     */
    public function loadGroupCollection($type, $selection_name)
    {
        $ACollection = $this->getCollection($type, $selection_name);

        return $ACollection;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     * @param RefFilter $refFilter
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function loadGroupCollectionAsSub($type, $selection_name, RefFilter $refFilter)
    {
        $ACollection = $this->getCollection($type, $selection_name);

        $groupCollection = $ACollection->filterByRef($refFilter);

        return $groupCollection;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     *
     * @return int
     */
    public function countGroup($type, $selection_name)
    {
        $group_name = $type->getName();
        $key = $group_name.'_'.$selection_name;

        if(!array_key_exists($key, $this->counts))
        {
            $family = $type->getFamily();
            $Amapper = $this->mappersMediator->getAMapper($family);
            $selectionUnit = $this->tuner->getSelection($group_name, $selection_name);
            $count_val = $Amapper->count($selectionUnit);
            $this->counts[$key] = $count_val;
        }

        return $this->counts[$key];
    }

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param bool $asUnitMember
     *
     * @return \Interpro\Extractor\Items\AItem
     */
    public function loadItem(ARef $ref, $asUnitMember = false)
    {
        $family = $ref->getType()->getFamily();
        $Amapper = $this->mappersMediator->getAMapper($family);

        return $Amapper->getByRef($ref, $asUnitMember);
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->selections = [];
        $this->mappersMediator->reset();
        $this->counts = [];
    }

}
