<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Named;
use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;

/**
*
* Класс для коллекции коллекций (при получении плоски из корня или в подчинении у блоков или элементов групп), в подчинении ссылке (например владельца - superior)
*/
interface GroupsCollectionSet extends NamedCollection, Named
{
    /**
     * @param string $group_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function getGroup($group_name, $selection_name = 'group');

    /**
     * @return string
     */
    public function getName();
}
