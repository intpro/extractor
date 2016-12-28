<?php

namespace Interpro\Extractor\Fields;

trait FieldSameTrait
{
    private $name;
    private $owner;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Interpro\Extractor\Contracts\Items\AItem
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
