<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\Extractor\Contracts\Collections\RefFilter as RefFilterInterface;
use Interpro\Extractor\Contracts\Collections\MapGroupCollection as MapCollectionInterface;
use Interpro\Extractor\Contracts\Creation\CollectionFactory;
use Interpro\Extractor\Contracts\Items\GroupItem;
use Interpro\Extractor\Exception\ExtractorException;

class MapGroupCollection extends GroupCollection implements MapCollectionInterface
{
    private $separated = [];
    private $collectionFactory;

    public function __construct(GroupType $groupType, CollectionFactory $collectionFactory)
    {
        parent::__construct($groupType);

        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param \Interpro\Extractor\Contracts\Items\GroupItem
     *
     * @return void
     */
    public function addItem(GroupItem $groupItem)
    {
        parent::addItem($groupItem);

        foreach($groupItem->getRefs() as $refField)
        {
            $ref_name = $refField->getName();

            $collection = $this->getSubCollection($ref_name, $refField->getRef());

            $collection->addItem($groupItem);
        }
    }

    /**
     * @param \Interpro\Extractor\Contracts\Collections\RefFilter $refFilter
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function filterByRef(RefFilterInterface $refFilter)
    {
        $ref_name = $refFilter->getName();

        if(!$this->getType()->refExist($ref_name))
        {
            throw new ExtractorException('Ссылки по имени '.$ref_name.' в типе группы '.$this->getName().' не существует!');
        }

        $refMeta = $this->getType()->getRef($ref_name);

        if($refFilter->getType() !== $refMeta->getFieldType())
        {
            throw new ExtractorException('Ссылки по имени '.$ref_name.' на тип '.$refFilter->getType()->getName().' в типе группы '.$this->getName().' не существует!');
        }

        $collection = $this->getSubCollection($ref_name, $refFilter->getRef());

        return $collection;
    }

    /**
     * @param ARef $ref
     * @param string $idkey
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    private function getSubCollection($ref_name, ARef $ref)
    {
        $idkey = 'id_'.$ref->getId();

        if(!array_key_exists($ref_name, $this->separated))
        {
            $this->separated[$ref_name] = [];
        }

        if(!array_key_exists($idkey, $this->separated[$ref_name]))
        {
            $this->separated[$ref_name][$idkey] = $this->collectionFactory->createGroupCollection($this->getType());
        }

        return $this->separated[$ref_name][$idkey];
    }

}
