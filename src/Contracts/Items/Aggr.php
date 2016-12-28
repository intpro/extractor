<?php

namespace Interpro\Extractor\Contracts\Items;

interface Aggr
{
    /**
     * @return \Interpro\Extractor\Contracts\Fields\Field
     */
    public function getField($field_name);

    /**
     * @param string $ref_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\RefField
     */
    public function getRef($ref_name);

    /**
     * @param string $own_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\OwnField
     */
    public function getOwn($own_name);

    /**
     * @return \Interpro\Extractor\Contracts\Collections\FieldsCollection
     */
    public function getFields();

    /**
     * @return \Interpro\Extractor\Contracts\Collections\RefsCollection
     */
    public function getRefs();

    /**
     * @return \Interpro\Extractor\Contracts\Collections\OwnsCollection
     */
    public function getOwns();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\AggrType
     */
    public function getType();

    /**
     * @param string $req_name
     *
     * @return mixed
     */
    public function __get($req_name);

}
