<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DemoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemoRepository::class)]
#[ApiResource]
class Demo implements Tempable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private string $foo = '';

    #[ORM\OneToOne(inversedBy: 'demo', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?DemoTmp $demoTmp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoo(): string
    {
        return $this->foo;
    }

    public function setFoo(string $foo): self
    {
        $this->foo = $foo;

        return $this;
    }

    public function getDemoTmp(): ?DemoTmp
    {
        return $this->demoTmp;
    }

    public function setDemoTmp(?DemoTmp $demoTmp): self
    {
        $this->demoTmp = $demoTmp;

        return $this;
    }

    public function reset()
    {
        $this->setFoo('');
    }

    public function hydrate(DemoTmp $demoTmp)
    {
        $this->setFoo($demoTmp->getFoo());
    }
}
