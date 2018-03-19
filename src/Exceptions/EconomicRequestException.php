<?php

namespace LasseRafn\Economic\Exceptions;

class EconomicRequestException extends \Exception
{
    public function getExceptionFromJson()
    {
        $body = json_decode($this->getMessage());

        if (isset($body->message)) {
            return $body->message;
        }

        return $this->getMessage();
    }

    public function getErrorsFromJson()
    {
        $body = json_decode($this->getMessage());

        if (isset($body->errors)) {
            return $body->errors;
        }

        return $this->getMessage();
    }
}
