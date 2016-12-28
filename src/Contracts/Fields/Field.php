<?php

namespace Interpro\Extractor\Contracts\Fields;

use Interpro\Core\Contracts\Named;

interface Field extends Named
{
    /**
     * @return \Interpro\Extractor\Contracts\Items\AItem
     */
    public function getOwner();

    /**
     * @return \Interpro\Extractor\Contracts\Items\Item
     */
    public function getItem();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\Field
     */
    public function getFieldMeta();
}
