<?php

namespace BorisNedovis\EloquentPresenter;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;
use BorisNedovis\EloquentPresenter\Helpers\ObjectArray;

abstract class AbstractPresenter implements Arrayable
{
    protected $model;

    /**
     *  Attributes (functions of presentation)
     */
    protected array $attributes = [];

    /**
     * Presenter constructor.
     *
     * @param  Model|array  $model
     */
    public function __construct($model = null)
    {
        $this->model = is_array($model) ? new ObjectArray($model) : $model;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->model->{$name};
    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        $result = [];

        $attributes = $this->getAttributes();
        foreach ($attributes as $attribute) {
            $methodName = 'get' . Str::studly($attribute) . 'Attribute';

            if (method_exists($this, $methodName)) {
                $result[$attribute] = $this->{$methodName}();
            } else {
                $result[$attribute] = $this->model->{$attribute};
            }
        }

        return $result;
    }
}
