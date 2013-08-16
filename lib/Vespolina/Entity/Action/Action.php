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
    const STATE_SUCCESS = 'success';    //Executing succesful
    const STATE_FAILURE = 'failure';    //Houston has been contacted

    protected $context;
    protected $name;
    protected $subject;
    protected $subjectId;
    protected $executedAt;
    protected $scheduledAt;
    protected $state;

    public function __construct($name, $subject = '', array $context = array())
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->context = $context;
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
        return $this->state == Action::STATE_SUCCESS;
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
