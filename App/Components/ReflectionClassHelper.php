<?php


namespace App\Components;


class ReflectionClassHelper
{
    private \ReflectionClass $rc;

    public function __construct(string $className)
    {
        $this->rc = $this->getReflectionClass($className);
    }

    /**
     * @param string $className
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    private function getReflectionClass(string $className): \ReflectionClass
    {
        if (class_exists($className)) {
            return new \ReflectionClass($className);
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
     */
    public function invoke(string $action)
    {
        $rc= $this->rc;
        if ($this->checkActionExist($rc, $action)) {
            $instance = $rc->newInstance();
            $rm = $rc->getMethod($action);
            $rm->invoke($instance, $action);
        }
    }
}