<?php

namespace App\Services;

use App\Entity\Demo;
use App\Entity\DemoTmp;
use App\Entity\Hydratable;
use App\Entity\Tempable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;


final class DemoValidationService implements ValidationServiceInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private EntityManagerInterface $em
    )
    {
    }

    public function createTmpFromEntity(Tempable $entity): Hydratable
    {
        assert( $entity instanceof Demo);

        if ($demoTmp = $entity->getDemoTmp()) {
            $demoTmp->hydrate($entity);

            return $demoTmp;
        }

        return (new DemoTmp())->hydrate($entity);
    }

    /**
     * @param DemoTmp $demoTmp
     * @return Demo
     */
    public function validate(Hydratable $demoTmp)
    {
        /** @var  $errors */
        $errors = $this->validator->validate($demoTmp, null, ['Default']);

        if (!$errors->count()) {
            $demo = $demoTmp->getDemo();
            $demo->hydrate($demoTmp);

            $demo->setDemoTmp(null);

            $this->em->remove($demoTmp);

            return $demo;
        }

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $field = $error->getPropertyPath();

            $demoTmp->{'set'.ucfirst($field).'EnErreur'}(true);
            $demoTmp->{'set'.ucfirst($field).'ErreurMessage'}($error->getMessage());
        }

        $demoTmp->getDemo()->reset();

        return $demoTmp->getDemo();
    }
}