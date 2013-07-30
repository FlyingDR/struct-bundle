<?php

namespace Flying\Bundle\StructBundle\Storage;

use Flying\Struct\Storage\BackendInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Structures storage backend implementation
 * to allow storing structures information into session
 */
class SessionBackend implements BackendInterface
{
    /**
     * Session to use for storing information
     * @var SessionInterface
     */
    protected $_session;
    /**
     * Namespace to use for storing information in session
     * @var string
     */
    protected $_namespace = 'flying_struct_storage';
    /**
     * Information storage
     * @var AttributeBag
     */
    protected $_storage;

    /**
     * Class constructor
     *
     * @param SessionInterface $session     Session to use for storing information
     * @param string $namespace             OPTIONAL Namespace to use for storing information in session
     * @return SessionBackend
     */
    public function __construct(SessionInterface $session, $namespace = null)
    {
        $this->_session = $session;
        if (strlen($namespace)) {
            $this->_namespace = $namespace;
        }
        $this->_session->setId('mg0ot6e35st3mk020fa7ef8u31');
        $bag = new AttributeBag($this->_namespace);
        $bag->setName($this->_namespace);
        $this->_session->registerBag($bag);
        // Bag is get back from session to allow its initialization
        $this->_storage = $this->_session->getBag($this->_namespace);
    }

    /**
     * {@inheritdoc}
     */
    public function load($key)
    {
        return $this->_storage->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function save($key, $contents)
    {
        $this->_storage->set($key, $contents);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->_storage->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $this->_storage->remove($key);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->_storage->clear();
    }

}
