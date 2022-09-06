<?php

namespace App\Entity;

use App\Dto\Field;

abstract class AbstractTmpEntity implements TempData
{
    abstract public function getFields(): array;

    public function hydrate(BaseData $data): self
    {
        /** @var Field $field */
        foreach ($this->getFields() as $field) {
            $this->{$field->getSetter()}($data->{$field->getGetter()}());
            $this->{$field->getIsErreurSetter()}(false);
            $this->{$field->getMessageErreurSetter()}(null);
        }

        $this->setBase($data);

        return $this;
    }
}