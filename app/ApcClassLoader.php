<?php
namespace App;

class ApcClassLoader
{

	/**
	 * The APC namespace prefix to use.
	 * @var string
	 */
	private $prefix;

	/**
	 * A class loader object that implements the findFile() method.
	 * @var ClassLoader
	 */
	protected $instance;

	/**
	 * Constructor
	 *
	 * @param string                      $prefix    The APC namespace prefix to use.
	 * @param ClassLoader $instance  A class loader object that implements the findFile() method.
	 */
	public function __construct($prefix, $instance)
	{
		if (!extension_loaded('apc')) {
			throw new \RuntimeException('Unable to use ApcClassLoader as APC is not enabled.');
		}

		$this->prefix = $prefix;
		$this->instance = $instance;
	}

	/**
     * Finds a file by class name while caching lookups to APC.
     *
     * @param string $class A class name to resolve to file
     *
     * @return string|null
     */
    public function findFile($class)
    {
        if (false === $file = apc_fetch($this->prefix.$class)) {
            apc_store($this->prefix . $class, $file = $this->instance->findFile($class));
        }

        return $file;
    }

    /**
     * Past the rest of the part to the wrapped classloader.
     *
     * @param string $method
     * @param $arguments
     */
    public function __call($method, $arguments)
    {
    	if (!method_exists($this->instance, $method))
    		throw new \RuntimeException("$method us not");
    	return call_user_func_array([$this->instance, $method], $arguments);
    }

	public function register($prepend = false)
	{
		spl_autoload_register([$this, 'loadClass'], true, $prepend);
	}

	public function unregister()
	{
		spl_autoload_unregister([$this, 'loadClass']);
	}

	public function loadClass($class)
    {
        if ($file = $this->findFile($class)) {
            require_once $file;
            return true;
        }

        return false;
    }
}
