<?php

namespace ThallesDella\FactoryRouter;

use ArrayObject;
use CoffeeCode\Router\Router;
use ThallesDella\FactoryRouter\Exceptions\ClassNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\DirectoryNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\FileNotFoundException;
use ThallesDella\FactoryRouter\Exceptions\UpdateRouterMissingMethodException;

/**
 * Factory Router | Class FactoryRouter
 *
 * @category FactoryRouter
 * @package  ThallesDella\FactoryRouter
 * @author   Thalles D. koester <thallesdella@gmail.com>
 * @license  https://choosealicense.com/licenses/mit/ MIT
 * @link     https://github.com/thallesdella/factory-router
 */
class FactoryRouter
{
    /**
     * Router object
     *
     * @var Router
     */
    private $_router;
    
    /**
     * Target ArrayObject
     *
     * @var ArrayObject
     */
    private $_target;
    
    /**
     * FactoryRouter constructor.
     *
     * @param string $projectUrl Base url of project
     * @param string $namespace  Default namespace of the controllers
     */
    public function __construct(string $projectUrl, string $namespace)
    {
        $this->_router = new Router($projectUrl);
        $this->_router->namespace($namespace);
        
        $this->_target = new ArrayObject();
    }
    
    /**
     * Scan directory for targets
     *
     * @param string $dir Relative path of directory
     *
     * @return FactoryRouter
     *
     * @throws ClassNotFoundException
     * @throws DirectoryNotFoundException
     * @throws FileNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    public function addDir(string $dir): FactoryRouter
    {
        $path = dirname(__DIR__, 2) . "/{$dir}";
        if (!file_exists($dir) || !is_dir($dir)) {
            $error = new DirectoryNotFoundException('Directory not found');
            $error->file = $dir;
            throw $error;
        }
        
        $dirFiles = scandir($path);
        
        foreach ($dirFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $this->addFile("{$dir}/{$file}");
        }
        return $this;
    }
    
    /**
     * Add file as target
     *
     * @param string $file Relative path of file
     *
     * @return FactoryRouter
     *
     * @throws ClassNotFoundException
     * @throws FileNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    public function addFile(string $file): FactoryRouter
    {
        $arr = [
            "filename" => $this->_getFileName($file),
            "handler" => $this->_pathToNamespace($file),
            "path" => dirname(__DIR__, 2) . "/{$file}"
        ];
        $fileInfo = new ArrayObject($arr, ArrayObject::ARRAY_AS_PROPS);
        
        if (!file_exists($fileInfo->path) || !is_file($fileInfo->path)) {
            $error = new FileNotFoundException('File not found');
            $error->file = $fileInfo->filename;
            throw $error;
        }
        include_once $fileInfo->path;
        
        $this->_checkClass($fileInfo);
        $this->_target->append([$fileInfo]);
        return $this;
    }
    
    /**
     * Build router
     *
     * @return Router
     */
    public function build(): Router
    {
        foreach ($this->_target->getIterator() as $file) {
            /**
             * Instance of the router manager
             *
             * @var Routes $routes
             */
            $routes = new $file->handler($this->_router);
            $routes->updateRouter();
        }
        return $this->_router;
    }
    
    /**
     * Check if is a valid class
     *
     * @param ArrayObject $fileInfo ArrayObject containing file's information
     *
     * @return void
     *
     * @throws ClassNotFoundException
     * @throws UpdateRouterMissingMethodException
     */
    private function _checkClass(ArrayObject $fileInfo): void
    {
        if (!class_exists($fileInfo->handler)) {
            $error = new ClassNotFoundException("Class not found");
            $error->file = $fileInfo->filename;
            throw $error;
        }
        
        if (!method_exists($fileInfo->handler, 'updateRouter')) {
            $error = new UpdateRouterMissingMethodException("Method updateRouter not found");
            $error->file = $fileInfo->filename;
            throw $error;
        }
        
        return;
    }
    
    /**
     * Converts a path to a file into the file's namespace
     *
     * @param string $path Path to be transform
     *
     * @return string
     */
    private function _pathToNamespace(string $path): string
    {
        $buf = str_replace('/', '\\', ucwords($path, '/'));
        return explode('.', $buf)[0];
    }
    
    /**
     * Get the file name, without extension
     *
     * @param string $path Path of file
     *
     * @return string
     */
    private function _getFileName(string $path): string
    {
        $arr = explode('/', $path);
        $file = end($arr);
        return explode('.', $file)[0];
    }
    
}
