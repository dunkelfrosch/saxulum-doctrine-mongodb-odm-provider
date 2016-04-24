<?php

namespace Saxulum\Tests\DoctrineMongoDbOdm\Silex\Provider;

use Silex\Application;
use Doctrine\ODM\MongoDB\Configuration as MongoDbConfiguration;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Saxulum\DoctrineMongoDb\Silex\Provider\DoctrineMongoDbProvider;
use Saxulum\DoctrineMongoDbOdm\Silex\Provider\DoctrineMongoDbOdmProvider;
use Saxulum\Tests\DoctrineMongoDbOdm\Document\Page;
use Saxulum\Tests\DoctrineTestCase;

/**
 * Class DoctrineMongoDbOdmProviderTest
 *
 * @package Saxulum\Tests\DoctrineMongoDbOdm\Silex\Provider
 */
class DoctrineMongoDbOdmProviderTest extends DoctrineTestCase
{
    /**
     * check/test registration
     */
    public function testRegister()
    {
        /** @var Application $app */
        $app = $this->createMockDefaultApp();
        $app->register(new DoctrineMongoDbOdmProvider);
        /** @var MongoDbConfiguration $mongoDbConfig */
        $mongoDbConfig = $app['mongodbodm.dm.config'];

        $this->assertEquals($app['mongodbodm.dm'], $app['mongodbodm.dms']['default']);
        $this->assertInstanceOf('Doctrine\Common\Cache\ArrayCache', $mongoDbConfig->getMetadataCacheImpl());
        $this->assertInstanceOf('Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain', $mongoDbConfig->getMetadataDriverImpl());
    }

    /**
     * check/test annotation mapping
     */
    public function testAnnotationMapping()
    {
        if (!extension_loaded('mongo')) {
            $this->markTestSkipped('mongo is not available');
        }

        $proxyPath = sprintf('%s/doctrine/proxies', $this->getCacheDir());
        $hydratorPath = sprintf('%s/doctrine/hydrator', $this->getCacheDir());

        @mkdir($proxyPath, 0777, true);
        @mkdir($hydratorPath, 0777, true);

        $app = new Application;

        $app->register(new DoctrineMongoDbProvider(), array(
            'mongodb.options' => array(
                'server' => 'mongodb://localhost:27017'
            )
        ));

        $app->register(new DoctrineMongoDbOdmProvider, [
            "mongodbodm.proxies_dir" => $proxyPath,
            "mongodbodm.hydrator_dir" => $hydratorPath,
            "mongodbodm.dm.options" => [
                "database" => "test",
                "mappings" => [
                    [
                        "type" => "annotation",
                        "namespace" => "Saxulum\\Tests\\DoctrineMongoDbOdm\\Document",
                        "path" => __DIR__."../../Document",
                        "use_simple_annotation_reader" => false
                    ]
                ],
            ],
        ]);

        $title = 'title';
        $body = 'body';

        $page = new Page();
        $page->setTitle($title);
        $page->setBody($body);

        $app['mongodbodm.dm']->persist($page);
        $app['mongodbodm.dm']->flush();

        /** @var DocumentRepository $repository */
        $repository = $app['mongodbodm.dm']->getRepository("Saxulum\\Tests\\DoctrineMongoDbOdm\\Document\\Page");

        /** @var Page $pageFromDb */
        $pageFromDb = $repository->findOneBy(['id' => 'DESC']);

        $this->assertEquals($title, $pageFromDb->getTitle());
        $this->assertEquals($body, $pageFromDb->getBody());
    }
}
