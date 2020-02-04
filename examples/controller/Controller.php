<?php

namespace Controllers;

use CoffeeCode\Router\Router;

/**
 * Factory Router | Class Controller [ EXAMPLE ]
 *
 * @category Examples\Controllers
 * @package  FactoryRouter\Examples\Controllers
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
abstract class Controller
{
    /**
     * @var Router
     */
    protected $router;
    
    /**
     * Controller constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        session_start();
        $this->router = $router;
    }
}