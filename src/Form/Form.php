<?php
namespace Application\Form;

use Framework\Validator;
use Framework\ModelInterface;

/**
 * Form Class
 */
class Form
{
    /**
     * Get all setter
     *
     * @param array $data
     * @return void
     */
    protected function getSetter(array $data)
    {
        foreach ($data as $property => $value) {
            $this->model->{sprintf("set%s", ucfirst($property))}($value);
        }
    }

    /**
     * @return boolean
     */
    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    /**
     * @return boolean
     */
    public function isValid(): bool
    {
        $valid = new Validator($this->model);

        if (!empty($valid->valid())) {
            $this->errors = $valid->valid();
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return ModelInterface
     */
    public function getData(): ModelInterface
    {
        return $this->model;
    }
}
