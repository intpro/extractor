<?php

namespace Interpro\Extractor\Db;

use Interpro\Core\Contracts\Taxonomy\Fields\Field;
use Interpro\Extractor\Contracts\Db\Joiner;
use Interpro\Extractor\Contracts\Db\JoinMediator as JoinMediatorInterface;
use Interpro\Extractor\Exception\ExtractorException;

class JoinMediator implements JoinMediatorInterface
{
    private $joiners = [];

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Fields\Field $field
     * @param array $join_array
     *
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function externalJoin(Field $field, $join_array)
    {
        //Получение типа поля
        $family = $field->getFieldTypeFamily();

        //Обращение к агенту
        $joiner = $this->getJoiner($family);

        //Тип передаем на тот случай, если агент обрабатывает более одного типа, и ему надо будет решить как быть дальше
        $sub_q = $joiner->joinByField($field, $join_array);

        return $sub_q;
    }

    /**
     * @return \Interpro\Extractor\Contracts\Db\Joiner
     */
    private function getJoiner($family)
    {
        if(array_key_exists($family, $this->joiners))
        {
            return $this->joiners[$family];
        }
        else
        {
            throw new ExtractorException('Не найден соединитель для пакета '.$family.'!');
        }
    }

    /**
     * @param \Interpro\Extractor\Contracts\Db\Joiner
     *
     * @return void
     */
    public function registerJoiner(Joiner $joiner)
    {
        $family = $joiner->getFamily();

        if(array_key_exists($family, $this->joiners))
        {
            throw new ExtractorException('Joiner запросов пакета '.$family.' уже зарегестрирована в медиаторе!');
        }

        $this->joiners[$family] = $joiner;
    }

}
