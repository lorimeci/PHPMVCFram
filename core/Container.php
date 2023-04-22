<?php

namespace Core;

use Psr\Container\ContainerInterface;
use Core\Exceptions\NotFoundException;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private $services = [];

    //Get $id = get class
    public function get($id)
    {
        $item = $this->resolve($id);
        if (!($item instanceof ReflectionClass)) {
            return $item;
        }

        $instance = $this->getInstance($item);

        if (isset($this->services[$id]) && $this->services[$id]['is_singleton']) {
            //nqs ky object esht singleton athere e vendosim ktu qe ta aksesojme heren tjt direkt.
            $this->services[$id]['value'] = $instance;
        }
        return $instance;
    }

    public function has($id)
    {
        try {
            $item = $this->resolve($id);
        } catch (NotFoundException $e) {
            return false;
        }
        if ($item instanceof ReflectionClass) {
            return $item->isInstantiable();
        }
        return isset($item);
    }

    public function singleton(string $key, $value)
    {
        $this->set($key, $value, true);
    }

    public function set(string $key, $value, $isSingleton = false)
    {
        $this->services[$key]['value'] = $value;
        $this->services[$key]['is_singleton'] = $isSingleton;
        return $this;
    }

    //resolve method is making an object from relection class
    private function resolve($id)
    {
        try {
            $name = $id;
            if (isset($this->services[$id])) {
                $name = $this->services[$id]['value'];
                if (is_callable($name)) {
                    return $name();
                }
                if (is_object($name) && $this->services[$id]['is_singleton']) {
                    return $name;
                }
            }
            return (new ReflectionClass($name));
        } catch (ReflectionException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getInstance(ReflectionClass $item)
    {
        //we get the constructor and check if there is any, if there is we get the params from constructor and
        $constructor = $item->getConstructor();
        if (is_null($constructor) || $constructor->getNumberOfRequiredParameters() == 0) {
            return $item->newInstance();
        }
        //trying  to make the instance of constructor params recursively
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            if ($type = $param->getType()) {
                $params[] = $this->get($type->getName());
            }
        }
        return $item->newInstanceArgs($params); //kthejme instancen bashk me parametra.
    }
}
