<?php

namespace Framework\Router;

class Route
{
    private $name;
    private $path;
    private $parameters = [];
    private $controller;
    private $action;
    private $defaults = [];

    public function __construct(string $name, string $path, array $parameters, string $controller, string $action, array $defaults = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->parameters = $parameters;
        $this->controller = $controller;
        $this->action = $action;
        $this->defaults = $defaults;
    }

    public function match($request)
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

    public function call($request,$container)
    {
        $args[] = $request;
        foreach ($this->args as $value) {
            $args[] = $value;
        }

        $controller = $this->controller;
 
        $controller = $container->get($controller);
        
        return call_user_func_array([$controller, $this->action],$args);
    }

    private function parameterMatch($match)
    {
        if(isset($this->parameters[$match[1]])) {
            return sprintf("(%s)",$this->parameters[$match[1]]);
        }
        
        return '([^/]+)';
    }

    public function getName()
    {
        return $this->name;
    }
}
