<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Demo;
use App\Services\ValidationServiceFactory;
use Doctrine\ORM\EntityManagerInterface;

final class DemoDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private ValidationServiceFactory $validationServiceFactory,
        private DataPersisterInterface $decorated,
        private EntityManagerInterface $em
    )
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Demo;
    }

    /**
     * @param Demo $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        $validationService = $this->validationServiceFactory->create(Demo::class);
        $demoTmp = $validationService->createTmpFromEntity($data);
        $data = $validationService->validate($demoTmp);

        $this->em->persist($data);

        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}