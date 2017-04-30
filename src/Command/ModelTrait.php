<?php
namespace JSantos\Command;

trait ModelTrait
{
    protected $path = __DIR__.'/../Model/';

    protected function filterNewModel(string $model)
    {
        $model = str_replace("\\",'/',$model);
        $model = explode('/',$model);
        foreach ($model as $key => $value) {
            $model[$key] = ucfirst($value);
        }
        return implode('/',$model);
    }
    protected function getNameModel(string $model)
    {
        return (strpos($model,'/')) ? substr(strrchr($model, '/'), 1) : $model;
    }
}