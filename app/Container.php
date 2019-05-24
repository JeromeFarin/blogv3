<?php
namespace Framework;

/**
 * Container class
 * @package Framework
 */
class Container
{
    /**
     * Instances
     *
     * @var array
     */
    private $instances= [];

    /**
     * Set instance
     *
     * @param string $key
     * @return void
     */
    public function set(string $key){
        $this->instances[$key] = $this->resolve($key);
    }

    /**
     * Get instance
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key){
        if(!isset($this->instances[$key])){
            $this->instances[$key] = $this->resolve($key);
        }
        
        return $this->instances[$key];
    }

    /**
     * Create class and set in instances
     *
     * @param string $key
     * @return void
     */
    private function resolve(string $key){
        $reflected_class = new \ReflectionClass($key);
        if($reflected_class->isInstantiable()){
            $constructor = $reflected_class->getConstructor();
            if($constructor){
                return $reflected_class->newInstanceArgs($this->hasConstructor($constructor));
            } else {
                return $reflected_class->newInstance();
            }
        } else {
            throw new \Exception($key . " is not an instanciable");
        }
    }

    private function hasConstructor(\ReflectionMethod $constructor)
    {
        $parameters = $constructor->getParameters();
        $constructor_parameters = [];
        foreach($parameters as $parameter){
            if( $parameter->getClass() ){
                $constructor_parameters[] = $this->get($parameter->getClass()->getName());
            } else {
                $constructor_parameters[] = $parameter->getDefaultValue();
            }
        }
        return $constructor_parameters;
    }
}
