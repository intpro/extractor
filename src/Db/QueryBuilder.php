<?php

namespace Interpro\Extractor\Db;

use Illuminate\Database\Query\Builder;

class QueryBuilder
{
    private $builder;

    /**
     * @param string $Atype_name
     *
     * @return void
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param  int  $value
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function skip($value)
    {
        $this->builder->offset($value);

        return $this;
    }

    /**
     * @param  int  $value
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function take($value)
    {
        $this->builder->limit($value);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  mixed   $values
     * @param  string  $boolean
     * @param  bool    $not
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function whereIn($column, $values)
    {
        $this->builder->whereIn($column, $values);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  mixed   $values
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function orWhereIn($column, $values)
    {
        $this->builder->orWhereIn($column, $values);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  mixed   $values
     * @param  string  $boolean
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function whereNotIn($column, $values)
    {
        $this->builder->whereNotIn($column, $values);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  mixed   $values
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function orWhereNotIn($column, $values)
    {
        $this->builder->orWhereNotIn($column, $values);

        return $this;
    }

    /**
     * @param  string|array|\Closure  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @param  string  $boolean
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function where($column, $operator = null, $value = null)
    {
        $this->builder->where($column, $operator, $value);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  string  $operator
     * @param  mixed   $value
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function orWhere($column, $operator, $value)
    {
        $this->builder->orWhere($column, $operator, $value);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  array   $values
     * @param  string  $boolean
     * @param  bool  $not
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function whereBetween($column, array $values)
    {
        $this->builder->whereBetween($column, $values);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  array   $values
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function orWhereBetween($column, array $values)
    {
        $this->builder->orWhereBetween($column, $values);

        return $this;
    }

    /**
     * @param  string  $sql
     * @return $this
     */
    public function whereRaw($sql)
    {
        $this->builder->whereRaw($sql);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->builder->orderBy($column, $direction);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  array   $values
     * @param  string  $boolean
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function whereNotBetween($column, array $values)
    {
        $this->builder->whereNotBetween($column, $values);

        return $this;
    }

    /**
     * @param  string  $column
     * @param  array   $values
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function orWhereNotBetween($column, array $values)
    {
        $this->builder->orWhereNotBetween($column, $values);

        return $this;
    }

    /**
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->builder->select($columns);

        return $this;
    }

    /**
     * @param  string  $table
     * @param  string  $first
     * @param  string  $operator
     * @param  string  $second
     * @return \Interpro\Extractor\Db\QueryBuilder
     */
    public function leftJoin($table, $first, $operator = null)
    {
        $this->builder->leftJoin($table, $first, $operator);

        return $this;
    }

    /**
     * @param  array  $columns
     * @return array|static[]
     */
    public function get($columns = ['*'])
    {
        return $this->builder->get($columns);
    }

    /**
     * @param  array  $columns
     * @return array|static[]
     */
    public function count()
    {
        return $this->builder->count();
    }

    /**
     * @param  array|mixed  $column
     * @return $this
     */
    public function addSelect($column)
    {
        $this->builder->addSelect($column);

        return $this;
    }

    /**
     * @param  mixed   $value
     * @param  string  $type
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addBinding($value, $type = 'where')
    {
        $this->builder->addBinding($value, $type);

        return $this;
    }

    /**
     * @return string
     */
    public function toSql()
    {
        return $this->builder->toSql();
    }

}
