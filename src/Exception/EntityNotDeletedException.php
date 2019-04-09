<?php

namespace App\Exception;

class EntityNotDeletedException extends \Exception
{
    public function __construct(string $msg)
    {
        parent::__construct("The entity could not be deleted. ".$msg);
    }
}
