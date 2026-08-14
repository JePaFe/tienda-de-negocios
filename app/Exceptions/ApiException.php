<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct(
        string $message,
        protected int $status = 400,
        protected array $errors = [],
    ) {
        parent::__construct($message);
    }

    public function render()
    {
        return response()->json([
            'message' => $this->getMessage(),
            'status' => $this->status,
            'errors' => (object) $this->errors,
        ], $this->status);
    }
}
