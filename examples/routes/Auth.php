<?php

namespace Routes;

use CoffeeCode\Router\Router;
use ThallesDella\FactoryRouter\Routes;

/**
 * Factory Router | Class Auth [ EXAMPLE ]
 *
 * @category FactoryRouter\Examples\Routes
 * @package  Routes
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class Auth extends Routes
{
    /**
     * Auth constructor.
     *
     * @param Router $router Router object
     */
    public function __construct(Router $router)
    {
        parent::__construct($router, 'Auth');
    }
    
    /**
     * @return Router
     */
    public function updateRouter(): Router
    {
        $this->group('auth');
    
        $this->get('/login', 'login');
        
        return $this->router;
    }
}