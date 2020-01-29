<?php

namespace ThallesDella\FactoryRouter;

use CoffeeCode\Router\Router;

/**
 * Factory Router | Class Routes [ TEMPLATE ]
 *
 * @category FactoryRouter\Template
 * @package  ThallesDella\FactoryRouter
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
abstract class Routes
{
    /**
     * @var Router
     */
    private $_router;
    
    /**
     * @var string
     */
    private $_controller;
    
    
    /**
     * Routes constructor.
     *
     * @param Router $router
     * @param string $className
     */
    public function __construct(Router $router, string $className)
    {
        $this->_router = $router;
        
        $buf = explode('\\', $className);
        $this->_controller = end($buf);
    }
    
    /**
     * @return Router
     */
    public function updateRouter(): Router
    {
        return $this->_router;
    }
    
    /**
     * @param string|null $ns
     *
     * @return Routes
     */
    public function namespace(?string $ns): Routes
    {
        $this->_router->namespace($ns);
        return $this;
    }
    
    /**
     * @param string|null $group
     *
     * @return Router
     */
    public function group(?string $group): Router
    {
        $this->_router->group($group);
        return $this->_router;
    }
    
    /**
     * @param string $route
     * @param string $name
     *
     * @return void
     */
    public function get(string $route, string $name): void
    {
        $this->_router->get(
            $route,
            $this->_getHandler($name),
            $this->_getName($name)
        );
        return;
    }
    
    /**
     * @param string $route
     * @param string $name
     *
     * @return void
     */
    public function post(string $route, string $name): void
    {
        $this->_router->post(
            $route,
            $this->_getHandler($name),
            $this->_getName($name)
        );
        return;
    }
    
    /**
     * @param string $route
     * @param string $name
     *
     * @return void
     */
    public function put(string $route, string $name): void
    {
        $this->_router->put(
            $route,
            $this->_getHandler($name),
            $this->_getName($name)
        );
        return;
    }
    
    /**
     * @param string $route
     * @param string $name
     *
     * @return void
     */
    public function delete(string $route, string $name): void
    {
        $this->_router->delete(
            $route,
            $this->_getHandler($name),
            $this->_getName($name)
        );
        return;
    }
    
    /**
     * @param string $name
     *
     * @return string
     */
    private function _getHandler(string $name): string
    {
        $controller = ucfirst($this->_controller);
        return "{$controller}:{$name}";
    }
    
    /**
     * @param string $name
     *
     * @return string
     */
    private function _getName(string $name): string
    {
        $controller = strtolower($this->_controller);
        return "{$controller}.{$name}";
    }
}