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
    private $router;
    
    /**
     * Controller name
     *
     * @var string
     */
    private $controller;
    
    
    /**
     * Routes constructor.
     *
     * @param Router $router         Router object
     * @param string $controllerName Controller name
     */
    public function __construct(Router $router, string $controllerName)
    {
        $this->router = $router;
        $this->controller = $controllerName;
    }
    
    /**
     * Update router object
     *
     * @return Router
     */
    abstract public function updateRouter(): Router;
    
    
    /**
     * Modify the defined namespace
     *
     * @param string|null $ns New namespace
     *
     * @return Routes
     */
    public function namespace(?string $ns): Routes
    {
        $this->router->namespace($ns);
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
        $this->router->group($group);
        return $this->router;
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
        $this->router->get(
            $route,
            $this->getHandler($name),
            $this->getName($name)
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
        $this->router->post(
            $route,
            $this->getHandler($name),
            $this->getName($name)
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
        $this->router->put(
            $route,
            $this->getHandler($name),
            $this->getName($name)
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
        $this->router->delete(
            $route,
            $this->getHandler($name),
            $this->getName($name)
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
    private function getHandler(string $name): string
    {
        $controller = ucfirst($this->controller);
        return "{$controller}:{$name}";
    }
    
    /**
     * Get name for the route
     *
     * @param string $name Nickname of the route
     *
     * @return string
     */
    private function getName(string $name): string
    {
        $controller = strtolower($this->controller);
        return "{$controller}.{$name}";
    }
}