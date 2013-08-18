<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Action\Gateway;

use Doctrine\ODM\MongoDB\DocumentManager;
use Vespolina\Entity\Action\ActionInterface;
use Vespolina\Entity\Action\ActionDefinitionInterface;

class ActionDoctrineMongoDBGateway implements ActionGatewayInterface
{
    protected $actionClass;
    protected $actionDefinitionClass;
    protected $dm;

    /**
     * @param DocumentManager $dm
     * @param string $actionDefinitionClass
     * @param string $actionClass
     */
    public function __construct(DocumentManager $dm,
                                $actionDefinitionClass = 'Vespolina\Entity\Action\ActionDefinition',
                                $actionClass = 'Vespolina\Entity\Action\Action')
    {
        $this->actionClass = $actionClass;
        $this->actionDefinitionClass = $actionDefinitionClass;
        $this->dm = $dm;
    }

    public function findActionsByState($state, $subject = null)
    {
        return $this->dm->createQueryBuilder($this->actionClass)
            ->field('state')->equals($state)
            ->getQuery()
            ->execute();
    }

    
    public function findDefinitionByName($name)
    {
        return $this->dm->createQueryBuilder($this->actionDefinitionClass)
            ->field('name')->equals($name)
            ->getQuery()
            ->getSingleResult();
    }
    
    public function findByEventName($eventName)
    {
        $definitions = array();
        
        return $definitions;
    }
    
    public function findByTopic($topic)
    {
        return $this->dm->createQueryBuilder($this->actionDefinitionClass)
            ->field('topic')->equals($topic)
            ->getQuery()
            ->execute();
    }

    public function updateAction(ActionInterface $action)
    {
        $this->dm->persist($action);
        $this->dm->flush();
    }
    
    public function updateActionDefinition(ActionDefinitionInterface $actionDefinition)
    {
        $this->dm->persist($actionDefinition);
        $this->dm->flush();
    }
}
