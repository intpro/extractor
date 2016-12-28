<?php

namespace Interpro\Extractor\Contracts\Fields;

interface RefField extends Field
{
    /**
     * @return \Interpro\Extractor\Contracts\Items\AggrItem
     */
    public function getItem();

    /**
     * @return \Interpro\Extractor\Contracts\Items\AggrItem
     */
    public function getOwner();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Fields\RefField
     */
    public function getFieldMeta();
}
