<?php

namespace BorisNedovis\EloquentPresenter\Helpers;

use Illuminate\Contracts\Support\Arrayable;

class ObjectArray implements Arrayable
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get(string $name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
    	return $this->data;
    }
}
