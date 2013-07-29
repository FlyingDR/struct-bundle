<?php

namespace Flying\Bundle\StructBundle\Storage;

use Flying\Struct\Storage\Storage as StructStorage;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Structures storage integrated with Symfony 2
 */
class Storage extends StructStorage
{

    /**
     * Class constructor
     *
     * @param EventDispatcher $dispatcher
     * @return Storage
     */
    public function __construct(EventDispatcher $dispatcher)
    {
        // Register storage flushing method for kernel termination event
        // to make sure that all changes are saved
        $dispatcher->addListener('kernel.terminate', array($this, 'flush'));
    }

}
