<?php

namespace App\DTO;

class PatientDTO
{
    private $searchTerm;

    public function __construct()
    {
        $this->searchTerm = "";
    }

    public function setSearchTerm(string $searchTerm): self
    {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    public function getSearchTerm(): string
    {
        return $this->searchTerm;
    }
}
