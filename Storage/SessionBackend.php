<?php

namespace Flying\Bundle\StructBundle\Storage;

use Flying\Struct\Storage\BackendInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Structures storage backend implementation
 * to allow storing structures information into session
 */
class SessionBackend implements BackendInterface
{
    /**
     * Session to use for storing information
     *
     * @var SessionInterface
     */
    protected $session;
    /**
     * Namespace to use for storing information in session
     *
     * @var string
     */
    protected $namespace = 'flying_struct';

    /**
     * Class constructor
     *
     * @param SessionInterface $session Session to use for storing information
     * @param AttributeBag $bag         Session's attribute bag (getting it from container because there is no way to get it from session itself)
     * @param string $namespace         OPTIONAL Namespace to use for storing information in session
     * @return SessionBackend
     */
    public function __construct(SessionInterface $session, AttributeBag $bag = null, $namespace = null)
    {
        $this->session = $session;
        if ($bag instanceof NamespacedAttributeBag) {
            // Namespace separation character from namespaced attribute bag,
            // hardcoded here because it can't be obtained from service itself
            $nsChar = '/';
            if ($namespace !== '') {
                $this->namespace = rtrim($namespace, $nsChar);
            }
            $this->namespace .= $nsChar;
        } else {
            $this->namespace = '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($key)
    {
        return $this->session->get($this->namespace . $key);
    }

    /**
     * {@inheritdoc}
     */
    public function save($key, $contents)
    {
        $this->session->set($this->namespace . $key, $contents);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->session->has($this->namespace . $key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $this->session->remove($this->namespace . $key);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->session->clear();
    }
}
