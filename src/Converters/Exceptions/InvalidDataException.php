<?php

namespace Mink67\Security\Converters\Exceptions;

use Exception;

class InvalidDataException extends Exception {
    /**
     * @var array
     */
    private $errors;

    /**
     * 
     */
    public function __construct(array $errors) {

        parent::__construct("token data invalid");
        $this->errors = $errors;

        parent::__construct($this->transform($errors));
    }

    /**
     * 
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * 
     */
    private function transform(array $errors)
    {
        $message = '';
        foreach ($errors as $key => $value) {
            $valTrans = $this->transformKeyValues($value);
            $message = $message . "$key => [$valTrans]; \n";
        }
        return $message;
    }
    /**
     * 
     */
    private function transformKeyValues(array $keyValue)
    {
        $message = '';

        foreach ($keyValue as $key => $value) {
            $message = $message . "$key : $value";
        }

        return $message;
        
    }


}