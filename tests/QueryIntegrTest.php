<?php

namespace Interpro\Extractor\Test;

use Illuminate\Foundation\Testing\TestCase;
use Interpro\Extractor\Db\JoinMediator;
use Interpro\Extractor\Selection\Tuner;
use Interpro\ImageAggr\Db\ImageJoiner;
use Interpro\QS\Db\QSJoiner;
use Interpro\QS\Db\QSQuerier;
use Interpro\Scalar\Db\ScalarJoiner;

/**
 * Тэст интеграции qs "запросера" с собственным соединителем (по ссылкам) и соединителем полей скалярного типа (на уровне значений полей qs агрегатного типа)
 *
 * Class QueryIntegrTest
 * @package Interpro\Extractor\Test
 */
class QueryIntegrTest extends TestCase
{
    use TaxonomyTrait;

    private $joinMediator;
    private $qsQuerier;
    private $taxonomy;
    private $tuner;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        $this->createApplication();

        $this->taxonomy = $this->getTaxonomy();
        $this->tuner = new Tuner();
        $this->joinMediator = new JoinMediator();

        $scalarJoiner = new ScalarJoiner();
        $qsJoiner = new QSJoiner($this->joinMediator);
        $imageJoiner = new ImageJoiner();

        $this->joinMediator->registerJoiner($scalarJoiner);
        $this->joinMediator->registerJoiner($qsJoiner);
        $this->joinMediator->registerJoiner($imageJoiner);

        $this->qsQuerier = new QSQuerier($this->joinMediator);
    }

    public function testJoinedQuery()
    {
        $atype1 = $this->taxonomy->getGroup('group_bird_type');
        $selectionUnit1 = $this->tuner->initSelection($atype1, 'selection1');

        $selectionUnit1->like('example.descr', 'отличаются');
        $selectionUnit1->sortBy('example.title', 'ASC');

        $qb = $this->qsQuerier->selectByUnit($selectionUnit1);

        try
        {
            $res = $qb->get();
        }
        catch(\Exception $e)
        {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);

        //-----------------------------------------------------

        $atype2 = $this->taxonomy->getGroup('group_bird_class');
        $selectionUnit2 = $this->tuner->initSelection($atype2, 'selection2');

        $selectionUnit2->like('foto.crops.crop400x300.alt', 'альт картинки');

        $qb = $this->qsQuerier->selectByUnit($selectionUnit2);

        try
        {
            $res = $qb->get();
        }
        catch(\Exception $e)
        {
            $this->assertTrue(false);
        }

        $this->assertTrue(true);
    }

}
