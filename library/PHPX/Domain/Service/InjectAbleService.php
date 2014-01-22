<?php
/**
 * @author psyduck.mans
 */

namespace PHPX\Domain\Service;

/**
 * Class InjectAbleService
 */
abstract class InjectAbleService
{
    /**
     * @var \DI\Container
     */
    protected $container;

    /**
     * __construct
     */
    public function __construct()
    {
        if ($this->container == null) {
            $this->container = new \DI\Container();
        }

        // Inject dependencies
        $this->container->injectOn($this);
    }
}