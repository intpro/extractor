<?php

namespace Interpro\Extractor\Contracts\Items;

interface BlockItem extends AItem
{
    /**
     * @param string $group_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     *
     * Получение группы непосредственно подчиненной блоку
     */
    public function getGroupFlat($group_name, $selection_name = 'group');

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     *
     * Получение коллекции подчиненных блоку коллекций Групп
     */
    public function getGroupSetFlat();

    /**
     * @return \Interpro\Core\Taxonomy\Types\BlockType
     */
    public function getType();

}
