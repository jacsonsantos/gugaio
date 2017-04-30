<?php
namespace JSantos\Command;

trait CommandTrait
{
    protected $path = '';

    protected function manipulation(string $model) : string
    {
        $model = str_replace("\\",'/',$model);
        $model = explode('/',$model);
        foreach ($model as $key => $value) {
            $model[$key] = ucfirst($value);
        }
        return implode('/',$model);
    }
    protected function getNameFile(string $model) : string
    {
        return (strpos($model,'/')) ? substr(strrchr($model, '/'), 1) : $model;
    }
}