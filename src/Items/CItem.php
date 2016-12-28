<?php

namespace Interpro\Extractor\Items;

use Interpro\Core\Contracts\Taxonomy\Types\CType;
use Interpro\Extractor\Contracts\Items\COwnItem;

class CItem implements COwnItem
{
    private $value;
    private $type;
    private $cap;

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     * @param mixed $value
     * @param bool $cap
     *
     * @return void
     */
    public function __construct(CType $type, $value, $cap = false)
    {
        $this->type = $type;
        $this->value = $value;
        $this->cap = $cap;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\CType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function cap()
    {
        return $this->cap;
    }

}
