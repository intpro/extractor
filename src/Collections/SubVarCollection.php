<?php

namespace Interpro\Extractor\Collections;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Core\Enum\OddEven;
use Interpro\Core\Iterator\FieldIterator;
use Interpro\Core\Iterator\OddEvenIterator;
use Interpro\Extractor\Contracts\Creation\CollectionFactory;
use Interpro\Extractor\Exception\ExtractorException;
use Interpro\Extractor\Contracts\Collections\SubVarCollection as SubVarCollectionInterface;

class SubVarCollection implements SubVarCollectionInterface
{
    protected $items = [];
    protected $item_names = [];
    private $position = 0;
    private $ref;
    private $refType;
    private $collectionFactory;

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param \Interpro\Extractor\Contracts\Creation\CollectionFactory $collectionFactory
     *
     * @return void
     */
    public function __construct(ARef $ref, CollectionFactory $collectionFactory)
    {
        $this->ref = $ref;
        $this->refType = $ref->getType();
        $this->collectionFactory = $collectionFactory;

        $this->item_names = $this->refType->getSubsSet()->getRefNames();
    }

    function rewind()
    {
        $this->position = 0;
    }

    function current()
    {
        $name = $this->item_names[$this->position];
        return $this->getCollectionSet($name);
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

    protected function getByName($name)
    {
        if(!$this->exist($name))
        {
            $this->notFoundAction($name);
        }
        return $this->items[$name];
    }

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     */
    public function getCollectionSet($ref_name)
    {
        if(!in_array($ref_name, $this->item_names))
        {
            $this->notFoundAction($ref_name);
        }

        if(!array_key_exists($ref_name, $this->items))
        {
            $this->items[$ref_name] = $this->collectionFactory->createCollectionSet($this->ref, $ref_name);
        }

        return $this->items[$ref_name];
    }

    protected function notFoundAction($name)
    {
        //throw new ExtractorException('Не найдена коллекция коллекций элементов групп подчиненная текущему элементу группы типа '.$this->ref->getType()->getName().' по имени ссылки '.$name.'!');
        return $this->collectionFactory->createCollectionSet($this->ref, $name); //Возвращаем пустышку
    }

    public function sortBy($path, $sort = 'ASC')
    {
        return new FieldIterator($this, $path, $sort);
    }

    public function odd()
    {
        //Заглушка чет-нечет для этой коллекции не нужен, пусть возвращает имена
        return new OddEvenIterator($this->item_names, OddEven::ODD);
    }

    public function even()
    {
        //Заглушка чет-нечет для этой коллекции не нужен, пусть возвращает имена
        return new OddEvenIterator($this->item_names, OddEven::EVEN);
    }

}
