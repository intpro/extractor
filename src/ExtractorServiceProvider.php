<?php

namespace Interpro\Extractor;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class ExtractorServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        Log::info('Загрузка ExtractorServiceProvider');
    }

    /**
     * @return void
     */
    public function register()
    {
        Log::info('Регистрация ExtractorServiceProvider');

        $this->app->singleton(
            'Interpro\Extractor\Contracts\Db\JoinMediator',
            'Interpro\Extractor\Db\JoinMediator'
        );

        $this->app->singleton(
            'Interpro\Extractor\Contracts\Creation\CItemBuilder',
            'Interpro\Extractor\Creation\CItemBuilder'
        );

        $this->app->singleton(
            'Interpro\Extractor\Contracts\Db\MappersMediator',
            'Interpro\Extractor\Db\MappersMediator'
        );

        $this->app->singleton(
            'Interpro\Extractor\Contracts\Selection\Tuner',
            'Interpro\Extractor\Selection\Tuner'
        );

        $this->app->singleton(
            'Interpro\Extractor\Contracts\Load\Loader',
            'Interpro\Extractor\Load\Loader'
        );

        $this->app->singleton(
            'Interpro\Extractor\Contracts\Creation\CollectionFactory',
            'Interpro\Extractor\Creation\CollectionFactory'
        );
    }

}
