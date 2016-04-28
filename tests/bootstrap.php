<?php

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->setPsr4('Saxulum\\Tests\\', __DIR__);
$loader->setPsr4('Saxulum\\Tests\\DoctrineMongoDbOdm\\', __DIR__);
$loader->setPsr4('Saxulum\\DoctrineMongoDb\\', sprintf('%s/../vendor/df/doctrine-mongodb-provider/src/', __DIR__));

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);
