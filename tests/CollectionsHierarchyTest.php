<?php

namespace Interpro\Extractor\Test;

use Interpro\Extractor\Load\TestLoader;

class CollectionsHierarchyTest extends \PHPUnit\Framework\TestCase
{
    use TaxonomyTrait;
    use TestCaseTrait;

    private $taxonomy;
    private $loader;
    private $case;
    private $case_hash;

    public function setUp(): void
    {
        //составлен из id групп
        $this->case_hash = '1(10(100(33),),20(200(33),),),2(30(300(22),),40(400(22),),),3(50(500(22),600(11),),60(700(22),),),';

        $this->case = $this->getCase();

        $this->taxonomy = $this->getTaxonomy();
        $this->loader   = new TestLoader($this->taxonomy, $this->case);
    }

    public function testApply()
    {
        $groupType = $this->taxonomy->getType('group_bird_type');

        $collectionBirdType = $this->loader->loadGroupCollection($groupType, 'group');

        $rezult_test = '';

        foreach($collectionBirdType as $birdTypeItem)
        {
            $rezult_test .= $birdTypeItem->getOwn('id')->getItem()->getValue().'(';

            $collectionBirdClass = $birdTypeItem->getGroup('group_bird_class');

            foreach($collectionBirdClass as $birdClassItem)
            {
                $rezult_test .= $birdClassItem->getOwn('id')->getItem()->getValue().'(';

                //==========
                $collectionBirdArea = $birdClassItem->getGroup('group_bird_area');

                foreach($collectionBirdArea as $birdAreaItem)
                {
                    $rezult_test .= $birdAreaItem->getOwn('id')->getItem()->getValue().'('.$birdAreaItem->getRef('area')->getRef()->getId().'),';
                }
                //==========

                $rezult_test .= '),';
            }

            $rezult_test .= '),';
        }

        //сравнение снимков
        $this->assertEquals($rezult_test, $this->case_hash);
    }

}
