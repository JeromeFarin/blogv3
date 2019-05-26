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
            $this->verify($key,$property);            
        }
        
        return $this->message;
    }

    /**
     * Check constraint
     *
     * @param string $key
     * @param array $property
     * @return void
     */
    private function verify(string $key, array $property)
    {
        $value = $this->object->{sprintf("get%s", ucfirst($key))}();

        foreach ($property as $constraint) {
            if ($constraint->valid($value) === false) {
                $this->setMessage($key,$constraint);
            }
        }
    }
    
    /**
     * Set error message
     *
     * @param string $key
     * @param mixed $constraint
     * @return void
     */
    private function setMessage(string $key, $constraint)
    {
        if (!isset($this->message[$key])) {
            $this->message[$key] = $constraint->getMessage();
        }
    }
}
