<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Collection;
use Interpro\Core\Contracts\Named;
use Interpro\Extractor\Contracts\Items\GroupItem;

interface GroupCollection extends Collection, Named
{
    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\GroupType
     */
    public function getType();

    /**
     * @param int $id
     *
     * @return \Interpro\Extractor\Contracts\Items\GroupItem
     */
    public function getItem($id);

    /**
     * @param \Interpro\Extractor\Contracts\Items\GroupItem
     *
     * @return void
     */
    public function addItem(GroupItem $groupItem);

    /**
     * @param $field_name
     *
     * @return \Interpro\Extractor\Contracts\Items\GroupItem
     */
    public function maxByField($field_name);

    /**
     * @param $field_name
     *
     * @return \Interpro\Extractor\Contracts\Items\GroupItem
     */
    public function minByField($field_name);

    /**
     * @param $field_name
     *
     * @return int
     */
    public function sumByField($field_name);
}
