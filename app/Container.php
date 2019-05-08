<?php
namespace Framework;

class Container
{
    private $instances= [];

    public function set(string $key, Callable $resolver){
        $this->instances[$key] = $resolver;
    }

    public function get(string $key){
        if(!isset($this->instances[$key])){
            $this->instances[$key] = $this->resolve($key);
        }
        
        return $this->instances[$key];
    }

    private function resolve(string $key){
        $reflected_class = new \ReflectionClass($key);
        if($reflected_class->isInstantiable()){
            $constructor = $reflected_class->getConstructor();
            if($constructor){
                $parameters = $constructor->getParameters();
                $constructor_parameters = [];
                foreach($parameters as $parameter){
                    if( $parameter->getClass() ){
                        $constructor_parameters[] = $this->get($parameter->getClass()->getName());
                    } else {
                        $constructor_parameters[] = $parameter->getDefaultValue();
                    }
                }
                return $reflected_class->newInstanceArgs($constructor_parameters);
            } else {
                return $reflected_class->newInstance();
            }
        } else {
            throw new \Exception($key . " is not an instanciable");
        }
    }
}
