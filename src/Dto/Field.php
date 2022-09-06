<?php

namespace App\Dto;

class Field
{
    public function __construct(
        private readonly string $getter,
        private readonly string $setter,
        private                 $default
    )
    {
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