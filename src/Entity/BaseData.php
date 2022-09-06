<?php

namespace App\Entity;

interface BaseData
{
    public function reset(): self;
    public function getTmp(): ?TempData;
    public function setTmp(?TempData $temp): self;
    public function hydrate(TempData $data): self;
}