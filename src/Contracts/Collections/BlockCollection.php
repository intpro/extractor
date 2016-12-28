<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Items\BlockItem;

interface BlockCollection extends NamedCollection
{
    /**
     * @param string $block_name
     *
     * @return \Interpro\Extractor\Contracts\Items\BlockItem
     */
    public function getBlock($block_name);

    /**
     * @param \Interpro\Extractor\Contracts\Items\BlockItem $block
     *
     * @return void
     */
    public function addBlock(BlockItem $block);
}
