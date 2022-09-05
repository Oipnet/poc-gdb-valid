<?php

namespace App\Services;

use App\Entity\Hydratable;
use App\Entity\Tempable;

interface ValidationServiceInterface
{
    public function createTmpFromEntity(Tempable $entity): Hydratable;

    public function validate(Hydratable $demoTmp);
}