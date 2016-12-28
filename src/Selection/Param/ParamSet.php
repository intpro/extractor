<?php

namespace Interpro\Extractor\Selection\Param;

use Interpro\Core\Contracts\Taxonomy\Types\AggrType;
use Interpro\Extractor\Exception\ExtractorException;
use Interpro\Extractor\Contracts\Selection\ParamSet as ParamSetInterface;
use Interpro\Extractor\Db\QueryBuilder as Builder;

class ParamSet implements ParamSetInterface
{
    private $Atype;
    private $skip;
    private $take;

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\AggrType $Atype
     *
     * @return void
     */
    public function __construct(AggrType $Atype)
    {
        $this->Atype = $Atype;
        $this->skip  = null;
        $this->take  = null;
    }

    /**
     * @param int $value
     *
     * @return void
     */
    public function skip($value)
    {
        if(!is_int($value))
        {
            throw new ExtractorException('Параметр skip должен быть целым значением больше нуля(0), передано '.gettype($value).'!');
        }

        $this->skip = $value;
    }

    /**
     * @param int $value
     *
     * @return void
     */
    public function take($value)
    {
        if(!is_int($value))
        {
            throw new ExtractorException('Параметр take должен быть целым значением больше нуля(0), передано '.gettype($value).'!');
        }

        $this->take = $value;
    }

    /**
     * @param Builder $query
     *
     * @return void
     */
    public function apply(Builder $query)
    {
        if($this->skip !== null)
        {
            $query->skip($this->skip);
        }

        if($this->take !== null)
        {
            $query->take($this->take);
        }
    }

}
