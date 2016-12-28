<?php

namespace Interpro\Extractor\Selection;

use Illuminate\Support\Facades\Log;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\Core\Taxonomy\Enum\TypeRank;
use Interpro\Extractor\Contracts\Selection\ParamSet;
use Interpro\Extractor\Contracts\Selection\SortingSet;
use Interpro\Extractor\Contracts\Selection\SpecificationSet;
use Interpro\Extractor\Exception\ExtractorException;
use Interpro\Extractor\Contracts\Selection\SelectionUnit as SelectionUnitInterface;
use Interpro\Extractor\Db\QueryBuilder as Builder;
use Interpro\Extractor\Selection\Sorting\SortingUnit;
use Interpro\Extractor\Selection\Specification\SpecificationEq;
use Interpro\Extractor\Selection\Specification\SpecificationInRange;
use Interpro\Extractor\Selection\Specification\SpecificationLessThan;
use Interpro\Extractor\Selection\Specification\SpecificationLike;
use Interpro\Extractor\Selection\Specification\SpecificationMoreThan;
use Interpro\Extractor\Selection\Specification\SpecificationNotEq;
use Interpro\Extractor\Selection\Specification\SpecificationNotInRange;
use Interpro\Extractor\Selection\Specification\SpecificationNotLike;

/**
 * Для каждого имени А-типа из фходящих через контроллер параметров формируется SelectionUnit
 */
class SelectionUnit implements SelectionUnitInterface
{
    private $type;
    private $paramSet;
    private $sortingSet;
    private $specificationSet;

    private static $curr_number = 0;
    private $number;

    private $name;

    private $id_set;
    private $complete;
    private $filters;

    /**
     * @return void
     */
    public function reset()
    {
        $this->id_set = [];
        $this->complete = false;
    }

    protected static function sign_number(SelectionUnit $unit)
    {
        static::$curr_number++;
        $unit->number = static::$curr_number;
    }

    /**
     * @return bool
     */
    public function closeToIdSet()
    {
        return ($this->type->getRank() !== TypeRank::BLOCK);
    }

    /**
     * @param mixed $id
     * @throws \Interpro\Extractor\Exception\ExtractorException
     * @return void
     */
    public function addId($id)
    {
        if($this->complete)
        {
            throw new ExtractorException('Регистрация элементов завершена, добавление невозможно!');
        }

        if(is_array($id))
        {
            $this->id_set = array_merge($this->id_set, $id);
        }
        else
        {
            $this->id_set[] = $id;
        }
    }

    /**
     * @return array
     */
    public function getIdSet()
    {
        if($this->complete)
        {
            return $this->id_set;
        }
        else
        {
            throw new ExtractorException('Выборка не выполнена, запрос ключей не возможен!');
        }
    }

    public function complete()
    {
        $this->complete = true;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param \Interpro\Extractor\Contracts\Selection\ParamSet $paramSet
     * @param \Interpro\Extractor\Contracts\Selection\SortingSet $sortingSet
     * @param \Interpro\Extractor\Contracts\Selection\SpecificationSet $specificationSet
     * @param string $name
     * @return void
     */
    public function __construct(GroupType $type, ParamSet $paramSet, SortingSet $sortingSet, SpecificationSet $specificationSet, $name)
    {
        //По номеру выборки будут кэшироваться на стороне пакета-поставщика
        static::sign_number($this);

        $this->type = $type;
        $this->name = $name;

        $this->paramSet = $paramSet;
        $this->sortingSet = $sortingSet;
        $this->specificationSet = $specificationSet;

        $this->filters = [];

        $this->id_set   = [];
        $this->complete = false;
    }

    /**
     * Методы добавления Спецификаций, Сортировок, Параметров через функции и просто через add готовыми объектами
     */

    /**
     * @param $query
     *
     * @return void
     */
    public function apply(Builder $query)
    {
        $this->specificationSet->applyAll($query);
        $this->sortingSet->applyAll($query);
        $this->paramSet->apply($query);
    }

    /**
     * @return array
     */
    public function getJoinFieldsPaths()
    {
        return array_unique(array_merge($this->sortingSet->getJoinFieldsPaths(), $this->specificationSet->getJoinFieldsPaths()));
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\GroupType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->type->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function moreThen($field_path, $value, $or_union_name = null)
    {
        $newUnit = new SpecificationMoreThan($this->type, $field_path, $value);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function lessThan($field_path, $value, $or_union_name = null)
    {
        $newUnit = new SpecificationLessThan($this->type, $field_path, $value);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $min_x
     * @param string $max_x
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function inRange($field_path, $min_x, $max_x, $or_union_name = null)
    {
        $newUnit = new SpecificationInRange($this->type, $field_path, $min_x, $max_x);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $min_x
     * @param string $max_x
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function notInRange($field_path, $min_x, $max_x, $or_union_name = null)
    {
        $newUnit = new SpecificationNotInRange($this->type, $field_path, $min_x, $max_x);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function eq($field_path, $value, $or_union_name = null)
    {
        $newUnit = new SpecificationEq($this->type, $field_path, $value);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function notEq($field_path, $value, $or_union_name = null)
    {
        $newUnit = new SpecificationNotEq($this->type, $field_path, $value);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function like($field_path, $value, $or_union_name = null)
    {
        $newUnit = new SpecificationLike($this->type, $field_path, $value);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function notLike($field_path, $value, $or_union_name = null)
    {
        $newUnit = new SpecificationNotLike($this->type, $field_path, $value);
        $this->specificationSet->addUnit($newUnit, $or_union_name);

        return $this;
    }

    /**
     * @param string $field_name
     * @param string $order
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function sortBy($field_name, $order = 'ASC')
    {
        if($order !== 'ASC' and $order !== 'DESC')
        {
            Log::warning('При сортировке типа '.$this->type.' возможно только два направления сортировки ASC или DESC, передано '.$order.', применена ASC.');

            $order = 'ASC';
        }

        $newUnit = new SortingUnit($field_name, $order);

        $this->sortingSet->addUnit($newUnit);

        return $this;
    }

    /**
     * @param int $value
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function skip($value)
    {
        $this->paramSet->skip($value);

        return $this;
    }

    /**
     * @param int $value
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function take($value)
    {
        $this->paramSet->take($value);

        return $this;
    }

}
