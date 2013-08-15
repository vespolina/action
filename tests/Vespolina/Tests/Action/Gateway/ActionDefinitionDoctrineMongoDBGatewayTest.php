<?php

namespace Vespolina\Action\Tests\Gateway;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;

use Vespolina\Action\Gateway\ActionDoctrineMongoDBGateway;
use Vespolina\Entity\Action\ActionDefinition;


/**
 */
class ActionManagerDoctrineMongoDBGatewayTest extends \PHPUnit_Framework_TestCase
{

    public function testAddAndFind()
    {
        $actionDefinition = new ActionDefinition('callForHelp', 'myTopic');
        $actionDefinition->setHandlerClass('DummyTest');
        $this->gateway->updateActionDefinition($actionDefinition);
        
        $retrievedActionDefinition = $this->gateway->findByName('callForHelp');
        $this->assertNotNull($retrievedActionDefinition);
        $this->assertEquals('callForHelp', $retrievedActionDefinition->getName());
        $this->assertEquals('myTopic', $retrievedActionDefinition->getTopic());
        $this->assertEquals('DummyTest', $retrievedActionDefinition->getHandlerClass());


    }

    protected function setUp()
    {
        $config = new \Doctrine\ODM\MongoDB\Configuration();
        $config->setDefaultDB('v_test_actions');
        $config->setHydratorDir(sys_get_temp_dir());
        $config->setHydratorNamespace('Hydrators');
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Proxies');

        $locatorXml = new SymfonyFileLocator(
            array(
                __DIR__ . '/../../../../../lib/Vespolina/Action/Mapping' => 'Vespolina\\Entity\\Action',
            ),
            '.mongodb.xml'
        );

        $xmlDriver = new XmlDriver($locatorXml);

        $config->setMetadataDriverImpl($xmlDriver);
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setAutoGenerateProxyClasses(true);

        $doctrineODM = \Doctrine\ODM\MongoDB\DocumentManager::create(null, $config);
        $this->gateway = new ActionDoctrineMongoDBGateway($doctrineODM);

        parent::setUp();
    }
}
