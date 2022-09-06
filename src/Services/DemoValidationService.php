<?php

namespace App\Services;

use App\Entity\Demo;
use App\Entity\DemoTmp;
use App\Entity\BaseData;
use App\Entity\TempData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


final class DemoValidationService extends ValidationService implements ValidationServiceInterface
{
    public function __construct(
        private readonly ValidatorInterface     $validator,
        private readonly EntityManagerInterface $em
    )
    {
        parent::__construct($this->validator, $this->em);
    }

    public function createTmpFromEntity(BaseData $entity): TempData
    {
        assert( $entity instanceof Demo);

        if ($demoTmp = $entity->getTmp()) {
            $demoTmp->hydrate($entity);

            return $demoTmp;
        }

        return (new DemoTmp())->hydrate($entity);
    }
}