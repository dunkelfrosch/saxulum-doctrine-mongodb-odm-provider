<?php

namespace Saxulum\DoctrineMongoDbOdm\Silex\Provider;

use Silex\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Saxulum\DoctrineMongoDbOdm\Provider\DoctrineMongoDbOdmProvider as BaseDoctrineMongoDbOdmProvider;

/**
 * Class DoctrineMongoDbOdmProvider
 * 
 * @package Saxulum\DoctrineMongoDbOdm\Silex\Provider
 */
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
