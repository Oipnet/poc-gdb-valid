<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\Field;
use App\Repository\DemoTmpRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemoTmpRepository::class)]
#[ApiResource(itemOperations: [Request::METHOD_GET])]
class DemoTmp extends AbstractTmpEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 30
    )]
    private ?string $foo = null;

    #[ORM\Column]
    private ?bool $fooEnErreur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fooErreurMessage = null;

    #[ORM\OneToOne(mappedBy: 'demoTmp', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Demo $demo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoo(): ?string
    {
        return $this->foo;
    }

    public function setFoo(string $foo): self
    {
        $this->foo = $foo;

        return $this;
    }

    public function isFooEnErreur(): ?bool
    {
        return $this->fooEnErreur;
    }

    public function setFooEnErreur(bool $fooEnErreur): self
    {
        $this->fooEnErreur = $fooEnErreur;

        return $this;
    }

    public function getFooErreurMessage(): ?string
    {
        return $this->fooErreurMessage;
    }

    public function setFooErreurMessage(?string $fooErreurMessage): self
    {
        $this->fooErreurMessage = $fooErreurMessage;

        return $this;
    }

    public function getDemo(): ?Demo
    {
        return $this->demo;
    }

    public function setDemo(?Demo $demo): self
    {
        // unset the owning side of the relation if necessary
        if ($demo === null && $this->demo !== null) {
            $this->demo->setDemoTmp(null);
        }

        // set the owning side of the relation if necessary
        if ($demo !== null && $demo->getDemoTmp() !== $this) {
            $demo->setDemoTmp($this);
        }

        $this->demo = $demo;

        return $this;
    }

    public function getBase(): ?BaseData
    {
        return $this->getDemo();
    }

    public function setBase(?BaseData $base): TempData
    {
        return $this->setDemo($base);
    }

    public function getFields(): array
    {
        return [
            'foo' => new Field('getFoo', 'setFoo', '', 'setFooEnErreur', 'setFooErreurMessage'),
        ];
    }
}
