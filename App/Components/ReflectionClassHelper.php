<?php

namespace App\Components;

class ReflectionClassHelper
{
    protected static \ReflectionClass $rc;


    public function __construct()
    {
    }

    /**
     * @param string $className
     * @return ReflectionClassHelper
     * @throws \ReflectionException
     */
    public static function setReflectionClass(string $className): ReflectionClassHelper
    {
        if (class_exists($className)) {
            static::$rc = new \ReflectionClass($className);
            return new static();
        }

        throw new \Exception("Undefined class: $className");
    }

    /**
     * @param \ReflectionClass $rc
     * @param string $action
     * @return bool
     * @throws \Exception
     */
    private function checkActionExist(\ReflectionClass $rc, string $action): bool
    {
        if ($rc->hasMethod($action)) {
            return true;
        }

        throw new \Exception("The {$rc->getName()} class does not have this $action method");
    }

    /**
     * Calling the required action
     * @param string $action
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function invoke(string $action): void
    {
        $rc = static::$rc;
        if ($this->checkActionExist($rc, $action)) {
            $instance = $rc->newInstance();
            $rm = $rc->getMethod($action);
            $rm->invoke($instance, $action);
        }
    }
}