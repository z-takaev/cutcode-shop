<?php

namespace App\Support\Flash;

class FlashMessage
{
    public function __construct(protected string $message, protected string $classes)
    {
    }

    public function message(): string
    {
        return $this->message;
    }

    public function classes(): string
    {
        return $this->classes;
    }
}
