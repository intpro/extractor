<?php

namespace Interpro\Extractor\Contracts\Collections;

interface MapGroupCollection extends GroupCollection
{
    /**
     * @param \Interpro\Extractor\Contracts\Collections\RefFilter $refFilter
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function filterByRef(RefFilter $refFilter);
}
