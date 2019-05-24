<?php
namespace Framework;

/**
 * Class Validator
 * @package Framework
 */
class Validator
{
    /**
     * Object send to validation
     *
     * @var mixed
     */
    protected $object;

    /**
     * Errors Message
     *
     * @var array
     */
    protected $message = [];

    /**
     * Constructor
     *
     * @param mixed $object
     */
    public function __construct($object) {
        $this->object = $object;
    }

    /**
     * Call constraint  
     *
     * @return array
     */
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
