<?php

namespace Flying\Bundle\StructBundle\Storage;

use Flying\Struct\Storage\Storage as StructStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Structures storage integrated with Symfony 2
 */
class Storage extends StructStorage implements EventSubscriberInterface
{

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::TERMINATE   => 'flush',
        );
    }

}
