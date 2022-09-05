<?php

namespace App\Entity;

interface Hydratable
{
    public function hydrate($data): self;
}