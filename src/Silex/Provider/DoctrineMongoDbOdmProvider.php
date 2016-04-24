<?php

namespace Saxulum\DoctrineMongoDbOdm\Silex\Provider;

use Saxulum\DoctrineMongoDbOdm\Provider\DoctrineMongoDbOdmProvider as BaseDoctrineMongoDbOdmProvider;
use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class DoctrineMongoDbOdmProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $pimpleServiceProvider = new BaseDoctrineMongoDbOdmProvider;
        $pimpleServiceProvider->register($container);
    }
}
