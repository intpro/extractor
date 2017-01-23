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

    private function funcByField($field_name, $func_name)
    {
        if(!$this->groupType->ownExist($field_name))
        {
            throw new ExtractorException('Поле для получения '.$func_name.' '.$field_name.' не найдено в собственных полях типа '.$this->getName().'!');
        }

        //НEоптимизированный метод пока! переделать при случае

        if($func_name === 'max' or $func_name === 'min')
        {
            $currentItem = null;

            $current_value = null;

            foreach($this as $item)
            {
                if($func_name === 'max')
                {
                    $ok = $item->$field_name > $current_value;
                }
                else
                {
                    $ok = $item->$field_name < $current_value;
                }

                if($ok or $current_value === null)
                {
                    $current_value = $item->$field_name;
                    $currentItem = $item;
                }
            }

            return $currentItem;
        }
        elseif($func_name === 'sum')
        {
            $sum = 0;

            foreach($this as $item)
            {
                $value = $item->$field_name;

                if(is_numeric($value))
                {
                    $sum += $value;
                }
                else
                {
                    return $sum;
                }
            }

            return $sum;
        }
        else
        {
            throw new ExtractorException('Функция '.$func_name.' не поддерживается в коллекции элементов групп!');
        }
    }

    /**
     * @param $field_name
     *
     * @return \Interpro\Extractor\Contracts\Items\GroupItem
     */
    public function maxByField($field_name)
    {
        return $this->funcByField($field_name, 'max');
    }

    /**
     * @param $field_name
     *
     * @return \Interpro\Extractor\Contracts\Items\GroupItem
     */
    public function minByField($field_name)
    {
        return $this->funcByField($field_name, 'min');
    }

    /**
     * @param $field_name
     *
     * @return int
     */
    public function sumByField($field_name)
    {
        return $this->funcByField($field_name, 'sum');
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

    /**
     * @param string $req_name
     *
     * @return mixed
     */
    public function __get($req_name)
    {
        if($req_name === 'name')
        {
            return $this->getName();
        }
        else
        {
            return null;
        }
    }
}
