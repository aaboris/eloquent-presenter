<?php

namespace BorisNedovis\EloquentPresenter;

use Illuminate\Database\Eloquent\Model;

trait Presenter
{
    public static bool $usePresenter = true;

    public function setPresenter(string $presenter): self
    {
        $this->presenter = $presenter;

        return $this;
    }

    public function getPresenterClass(): string
    {
        return $this->presenter;
    }

    public function isSamePresenterClass(string $presenter): bool
    {
        return $this->presenter == $presenter;
    }

    public static function disablePresenter(): self
    {
        self::$usePresenter = false;

        return (new static);
    }


    public function toArray(): array
    {
        $presenter = $this->getPresenterClass();

        if ($presenter && self::$usePresenter) {
            $presenter = new $presenter($this);

            return $presenter->toArray();
        }

        return parent::toArray();
    }


    public function newInstance($attributes = [], $exists = false): Model
    {
        $model = parent::newInstance($attributes, $exists);

        if(isset($this->presenter)) {
            $model->presenter = $this->presenter;
        }

        return $model;
    }
}
