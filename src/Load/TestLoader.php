<?php

namespace Interpro\Extractor\Load;

use Interpro\Core\Contracts\Taxonomy\Fields\RefField;
use Interpro\Core\Contracts\Ref\ARef as ARefInterface;
use Interpro\Core\Ref\ARef;
use Interpro\Core\Contracts\Taxonomy\Taxonomy;
use Interpro\Core\Taxonomy\Enum\TypeMode;
use Interpro\Core\Taxonomy\Enum\TypeRank;
use Interpro\Core\Taxonomy\Fields\OwnField;
use Interpro\Extractor\Creation\CollectionFactory;
use Interpro\Extractor\Contracts\Load\Loader as LoaderInterface;
use Interpro\Extractor\Contracts\Collections\RefFilter;
use Interpro\Extractor\Exception\ExtractorException;
use Interpro\Extractor\Fields\AARefField;
use Interpro\Extractor\Fields\ABOwnField;
use Interpro\Extractor\Fields\ACOwnField;
use Interpro\Extractor\Items\AItem;
use Interpro\Extractor\Items\BlockItem;
use Interpro\Extractor\Items\CItem;
use Interpro\Extractor\Items\GroupItem;

class TestLoader implements LoaderInterface
{
    private $selections = [];
    private $items = [];
    private $blocks = [];
    private $capMapper;

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     *
     * @return int
     */
    public function countGroup($type, $selection_name)
    {
        return 0;
    }

    private function addOwn(AItem $owner, OwnField $ownMeta, $own_val)
    {
        $type = $ownMeta->getFieldType();

        if($type->getMode() === TypeMode::MODE_B)
        {
            //Здесь будет установка значения
            $newField = new ABOwnField($owner, $ownMeta);
        }
        elseif($type->getMode() === TypeMode::MODE_C)
        {
            $scalarItem = new CItem($type, $own_val);
            $newField = new ACOwnField($owner, $ownMeta);
            $newField->setItem($scalarItem);
        }
        else
        {
            throw new ExtractorException('Тэстовый Loader не смог создать поле '.$ownMeta->getName().'!');
        }

        $owner->setOwn($newField);
        $owner->setField($newField);

        $this->capMapper = $capMapper = new CapAMapper();

        //Создаение полей пока без значений $own_val
    }

    private function addRef(AItem $owner, RefField $refMeta, $ref_id)
    {
        $type = $refMeta->getFieldType();

        if($type->getMode() === TypeMode::MODE_A)
        {
            $aRef = new ARef($type, $ref_id);

            $newField = new AARefField($owner, $refMeta, $aRef, $this->capMapper);
        }
        else
        {
            throw new ExtractorException('Тэстовый Loader не смог создать поле '.$refMeta->getName().'!');
        }

        $owner->setRef($newField);
    }

    /**
     * @param array $test_case
     *
     * @return void
     */
    public function __construct(Taxonomy $taxonomy, array $test_case)
    {
        $collectionFactory = new CollectionFactory($this);

        foreach($test_case as $entity_name => $case)
        {
            $type = $taxonomy->getType($entity_name);

            $rank = $type->getRank();

            if($rank === TypeRank::BLOCK)
            {
                $owns_array = $case['owns'];

                $aRef = new ARef($type, 0);

                $fields = $collectionFactory->createFieldsCollection();
                $owns   = $collectionFactory->createOwnsCollection();
                $refs   = $collectionFactory->createRefsCollection();
                $subVar = $collectionFactory->createSubVarCollection($aRef);

                $item = new BlockItem($aRef, $fields, $owns, $refs, $subVar);

                foreach($owns_array as $own_name => $own_val)
                {
                    $ownMeta = $type->getOwn($own_name);

                    $this->addOwn($item, $ownMeta, $own_val);
                }

                $this->items[$type->getName().'_0'] = $item;
                $this->blocks[$type->getName()] = $item;
                //Пока без ссылок прямо в блоке
            }
            elseif($rank === TypeRank::GROUP)
            {
                foreach($case as $item_case)
                {
                    $owns_array = $item_case['owns'];

                    if(array_key_exists('refs', $item_case))
                    {
                        $refs_array = $item_case['refs'];
                    }
                    else
                    {
                        $refs_array = [];
                    }

                    $aRef = new ARef($type, $owns_array['id']);

                    $fields = $collectionFactory->createFieldsCollection();
                    $owns   = $collectionFactory->createOwnsCollection();
                    $refs   = $collectionFactory->createRefsCollection();
                    $subVar = $collectionFactory->createSubVarCollection($aRef);

                    $item = new GroupItem($aRef, $fields, $owns, $refs, $subVar);

                    foreach($owns_array as $own_name => $own_val)
                    {
                        $ownMeta = $type->getOwn($own_name);

                        $this->addOwn($item, $ownMeta, $own_val);
                    }

                    foreach($refs_array as $ref_name => $ref_id)
                    {
                        $refMeta = $type->getRef($ref_name);

                        $this->addRef($item, $refMeta, $ref_id);
                    }

                    $this->items[$type->getName().'_'.$owns_array['id']] = $item;



                    //Элемент группы в коллекцию

                    $key = $type->getName().'_group';

                    if(!$this->exists($key))
                    {
                        $collection = $collectionFactory->createMapGroupCollection($type);
                        $this->selections[$key] = $collection;
                    }
                    else
                    {
                        $collection = $this->selections[$key];
                    }

                    $collection->addItem($item);
                }
            }
            else
            {
                continue;
            }
        }
    }

    private function exists($key)
    {
        return array_key_exists($key, $this->selections);
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapGroupCollection
     */
    private function getCollection($type, $selection_name)
    {
        $group_name = $type->getName();
        $key = $group_name.'_'.$selection_name;

        if(!$this->exists($key))
        {
            throw new ExtractorException('Тэстовый Loader не смог получить выборку из тэстового набора по ключу '.$key.'!');
        }

        return $this->selections[$key];
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapGroupCollection
     */
    public function loadGroupCollection($type, $selection_name)
    {
        $ACollection = $this->getCollection($type, $selection_name);

        return $ACollection;
    }

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\GroupType $type
     * @param string $selection_name
     * @param RefFilter $refFilter
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function loadGroupCollectionAsSub($type, $selection_name, RefFilter $refFilter)
    {
        $ACollection = $this->getCollection($type, $selection_name);

        $groupCollection = $ACollection->filterByRef($refFilter);

        return $groupCollection;
    }

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param bool $asUnitMember
     *
     * @return \Interpro\Extractor\Items\AItem
     */
    public function loadItem(ARefInterface $ref, $asUnitMember = false)
    {
        $key = $ref->getType()->getName().'_'.$ref->getId();

        if(!array_key_exists($key, $this->items))
        {
            throw new ExtractorException('Тэстовый Loader не смог получить Item из тэстового набора по ключу '.$key.'!');
        }
    }

}
