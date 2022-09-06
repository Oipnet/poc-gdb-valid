<?php

namespace App\Dto;

class Field
{
    public function __construct(
        private readonly string  $getter,
        private readonly string  $setter,
        private                  $default,
        private readonly ?string $isErreurSetter = null,
        private readonly ?string $messageErreur = null,
    )
    {
    }

    /**
     * @return string|null
     */
    public function getIsErreurSetter(): ?string
    {
        return $this->isErreurSetter;
    }

    /**
     * @return string|null
     */
    public function getMessageErreurSetter(): ?string
    {
        return $this->messageErreur;
    }

    /**
     * @return string
     */
    public function getGetter(): string
    {
        return $this->getter;
    }

    /**
     * @return string
     */
    public function getSetter(): string
    {
        return $this->setter;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }
}