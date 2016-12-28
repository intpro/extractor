<?php

namespace Interpro\Extractor\Db;

use Interpro\Extractor\Contracts\Db\AMapper;
use Interpro\Extractor\Contracts\Db\BMapper;
use Interpro\Extractor\Contracts\Db\CMapper;
use Interpro\Extractor\Contracts\Db\MappersMediator as MappersMediatorInterface;
use Interpro\Extractor\Exception\ExtractorException;

class MappersMediator implements MappersMediatorInterface
{
    private $mappersA = [];
    private $mappersB = [];
    private $mappersC = [];

    /**
     *
     */
    public function reset()
    {
        foreach($this->mappersA as $mapper)
        {
            $mapper->reset();
        }

        foreach($this->mappersB as $mapper)
        {
            $mapper->reset();
        }

        foreach($this->mappersC as $mapper)
        {
            $mapper->reset();
        }
    }

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Db\AMapper
     */
    public function getAMapper($family)
    {
        if(!array_key_exists($family, $this->mappersA))
        {
            throw new ExtractorException('Маппер агрегатных(A) типов пакета '.$family.' не найдена в медиаторе!');
        }

        return $this->mappersA[$family];
    }

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Db\BMapper
     */
    public function getBMapper($family)
    {
        if(!array_key_exists($family, $this->mappersB))
        {
            throw new ExtractorException('Маппер агрегатных(B) типов пакета '.$family.' не найдена в медиаторе!');
        }

        return $this->mappersB[$family];
    }

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Db\CMapper
     */
    public function getCMapper($family)
    {
        if(!array_key_exists($family, $this->mappersC))
        {
            throw new ExtractorException('Маппер простых(C) типов пакета '.$family.' не найдена в медиаторе!');
        }

        return $this->mappersC[$family];
    }

    /**
     * @param \Interpro\Extractor\Contracts\Db\AMapper
     *
     * @return void
     */
    public function registerAMapper(AMapper $mapper)
    {
        $family = $mapper->getFamily();

        if(array_key_exists($family, $this->mappersA))
        {
            throw new ExtractorException('Маппер агрегатных(A) типов пакета '.$family.' уже зарегестрирована в медиаторе!');
        }

        $this->mappersA[$family] = $mapper;
    }

    /**
     * @param \Interpro\Extractor\Contracts\Db\BMapper
     *
     * @return void
     */
    public function registerBMapper(BMapper $mapper)
    {
        $family = $mapper->getFamily();

        if(array_key_exists($family, $this->mappersB))
        {
            throw new ExtractorException('Маппер агрегатных(B) типов пакета '.$family.' уже зарегестрирована в медиаторе!');
        }

        $this->mappersB[$family] = $mapper;
    }

    /**
     * @param \Interpro\Extractor\Contracts\Db\CMapper
     *
     * @return void
     */
    public function registerCMapper(CMapper $mapper)
    {
        $family = $mapper->getFamily();

        if(array_key_exists($family, $this->mappersC))
        {
            throw new ExtractorException('Маппер простых(С) типов пакета '.$family.' уже зарегестрирована в медиаторе!');
        }

        $this->mappersC[$family] = $mapper;
    }

}
