<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Extractor\Db\QueryBuilder as Builder;

/**
 * Для каждого имени А-типа из фходящих через контроллер параметров формируется SelectionUnit
 */
interface SelectionUnit
{
    /**
     * @return bool
     */
    public function closeToIdSet();

    /**
     * @param mixed $id
     * @throws \Interpro\Extractor\Exception\ExtractorException
     *
     * @return void
     */
    public function addId($id);

    /**
     * @return array
     */
    public function getIdSet();

    /**
     * @return void
     */
    public function complete();

    /**
     * @return int
     */
    public function getNumber();

    /**
     * Методы добавления Спецификаций, Сортировок, Параметров через функции и просто через add готовыми объектами
     */

    /**
     * @param Builder $query
     *
     * @return void
     */
    public function apply(Builder $query);

    /**
     * @return array
     */
    public function getJoinFieldsPaths();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\GroupType
     */
    public function getType();

    /**
     * @return string
     */
    public function getTypeName();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function moreThen($field_path, $value, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function lessThan($field_path, $value, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $min_x
     * @param string $max_x
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function inRange($field_path, $min_x, $max_x, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $min_x
     * @param string $max_x
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function notInRange($field_path, $min_x, $max_x, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function eq($field_path, $value, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function notEq($field_path, $value, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function like($field_path, $value, $or_union_name = null);

    /**
     * @param string $field_path
     * @param string $value
     * @param string $or_union_name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function notLike($field_path, $value, $or_union_name = null);

    /**
     * @param string $field_name
     * @param string $order
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function sortBy($field_name, $order = 'ASC');

    /**
     * @param int $value
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function skip($value);

    /**
     * @param int $value
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit
     */
    public function take($value);

}

