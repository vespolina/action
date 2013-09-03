<?php

/**
 * (c) 2011 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Entity\Action;

class Action implements ActionInterface
{
    const STATE_INITIAL = 'initial';    //Not executed
    const STATE_COMPLETED = 'completed';    //Executing was a success
    const STATE_PENDING = 'pending';    //Action has been scheduled for completion
    const STATE_FAILURE = 'failure';    //Houston has been contacted

    protected $context;
    protected $definition;
    protected $name;
    protected $subject;
    protected $subjectId;
    protected $executedAt;
    protected $scheduledAt;
    protected $state;

    /**
     * @param $name Action name
     * @param string $subject subject (eg. order)
     * @param array $context
     */
    public function __construct(ActionDefinitionInterface $definition, $name, $subject = '', array $context = array())
    {
        $this->definition = $definition;
        $this->name = $name;
        $this->subject = $subject;
        $this->context = $context;
        $this->state = self::STATE_INITIAL;
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getState()
    {
        return $this->state;
    }

    public function isCompleted()
    {
        return $this->state == Action::STATE_COMPLETED;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setExecutedAt($executedAt)
    {
        $this->executedAt = $executedAt;
    }

    public function setScheduledAt($scheduledAt)
    {
        $this->scheduledAt = $scheduledAt;
    }
}
