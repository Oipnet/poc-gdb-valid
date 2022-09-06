<?php

namespace App\Entity;

use App\Dto\Field;

abstract class AbstractTmpEntity implements TempData
{
    /**
     * @return array<Field>
     */
    abstract public function getFields(): array;

    public function hydrate(BaseData $data): self
    {
        foreach ($this->getFields() as $field) {
            $this->{$field->getSetter()}($data->{$field->getGetter()}());
            $this->{$field->getIsErreurSetter()}(false);
            $this->{$field->getMessageErreurSetter()}(null);
        }

        $this->setBase($data);

        return $this;
    }

    public function addError(string $fieldName, string $message): self
    {
        $field = $this->getFields()[$fieldName];

        $this->{$field->getIsErreurSetter()}(true);
        $this->{$field->getMessageErreurSetter()}($message);

        return $this;
    }

    public function cleanErrors(): self
    {
        foreach ($this->getFields() as $field) {
            $this->{$field->getIsErreurSetter()}(false);
            $this->{$field->getMessageErreurSetter()}(null);
        }

        return $this;
    }
}