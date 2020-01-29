<?php

namespace ThallesDella\FactoryRouter\Exceptions;

use Throwable;

/**
 * Factory Router | Class FileNotFoundException [ EXCEPTION ]
 *
 * @category FactoryRouter\Exceptions
 * @package  ThallesDella\FactoryRouter\Exceptions
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class FileNotFoundException extends RoutesException
{
    /**
     * FileNotFoundException constructor.
     *
     * @param string         $message  Exception message
     * @param int            $code     Exception code
     * @param Throwable|null $previous Previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}