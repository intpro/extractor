<?php

namespace Interpro\Extractor\Test;

use Interpro\Core\Taxonomy\Manifests\BTypeManifest;

trait TaxonomyTrait
{
    public function getTaxonomy()
    {
        //Блок птицы: группа типы птиц (хищные, нелетающие и т. д.),
        //типам подчинен класс - орлы, соколы, куры всякие, среда обитания класса подчинена классу (ссылка на класс и группу среды обитания из соседнего блока)
        //Блок среды обитания: группа среды

        $taxonomyFactory = new \Interpro\Core\Taxonomy\Factory\TaxonomyFactory();

        $family = 'qs';
        $name = 'block_birds';
        $owns = ['descr'=>'string', 'title'=>'string'];
        $manA1 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::BLOCK, $owns, []);

        $family = 'qs';
        $name = 'block_areas';
        $owns = ['descr'=>'string', 'title'=>'string'];
        $manA2 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::BLOCK, $owns, []);

        $family = 'qs';
        $name = 'group_area';
        $owns = ['id'=>'int', 'descr'=>'string', 'title'=>'string'];
        $refs = ['block_name'=>'block_areas'];
        $manA3 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::GROUP, $owns, $refs);

        $family = 'qs';
        $name = 'group_bird_type';
        $owns = ['id'=>'int', 'descr'=>'string', 'title'=>'string'];
        $refs = ['block_name'=>'block_birds', 'example'=>'group_bird_class'];
        $manA4 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::GROUP, $owns, $refs);

        $family = 'qs';
        $name = 'group_bird_class';
        $owns = ['id'=>'int', 'descr'=>'string', 'title'=>'string', 'foto'=>'image'];
        $refs = ['block_name'=>'block_birds', 'superior'=>'group_bird_type'];
        $manA5 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::GROUP, $owns, $refs);

        $family = 'qs';
        $name = 'group_bird_area';
        $owns = ['id'=>'int'];
        $refs = ['block_name'=>'block_birds', 'superior'=>'group_bird_class', 'area'=>'group_area'];
        $manA6 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::GROUP, $owns, $refs);

        $family = 'scalar';
        $name = 'string';
        $manC1 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);

        $family = 'scalar';
        $name = 'int';
        $manC2 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);

        $imageMan  = new BTypeManifest('imageaggr', 'image',
            ['name' => 'string'],
            []);

        $resizeMan = new BTypeManifest('imageaggr', 'resize',
            ['name' => 'string',
                'alt' => 'string',
                'link' => 'string',
                'width' => 'int',
                'height' => 'int',
                'cache_index' => 'int'],
            ['original' => 'image']);

        $cropMan   = new BTypeManifest('imageaggr', 'crop',
            ['name' => 'string',
                'alt' => 'string',
                'link' => 'string',
                'cache_index' => 'int',
                'x' => 'int',
                'y' => 'int',
                'width' => 'int',
                'height' => 'int'],
            ['original' => 'image',
                'man' => 'resize',
                'target' => 'resize']);

        $manifestsCollection = new \Interpro\Core\Taxonomy\Collections\ManifestsCollection();
        $manifestsCollection->addManifest($manA1);
        $manifestsCollection->addManifest($manA2);
        $manifestsCollection->addManifest($manA3);
        $manifestsCollection->addManifest($manA4);
        $manifestsCollection->addManifest($manA5);
        $manifestsCollection->addManifest($manA6);
        $manifestsCollection->addManifest($manC1);
        $manifestsCollection->addManifest($manC2);

        $manifestsCollection->addManifest($imageMan);
        $manifestsCollection->addManifest($resizeMan);
        $manifestsCollection->addManifest($cropMan);

        $taxonomy = $taxonomyFactory->createTaxonomy($manifestsCollection);

        return $taxonomy;
    }

}
