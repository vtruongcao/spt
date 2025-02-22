<?php
/**
 * SPT software - Application
 * 
 * @project: https://github.com/smpleader/spt-boilerplate
 * @author: Pham Minh - smpleader
 * @description: Base abstract implement Container
 * 
 */

namespace SPT\JDIContainer; 

use Joomla\DI\Container;
use Joomla\DI\ContainerAwareTrait;
use Joomla\DI\ContainerAwareInterface;

abstract class Base implements ContainerAwareInterface
{ 
    use ContainerAwareTrait;

    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }

    /**
     * Load automatically dependencies
     */
    public function __get($name)
    { 
        if( 'container' == $name ) return $this->container;
        
        if( $this->container->has($name) )
        {
            return $this->container->get($name);
        }

        throw new \RuntimeException('Invalid JDIContainer '.$name, 500);
    }

    protected $_vars = []; 

    public function get($key = null, $default = null)
    {
        if( null === $key ) return $this->_vars;
        return isset( $this->_vars[$key] ) ? $this->_vars[$key] : $default; 
    }

    public function set($key, $value)
    {
        $this->_vars[$key] = $value;
    }

    public function getAll()
    {
        return $this->_vars;
    }
}