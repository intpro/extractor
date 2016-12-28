<?php

namespace Interpro\Extractor\Items;

use Interpro\Core\Taxonomy\Enum\TypeMode;
use Interpro\Extractor\Contracts\Collections\FieldsCollection as FieldsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\OwnsCollection as OwnsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\RefsCollection as RefsCollectionInterface;
use Interpro\Extractor\Contracts\Collections\SubVarCollection;
use Interpro\Extractor\Contracts\Fields\Field;
use Interpro\Extractor\Contracts\Fields\OwnField;
use Interpro\Extractor\Contracts\Fields\RefField;
use Interpro\Extractor\Contracts\Items\AItem as AItemInterface;
use Interpro\Extractor\Exception\ExtractorException;

abstract class AItem implements AItemInterface
{
    private $fields;
    private $refs;
    private $owns;
    private $subVars;

    /**
     * @param \Interpro\Extractor\Contracts\Collections\FieldsCollection $fields
     * @param \Interpro\Extractor\Contracts\Collections\OwnsCollection $owns
     * @param \Interpro\Extractor\Contracts\Collections\RefsCollection $refs
     * @param \Interpro\Extractor\Contracts\Collections\SubVarCollection $subVar
     *
     * @return void
     */
    public function __construct(FieldsCollectionInterface $fields, OwnsCollectionInterface $owns, RefsCollectionInterface $refs, SubVarCollection $subVar)
    {
        $this->fields = $fields;
        $this->refs = $refs;
        $this->owns = $owns;
        $this->subVars = $subVar;
    }

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return \Interpro\Core\Contracts\Ref\ARef
     */
    abstract public function getSelfRef();

    /**
     * @return \Interpro\Extractor\Contracts\Fields\Field
     */
    public function setField(Field $field)
    {
        $this->fields->addField($field);
    }

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\RefField
     */
    public function setRef(RefField $refField)
    {
        $this->refs->addRef($refField);
    }

    /**
     * @param string $own_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\OwnField
     */
    public function setOwn(OwnField $ownField)
    {
        $this->owns->addOwn($ownField);
    }

    /**
     * @return \Interpro\Extractor\Contracts\Fields\Field
     */
    public function getField($field_name)
    {
        return $this->fields->getFieldByName($field_name);
    }

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\RefField
     */
    public function getRef($ref_name)
    {
        return $this->refs->getRefByName($ref_name);
    }

    /**
     * @param string $own_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\OwnField
     */
    public function getOwn($own_name)
    {
        return $this->owns->getOwnByName($own_name);
    }

    /**
     * @return \Interpro\Extractor\Contracts\Collections\FieldsCollection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return \Interpro\Extractor\Contracts\Collections\RefsCollection
     */
    public function getRefs()
    {
        return $this->refs;
    }

    /**
     * @return \Interpro\Extractor\Contracts\Collections\OwnsCollection
     */
    public function getOwns()
    {
        return $this->owns;
    }

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\AType
     */
    abstract public function getType();

    /**
     * @param string $group_name
     * @param string $ref_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function getGroupCustom($group_name, $ref_name, $selection_name = 'group')
    {
        return $this->subVars->getCollectionSet($ref_name)->getGroup($group_name, $selection_name);
    }

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     *
     * Получение коллекции подчиненных блоку коллекций Групп
     */
    public function getGroupSetCustom($ref_name)
    {
        return $this->subVars->getCollectionSet($ref_name);
    }

    /**
     * Получение группы непосредственно подчиненной блоку
     *
     * @param string $group_name
     * @param string $selection_name
     *
     * @return \Interpro\Extractor\Contracts\Collections\GroupCollection
     */
    public function getGroup($group_name, $selection_name = 'group')
    {
        return $this->getGroupCustom($group_name, 'superior', $selection_name);
    }

    /**
     * @return \Interpro\Extractor\Contracts\Collections\GroupsCollectionSet
     *
     * Получение коллекции подчиненных блоку коллекций Групп
     */
    public function getGroupSet()
    {
        return $this->getGroupSetCustom('superior');
    }

    private function prepareValue(Field $field)
    {
        $meta = $field->getFieldMeta();

        if($meta->getMode() === TypeMode::MODE_C)
        {
            return $field->getValue();
        }
        elseif($meta->getMode() === TypeMode::MODE_B)
        {
            return $field->getItem();
        }
        elseif($meta->getMode() === TypeMode::MODE_A)
        {
            return $field->getId();
        }

        return null;
    }

    /**
     * @param string $req_name
     *
     * @return mixed
     */
    public function __get($req_name)
    {
        $suffix_pos = strripos($req_name, '_');

        if($suffix_pos)
        {
            $suffix = substr($req_name, $suffix_pos+1);
            $name = substr($req_name, 0, $suffix_pos);

            if ($suffix === 'group')
            {
                return $this->getGroup($name);
            }
            elseif($suffix === 'field')
            {
                $field = $this->getField($name);
                return $this->prepareValue($field);
            }
            elseif($suffix === 'own')
            {
                return $this->getOwn($name);
            }
            elseif($suffix === 'ref')
            {
                return $this->getRef($name);
            }
        }
        else
        {
            if($req_name === 'groups')
            {
                return $this->getGroupSet();
            }
            elseif($req_name === 'fields')
            {
                return $this->getFields();
            }
            elseif($req_name === 'owns')
            {
                return $this->getOwns();
            }
            elseif($req_name === 'refs')
            {
                return $this->getRefs();
            }
        }

        //Крайний случай - пытаемся получить поле (собственное или ссылку)
        $field = $this->getField($req_name);
        return $this->prepareValue($field);
    }

    /**
     * @return bool
     */
    public function cap()
    {
        return false;
    }

}
