<?php
namespace Application\Form;

class Form
{
    protected function getSetter(array $data)
    {
        foreach ($data as $property => $value) {
            $this->model->{sprintf("set%s", ucfirst($property))}($value);
        }
    }
}
