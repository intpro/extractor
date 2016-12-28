<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Core\Contracts\Taxonomy\Types\GroupType;

interface Tuner
{
    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit $selUnit
     */
    public function initSelection(GroupType $type, $name);

    /**
     * @param string $group_name
     * @param string $name
     *
     * @return \Interpro\Extractor\Contracts\Selection\SelectionUnit $selUnit
     */
    public function getSelection($group_name, $name);

    /**
     * @param string $group_name
     * @param string $name
     *
     * @return bool
     */
    public function selectionExist($group_name, $name);
}
