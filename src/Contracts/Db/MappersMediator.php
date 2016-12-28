<?php

namespace Interpro\Extractor\Contracts\Db;

interface MappersMediator
{
    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Db\AMapper
     */
    public function getAMapper($family);

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Db\BMapper
     */
    public function getBMapper($family);

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Db\CMapper
     */
    public function getCMapper($family);

    /**
     * @param \Interpro\Extractor\Contracts\Db\AMapper
     *
     * @return void
     */
    public function registerAMapper(AMapper $mapper);

    /**
     * @param \Interpro\Extractor\Contracts\Db\BMapper
     *
     * @return void
     */
    public function registerBMapper(BMapper $mapper);

    /**
     * @param \Interpro\Extractor\Contracts\Db\CMapper
     *
     * @return void
     */
    public function registerCMapper(CMapper $mapper);
}
