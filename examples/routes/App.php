<?php

namespace Routes;

use CoffeeCode\Router\Router;
use ThallesDella\FactoryRouter\Routes;

/**
 * Factory Router | Class Website [ EXAMPLE ]
 *
 * @category FactoryRouter\Examples\Routes
 * @package  Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class App extends Routes
{
    /**
     * App constructor.
     *
     * @param Router $router Router object
     */
    public function __construct(Router $router)
    {
        $pieces = explode('\\', __CLASS__);
        $controller = end($pieces);
        parent::__construct($router, $controller);
    }
    
    /**
     * @return Router
     */
    public function updateRouter(): Router
    {
        return $this->router;
    }
}