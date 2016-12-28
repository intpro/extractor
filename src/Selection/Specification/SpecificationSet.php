<?php

namespace Interpro\Extractor\Selection\Specification;

use Interpro\Core\Contracts\Taxonomy\Types\AggrType;
use Interpro\Extractor\Contracts\Selection\SpecificationUnit;
use Interpro\Extractor\Contracts\Selection\SpecificationSet as SpecificationSetInterface;
use Interpro\Extractor\Db\QueryBuilder as Builder;

/**
 * Условия будут применяться через 'И', группируясь в 'ИЛИ' блоки, если указан общее имя объединения
 */
class SpecificationSet implements SpecificationSetInterface
{
   private $or_union;
   private $free;
   private $Atype;
   private $fields_paths;

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\AggrType $Atype
     *
     * @return void
     */
    public function __construct(AggrType $Atype)
    {
        $this->Atype        = $Atype;
        $this->or_union     = [];
        $this->free         = [];
        $this->fields_paths = [];
    }

    /**
     * @return array
     */
    public function getJoinFieldsPaths()
    {
        return $this->fields_paths;
    }

    /**
     * @param Builder $query
     *
     * @return void
     */
    public function applyAll(Builder $query)
    {
        //Сначала И элементы связанные через ИЛИ
        foreach($this->or_union as $union)
        {
            if(count($union) > 0)
            {
                $query->where(function($sub) use ($union){
                    $or = false;
                    foreach($union as $specUnit)
                    {
                        $specUnit->apply($sub, $or);
                        $or = true;
                    }
                });
            }
        }

        //Затем отдельные И элементы
        foreach($this->free as $specUnit)
        {
            $specUnit->apply($query);
        }
    }

    private function check_or_union($or_union_name)
    {
        if(!array_key_exists($or_union_name, $this->or_union))
        {
            $this->or_union[$or_union_name] = [];
        }
    }

    /**
     * Сырой метод добавления spec.Unit
     *
     * @param \Interpro\Extractor\Contracts\Selection\SpecificationUnit $specUnit
     * @param mixed $or_union_name
     *
     * @return void
     */
    public function addUnit(SpecificationUnit $specUnit, $or_union_name = null)
    {
        if($or_union_name === null)
        {
            $this->free[] = $specUnit;
        }
        else
        {
            $this->check_or_union($or_union_name);

            $this->or_union[$or_union_name][] =  $specUnit;
        }

        $this->fields_paths[] = $specUnit->getFieldName();
    }

}
