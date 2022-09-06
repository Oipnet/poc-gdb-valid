<?php

namespace App\Services;

use App\Entity\BaseData;
use App\Entity\TempData;

interface ValidationServiceInterface
{
    public function createTmpFromEntity(BaseData $entity): TempData;

    public function validate(TempData $demoTmp);
}