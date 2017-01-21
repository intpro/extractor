<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Iterator\FieldIterator;
use Interpro\Extractor\Contracts\Load\Loader;
use Interpro\Extractor\Contracts\Collections\GroupsCollectionSet as GroupsCollectionSetInterface;
use Interpro\Extractor\Contracts\Collections\RefFilter as RefFilterInterface;
use Interpro\Extractor\Exception\ExtractorException;

class GroupsCollectionSet implements GroupsCollectionSetInterface
{
    protected $standart_items = [];
    protected $selection_items = [];
    protected $item_names = [];
    private $position = 0;
    private $refFilter;
    private $loader;

    /**
     * @param \Interpro\Extractor\Contracts\Collections\RefFilter $refFilter
     * @param \Interpro\Extractor\Contracts\Load\Loader $loader
     *
     * @return void
     */
    public function __construct(RefFilterInterface $refFilter, Loader $loader)
    {
        $this->refFilter  = $refFilter;
        $this->loader     = $loader;

        $subs = $refFilter->getSubs();

        $this->item_names = $subs->getSubNames();
    }

    function rewind()
    {
        $this->position = 0;
    }

    function current()
    {
        $name = $this->item_names[$this->position];
        return $this->getStandartSelection($name);
    }

    function key()
    {
        return $this->item_names[$this->position];
    }

    function next()
    {
        ++$this->position;
    }

    function valid()
    {
        return isset($this->item_names[$this->position]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->item_names);
    }

    public function exist($name)
    {
        return in_array($name, $this->item_names);
    }

    public function getName()
    {
        return $this->refFilter->getName();
    }

    private function getStandartSelection($group_name)
    {
        return $this->getGroup($group_name, 'group');
    }

    /**
     * @param string $group_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function getGroup($group_name, $selection_name = 'group')
    {
        $selection_key = $group_name.'_'.$selection_name;

        if(!in_array($group_name, $this->item_names))
        {
            $this->notFoundAction($selection_key);
        }

        if(!array_key_exists($selection_key, $this->selection_items))
        {
            $subType = $this->refFilter->getSub($group_name);
            $this->selection_items[$selection_key] = $this->loader->loadGroupCollectionAsSub($subType, $selection_name, $this->refFilter);

            if($selection_name === 'group')
            {
                $this->standart_items[$group_name] = $this->selection_items[$selection_key];
            }
        }

        return $this->selection_items[$selection_key];
    }

    protected function notFoundAction($name)
    {
        throw new ExtractorException('Не найдена коллекция элементов группы по имени '.$name.', подчиненная владельцу типа '.$this->refFilter->getTypeName().' по ссылке '.$this->refFilter->getName().'!');
    }

    public function sortBy($path, $sort = 'ASC')
    {
        return new FieldIterator($this, $path, $sort);
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
