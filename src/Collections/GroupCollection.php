<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Contracts\Taxonomy\Types\GroupType;
use Interpro\Core\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Collections\GroupCollection as GroupCollectionInterface;
use Interpro\Extractor\Contracts\Items\GroupItem;
use Interpro\Extractor\Exception\ExtractorException;

class GroupCollection extends NamedCollection implements GroupCollectionInterface
{
    private $groupType;

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $groupType
     */
    public function __construct(GroupType $groupType)
    {
        $this->groupType = $groupType;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\GroupType
     */
    public function getType()
    {
        return $this->groupType;
    }

    /**
     * @param int $id
     *
     * @return \Interpro\Extractor\Contracts\Items\GroupItem
     */
    public function getItem($id)
    {
        parent::getByName('id_'.$id);
    }

    /**
     * @param \Interpro\Extractor\Contracts\Items\GroupItem
     *
     * @return void
     */
    public function addItem(GroupItem $groupItem)
    {
        if($groupItem->getType() !== $this->getType())
        {
            throw new ExtractorException('Добавляемый элемент группы не соответствует типу элементов коллекции: '.$groupItem->getType()->getName().' => '.$this->getType()->getName());
        }

        parent::addByName($groupItem);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->groupType->getName();
    }

    protected function notFoundAction($name)
    {
        throw new ExtractorException('Не найден элемент группы '.$this->getName().' по '.$name.'!');
    }
}
