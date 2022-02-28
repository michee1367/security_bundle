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
    }

    /**
     * 
     */
    public function getErrors()
    {
        return $this->errors;
    }


}