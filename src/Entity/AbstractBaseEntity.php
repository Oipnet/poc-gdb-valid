<?php

namespace App\Entity;

abstract class AbstractBaseEntity implements BaseData
{
    abstract public function getFields(): array;

    public function hydrate(TempData $data): self
    {
        foreach ($this->getFields() as $field) {
            $this->{$field->getSetter()}($data->{$field->getGetter()}());
        }

        return $this;
    }

    public function reset(): self
    {
        foreach ($this->getFields() as $field) {
            $this->{$field->getSetter()}($field->getDefault());
        }

        return $this;
    }
}