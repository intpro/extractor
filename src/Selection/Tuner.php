<?php

namespace Interpro\Extractor\Selection;

use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\Extractor\Contracts\Selection\Tuner as TunerInterface;
use Interpro\Extractor\Exception\ExtractorException;
use Interpro\Extractor\Selection\Param\ParamSet;
use Interpro\Extractor\Selection\Sorting\SortingSet;
use Interpro\Extractor\Selection\Specification\SpecificationSet;

class Tuner implements TunerInterface
{
    private $units = [];

    public function __construct()
    {
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit $selUnit
     */
    public function initSelection(GroupType $type, $name)
    {
        $group_name = $type->getName();

        if(!array_key_exists($group_name, $this->units))
        {
            $this->units[$group_name] = [];
        }

        if(array_key_exists($name, $this->units[$group_name]))
        {
            throw new ExtractorException('Выборка для группы '.$group_name.' по имени '.$name.' уже создана!');
        }

        $paramSet         = new ParamSet($type);
        $sortingSet       = new SortingSet($type);
        $specificationSet = new SpecificationSet($type);

        $unit = new SelectionUnit($type, $paramSet, $sortingSet, $specificationSet, $name);

        $this->units[$group_name][$name] = $unit;

        return $unit;
    }

    /**
     * @param string $group_name
     * @param string $name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit $selUnit
     */
    public function getSelection($group_name, $name)
    {
        if(!array_key_exists($group_name, $this->units))
        {
            throw new ExtractorException('Ни одной выборки для группы '.$group_name.' не создано!');
        }

        if(!array_key_exists($name, $this->units[$group_name]))
        {
            throw new ExtractorException('Выборка для группы '.$group_name.' по имени '.$name.' не создана!');
        }

        return $this->units[$group_name][$name];
    }

    /**
     * @param string $group_name
     * @param string $name
     *
     * @return bool
     */
    public function selectionExist($group_name, $name)
    {
        if(!array_key_exists($group_name, $this->units))
        {
            return false;
        }

        if(!array_key_exists($name, $this->units[$group_name]))
        {
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    public function reset()
    {
        foreach($this->units as $gunit)
        {
            foreach($gunit as $unit)
            {
                $unit->reset();
            }
        }
    }

}
