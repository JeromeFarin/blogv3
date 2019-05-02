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
                    $this->message[$key] = $property->getMessage();
                }
            }
        }
        dd($this->message);
        return $this->message;
    }
}
