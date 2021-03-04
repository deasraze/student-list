<?php

namespace App\Components;

use App\Components\Exceptions\ApplicationException;

class DIContainer
{
    /*
     * List of registered services
     * ['name_services' => closure $container]
     */
    private array $registered = [];

    /*
     * List of created services
     * ['name_services' => object services]
     */
    private array $created = [];

    /**
     * DIContainer constructor.
     */
    public function __construct()
    {
    }

    /**
     * Register a services
     * @param string $name
     * @param \Closure $container
     * @throws ApplicationException
     */
    public function register(string $name, \Closure $container): void
    {
        if (array_key_exists($name, $this->registered)) {
            throw new ApplicationException(
                "It is not possible to register a service with this name $name, it is already registered"
            );
        }

        $this->registered[$name] = $container;
    }

    /**
     * Return of the requested service
     * @param string $name
     * @return mixed
     * @throws ApplicationException
     */
    public function get(string $name)
    {
        if (array_key_exists($name, $this->created)) {
            return $this->created[$name];
        }
        if (!array_key_exists($name, $this->registered)) {
            throw new ApplicationException(
                "The service with this name $name is not in the list of registered services"
            );
        }

        $closure = $this->registered[$name];
        return $this->created[$name] = $closure($this);
    }
}
