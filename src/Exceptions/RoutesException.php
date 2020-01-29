<?php

namespace ThallesDella\FactoryRouter\Exceptions;

use Exception;
use Throwable;

/**
 * Factory Router | Class RoutesException [ TEMPLATE ]
 *
 * @category FactoryRouter\Template
 * @package  ThallesDella\FactoryRouter\Exceptions
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
abstract class RoutesException extends Exception
{
    /**
     * Files name
     *
     * @var string|null
     */
    public $file;
    
    /**
     * RoutesException constructor.
     *
     * @param string         $message  Exception message
     * @param int            $code     Exception code
     * @param Throwable|null $previous Previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->file = null;
        parent::__construct($message, $code, $previous);
    }
}