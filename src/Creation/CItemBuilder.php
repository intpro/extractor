<?php

namespace Interpro\Extractor\Creation;

use Interpro\Core\Contracts\Taxonomy\Types\CType;
use Interpro\Extractor\Contracts\Creation\CItemFactory;
use Interpro\Extractor\Contracts\Creation\CItemBuilder as CItemBuilderInterface;
use Interpro\Extractor\Exception\ExtractorException;

class CItemBuilder implements CItemBuilderInterface
{
    private $factories = [];

    /**
     * @param \Interpro\Extractor\Contracts\Creation\CItemFactory
     *
     * @return void
     */
    public function addFactory(CItemFactory $factory)
    {
        $family = $factory->getFamily();

        if(array_key_exists($family, $this->factories))
        {
            throw new ExtractorException('Фабрика item`ов пакета '.$family.' уже зарегестрирована в построителе item`ов простых(С) типов!');
        }

        $this->factories[$family] = $factory;
    }

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Creation\CItemFactory
     */
    public function getFactory($family)
    {
        if(!array_key_exists($family, $this->factories))
        {
            throw new ExtractorException('Фабрика item`ов пакета '.$family.' не найдена в построителе item`ов простых(С) типов!');
        }

        return $this->factories[$family];
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     * @param mixed $value
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem
     */
    public function create(CType $type, $value)
    {
        $family = $type->getFamily();

        $factory = $this->getFactory($family);

        $item = $factory->create($type, $value);

        return $item;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem
     */
    public function createCap(CType $type)
    {
        $family = $type->getFamily();

        $factory = $this->getFactory($family);

        $item = $factory->createCap($type);

        return $item;
    }

}
