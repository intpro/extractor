<?php

namespace Interpro\Extractor\Contracts\Fields;

interface AggrOwnField extends OwnField
{
    /**
     * @return \Interpro\Extractor\Contracts\Items\AggrOwnItem
     */
    public function getItem();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\OwnField
     */
    public function getFieldMeta();
}
