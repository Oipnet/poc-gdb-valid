<?php

namespace App\Services;

use App\Entity\Demo;
use App\Exceptions\ValidationServiceNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationServiceFactory
{
    private array $services = [
        Demo::class => DemoValidationService::class
    ];

    public function __construct(
        private ValidatorInterface $validator,
        private EntityManagerInterface $em
    )
    {
    }

    public function create(string $className): ValidationServiceInterface
    {
        if (! isset($this->services[$className])) {
            throw new ValidationServiceNotFound('Aucun service de validation trouvé pour la classe '.$className);
        }

        $class = $this->services[$className];

        return new $class(
            $this->validator,
            $this->em
        );
    }
}