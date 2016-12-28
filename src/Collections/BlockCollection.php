<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Collections\BlockCollection as BlockCollectionInterface;
use Interpro\Extractor\Contracts\Items\BlockItem;
use Interpro\Extractor\Exception\ExtractorException;

class BlockCollection extends NamedCollection implements BlockCollectionInterface
{
    /**
     * @param string $block_name
     *
     * @return \Interpro\Extractor\Contracts\Items\BlockItem
     */
    public function getBlock($block_name)
    {
        return parent::getByName($block_name);
    }

    /**
     * @param \Interpro\Extractor\Contracts\Items\BlockItem $block
     *
     * @return void
     */
    public function addBlock(BlockItem $block)
    {
        parent::addByName($block);
    }

    protected function notFoundAction($name)
    {
        throw new ExtractorException('Не найден блок по имени '.$name.'!');
    }
}
