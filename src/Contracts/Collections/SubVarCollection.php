<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;

/**
*
* Хранит сэты подчиненных коллекций по ссылкам подчинения
*/
interface SubVarCollection extends NamedCollection
{
    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     */
    public function getCollectionSet($ref_name);
}
