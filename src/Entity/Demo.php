<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DemoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemoRepository::class)]
#[ApiResource]
class Demo implements BaseData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private string $foo = '';

    #[ORM\OneToOne(inversedBy: 'demo', cascade: ['persist', 'remove'])]
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

    public function reset(): self
    {
        $this->setFoo('');

        return $this;
    }

    public function hydrate(TempData $data): self
    {
        $this->setFoo($data->getFoo());

        return $this;
    }

    public function getTmp(): ?TempData
    {
        return $this->getDemoTmp();
    }

    public function setTemp(?TempData $temp): self
    {
        return $this->setDemoTmp($temp);
    }
}
