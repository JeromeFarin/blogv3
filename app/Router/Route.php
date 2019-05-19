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
     * Constructor
     *
     * @param string $name
     * @param string $path
     * @param array $parameters
     * @param string $controller
     * @param string $action
     * @param array $defaults
     */
    public function __construct(string $name, string $path, array $parameters, string $controller, string $action, array $defaults = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->parameters = $parameters;
        $this->controller = $controller;
        $this->action = $action;
        $this->defaults = $defaults;
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
}
