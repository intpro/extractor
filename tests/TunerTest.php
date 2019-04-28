<?php

namespace Interpro\Extractor\Test;

use Interpro\Core\Taxonomy\Types\GroupType;
use Interpro\Extractor\Selection\Tuner;
use Mockery as m;

class TunerTest extends \PHPUnit\Framework\TestCase
{
    private $selectionUnit;

    public function tearDown(): void
    {
        m::close();
    }

    protected function getBuilder()
    {
        return m::mock('Interpro\Extractor\Db\QueryBuilder');
    }

    public function setUp(): void
    {
        $tuner = new Tuner();
        $atype = new GroupType('group1', 'qsaggr');

        $this->selectionUnit = $tuner->initSelection($atype, 'selection1');
    }

    public function testApply()
    {
        $builder = $this->getBuilder();

        $builder->shouldReceive('take')->once();
        $builder->shouldReceive('skip')->once();
        $builder->shouldReceive('where')->times(2);
        $builder->shouldReceive('orderBy')->once();

        $this->selectionUnit->take(10);
        $this->selectionUnit->skip(5);

        $this->selectionUnit->like('field.path', 'test');
        $this->selectionUnit->notEq('field.path', 'test1');

        $this->selectionUnit->sortBy('field.path', 'ASC');

        //тест не полный, если понадобится дописывать
        $this->selectionUnit->apply($builder);

    }

}
