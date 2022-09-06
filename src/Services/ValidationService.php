<?php

namespace App\Services;

use App\Entity\BaseData;
use App\Entity\TempData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class ValidationService
{
    public function __construct(
        private readonly ValidatorInterface     $validator,
        private readonly EntityManagerInterface $em
    )
    {
    }

    abstract public function createTmpFromEntity(BaseData $entity): TempData;

    public function validate(TempData $demoTmp, array $groups = ['Default']): BaseData
    {
        /** @var  $errors */
        $errors = $this->validator->validate($demoTmp, null, $groups);

        $demo = $demoTmp->getBase();

        if (!$errors->count()) {
            $demo->hydrate($demoTmp)
                ->setTmp(null);

            $this->em->remove($demoTmp);

            return $demo;
        }

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $field = $error->getPropertyPath();

            $demoTmp->{'set'.ucfirst($field).'EnErreur'}(true);
            $demoTmp->{'set'.ucfirst($field).'ErreurMessage'}($error->getMessage());
        }

        return $demo->reset();
    }
}