<?php

namespace Interpro\Extractor\Contracts\Items;

use Interpro\Core\Contracts\Named;

interface AItem extends AggrItem, Named
{
    /**
     * @return \Interpro\Core\Contracts\Ref\ARef
     */
    public function getSelfRef();

    /**
     * @param string $group_name
     * @param string $ref_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function getGroupCustom($group_name, $ref_name, $selection_name = 'group');

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     *
     * Получение коллекции подчиненных блоку коллекций Групп
     */
    public function getGroupSetCustom($ref_name);

    /**
     * Получение группы непосредственно подчиненной блоку
     *
     * @param string $group_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function getGroup($group_name, $selection_name = 'group');

    /**
     * Получение коллекции подчиненных блоку коллекций Групп
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     */
    public function getGroupSet();
}
