<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Collections\RefFilter as RefFilterInterface;

/**
 * Фильтр по ссылкам (например для родителя) применяемый к результату выборки SelectionUnit
 */
class RefFilter implements RefFilterInterface
{
    private $ref;
    private $type;
    private $name;

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param string $field_name
     *
     * @return void
     */
    public function __construct(ARef $ref, $field_name)
    {
        $this->name = $field_name;
        $this->ref = $ref;
        $this->type = $ref->getType();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTypeName()
    {
        return $this->type->getName();
    }

    /**
     * @return \Interpro\Core\Contracts\Ref\ARef
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\AggrType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Collections\SubsCollection
     */
    public function getSubs()
    {
        return $this->type->getSubs($this->name);
    }

    /**
     * @param string $type_name
     *
     * @return \Interpro\Core\Contracts\Taxonomy\Types\AType
     */
    public function getSub($type_name)
    {
        return $this->type->getSubs($this->name)->getSub($type_name);
    }

}
