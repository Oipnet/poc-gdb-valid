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

    public function validate(TempData $tempData, array $groups = ['Default']): BaseData
    {
        $tempData->cleanErrors();

        /** @var  $errors */
        $errors = $this->validator->validate($tempData, null, $groups);

        $base = $tempData->getBase();

        if (!$errors->count()) {
            $base->hydrate($tempData)
                ->setTmp(null);

            $this->em->remove($tempData);

            return $base;
        }

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $field = $error->getPropertyPath();

            $tempData->addError($field, $error->getMessage());
        }

        return $base->reset();
    }
}