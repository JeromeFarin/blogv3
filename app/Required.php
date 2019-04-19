<?php
namespace Framework;

class Required 
{
    private $message;

    public function required($request,$filter)
    {
        $required = $request::getInfo()['required'][$filter];

        foreach ($required as $key => $value) {
            $size = $this->length($request->{sprintf("get%s", ucfirst($filter))}());

            if ($key === "min-length" && $value > $size) {
                return "Le champ doit contenir au moins $value caractères";
            }
            if ($key === "max-length" && $value < $size) {
                return "Le champ ne doit pas contenir plus de $value caractères";
            }
        }
    }

    private function length($request)
    {
        return strlen($request);
    }
}
