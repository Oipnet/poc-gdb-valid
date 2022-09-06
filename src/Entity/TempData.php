<?php

namespace App\Entity;

interface TempData
{
    public function getBase(): ?BaseData;
    public function setBase(?BaseData $base): self;
    public function hydrate(BaseData $data): self;
}