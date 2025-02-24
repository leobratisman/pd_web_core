<?php

namespace App\Exceptions;

use Exception;

class S3ConnectionException extends Exception
{
    public function __construct(string $message = "failed to upload file to S3", int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
