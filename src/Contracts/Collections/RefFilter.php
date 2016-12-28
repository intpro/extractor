<?php

namespace Interpro\Extractor\Contracts\Collections;

/**
 * Фильтр по ссылкам (например для родителя) применяемый к результату выборки SelectionUnit
 */
interface RefFilter
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return \Interpro\Core\Contracts\Ref\ARef
     */
    public function getRef();

    /**
     * @return string
     */
    public function getTypeName();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\AggrType
     */
    public function getType();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Collections\SubsCollection
     */
    public function getSubs();

    /**
     * @param string $type_name
     *
     * @return \Interpro\Core\Contracts\Taxonomy\Types\AType
     */
    public function getSub($type_name);
}
