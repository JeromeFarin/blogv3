<?php
namespace Framework;

class Validator
{
    protected $object;
    protected $message = [];

    public function __construct($object) {
        $this->object = $object;
    }

    public function valid()
    {
        foreach ($this->object::getInfo()["constraints"] as $key => $property) {
            $value = $this->object->{sprintf("get%s", ucfirst($key))}();        
            foreach ($property as $property) {
                if ($property->valid($value) === false) {
                    if (!isset($this->message[$key])) {
                        $this->message[$key] = $property->getMessage();
                    }
                }
            }
        }
        return $this->message;
    }
}
