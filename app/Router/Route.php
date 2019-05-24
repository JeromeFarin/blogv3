<?php

namespace Framework\Router;

/**
 * Route class
 * @package Framework\Router
 */
class Route
{
    /**
     * Name
     *
     * @var string
     */
    private $name;

    /**
     * Path
     *
     * @var string
     */
    private $path;

    /**
     * Parameters
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Controller
     *
     * @var string
     */
    private $controller;

    /**
     * Action
     *
     * @var string
     */
    private $action;

    /**
     * Default value
     *
     * @var array
     */
    private $defaults = [];

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Find a match
     *
     * @param string $request
     * @return boolean
     */
    public function match(string $request): bool
    {
        $path = preg_replace_callback("/:(\w+)/", [$this, "parameterMatch"], $this->path);
 
        $path = str_replace("/","\/", $path);

        if(!preg_match("/^$path$/i", $request, $matches)){
            return false;
        }

        $this->args = array_slice($matches,1);
        $defaultsArgs = array_keys($this->defaults);
        foreach($this->args as $key => &$value) {
            $index = array_search($key,$defaultsArgs);
            if($index !== FALSE && $value === ""){
                $value = $this->defaults[$defaultsArgs[$index]];
            }
        }

        return true;
    }

    /**
     * Return controller
     *
     * @param mixed $request
     * @param mixed $container
     * @return mixed
     */
    public function call($request, $container)
    {
        $args[] = $request;
        foreach ($this->args as $value) {
            $args[] = $value;
        }

        $controller = $this->controller;
 
        $controller = $container->get($controller);
        
        return call_user_func_array([$controller, $this->action],$args);
    }

    /**
     * Get parameters
     *
     * @param mixed $match
     * @return void
     */
    private function parameterMatch($match)
    {
        if(isset($this->parameters[$match[1]])) {
            return sprintf("(%s)",$this->parameters[$match[1]]);
        }
        
        return '([^/]+)';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param  string  $path  Path
     *
     * @return  self
     */ 
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set parameters
     *
     * @param  array  $parameters  Parameters
     *
     * @return  self
     */ 
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Set controller
     *
     * @param  string  $controller  Controller
     *
     * @return  self
     */ 
    public function setController(string $controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Set action
     *
     * @param  string  $action  Action
     *
     * @return  self
     */ 
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Set default value
     *
     * @param  array  $defaults  Default value
     *
     * @return  self
     */ 
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;

        return $this;
    }
}
