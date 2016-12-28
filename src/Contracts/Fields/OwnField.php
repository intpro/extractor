<?php

namespace Interpro\Extractor\Contracts\Fields;

interface OwnField extends Field
{
    /**
     * @return \Interpro\Extractor\Contracts\Items\OwnItem
     */
    public function getItem();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\OwnField
     */
    public function getFieldMeta();
}
