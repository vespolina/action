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
    protected $context;
    protected $name;
    protected $subject;

    public function __construct($name, $subject, array $context = array())
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
}
