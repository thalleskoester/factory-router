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
     * Router Object
     *
     * @var Router
     */
    private $_router;
    
    /**
     * Controller name
     *
     * @var string
     */
    private $_controller;
    
    
    /**
     * Routes constructor.
     *
     * @param Router $router    Router object
     * @param string $className Child class name
     */
    public function __construct(Router $router, string $className)
    {
        $this->_router = $router;
        
        $buf = explode('\\', $className);
        $this->_controller = end($buf);
    }
    
    /**
     * Update router object
     *
     * @return Router
     */
    public function updateRouter(): Router
    {
        return $this->_router;
    }
    
    /**
     * Modify the defined namespace
     *
     * @param string|null $ns New namespace
     *
     * @return Routes
     */
    public function namespace(?string $ns): Routes
    {
        $this->_router->namespace($ns);
        return $this;
    }
    
    /**
     * Define a routes group
     *
     * @param string|null $group Name of the group
     *
     * @return Router
     */
    public function group(?string $group): Router
    {
        $this->_router->group($group);
        return $this->_router;
    }
    
    /**
     * Define a method get route
     *
     * @param string $route Route
     * @param string $name  Nickname to the route
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
     * Define a method post route
     *
     * @param string $route Route
     * @param string $name  Nickname to the route
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
     * Define a method put route
     *
     * @param string $route Route
     * @param string $name  Nickname to the route
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
     * Define a method delete route
     *
     * @param string $route Route
     * @param string $name  Nickname to the route
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
     * Get handler for the route
     *
     * @param string $name Nickname of the route
     *
     * @return string
     */
    private function _getHandler(string $name): string
    {
        $controller = ucfirst($this->_controller);
        return "{$controller}:{$name}";
    }
    
    /**
     * Get name for the route
     *
     * @param string $name Nickname of the route
     *
     * @return string
     */
    private function _getName(string $name): string
    {
        $controller = strtolower($this->_controller);
        return "{$controller}.{$name}";
    }
}