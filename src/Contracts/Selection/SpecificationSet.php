<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Extractor\Db\QueryBuilder as Builder;

/**
 * Условия будут применяться через 'И', группируясь в 'ИЛИ' блоки, если указан общее имя объединения
 */
interface SpecificationSet
{
    /**
     * @return array
     */
    public function getJoinFieldsPaths();

    /**
     * @param Builder $query
     *
     * @return void
     */
    public function applyAll(Builder $query);

    /**
     * Сырой метод добавления spec.Unit
     *
     * @param \Interpro\Extractor\Contracts\Selection\SpecificationUnit $specUnit
     * @param mixed $or_union_name
     *
     * @return void
     */
    public function addUnit(SpecificationUnit $specUnit, $or_union_name = null);
}
