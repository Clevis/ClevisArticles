<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * PHP callback encapsulation.
 *
 * @author David Grudl
 * @copyright Nette Framework
 * @author Petr Procházka
 * @package Orm
 * @subpackage Common
 */
final class OrmCallback extends OrmObject
{
	/** @var string|array|Closure */
	private $cb;

	/**
	 * OrmCallback factory.
	 * @param mixed class, object, function, callback
	 * @param string method
	 * @return OrmCallback
	 */
	public static function create($callback, $m = NULL)
	{
		if ($m === NULL AND $callback instanceof OrmCallback)
		{
			return $callback;
		}
		return new OrmCallback($callback, $m);
	}

	/**
	 * Is instance of Callback?
	 * Orm or Nette.
	 * @param mixed class, object, function, callback
	 * @return bool
	 */
	public static function is($callback)
	{
		if ($callback instanceof OrmCallback)
		{
			return true;
		}
		static $c = '\Nette\Callback'; // php52
		if ($callback instanceof $c)
		{
			return true;
		}
		if ($callback instanceof NCallback)
		{
			return true;
		}
		if ($callback instanceof Callback)
		{
			return true;
		}
		return false;
	}

	/**
	 * @see self::create()
	 * @param mixed class, object, function, callback
	 * @param string method
	 */
	protected function __construct($t, $m = NULL)
	{
		if ($m === NULL)
		{
			if (is_string($t))
			{
				$t = explode('::', $t, 2);
				$this->cb = isset($t[1]) ? $t : $t[0];
			}
			else if (is_object($t))
			{
				if ($t instanceof Closure)
				{
					$this->cb = $t;
				}
				else if (OrmCallback::is($t))
				{
					$this->cb = $t->getNative();
				}
				else
				{
					$this->cb = array($t, '__invoke');
				}
			}
			else
			{
				$this->cb = $t;
			}
		}
		else
		{
			$this->cb = array($t, $m);
		}

		if (!is_callable($this->cb, TRUE))
		{
			throw new OrmInvalidArgumentException("Invalid callback.");
		}
	}

	/**
	 * Invokes callback. Do not call directly.
	 * @return mixed
	 * @throws NotCallableException
	 */
	public function __invoke()
	{
		return $this->invokeArgs(func_get_args());
	}

	/**
	 * Invokes callback.
	 * @return mixed
	 * @throws NotCallableException
	 */
	public function invoke()
	{
		return $this->invokeArgs(func_get_args());
	}

	/**
	 * Invokes callback with an array of parameters.
	 * @param array
	 * @return mixed
	 * @throws NotCallableException
	 */
	public function invokeArgs(array $args)
	{
		if (!is_callable($this->cb))
		{
			throw new NotCallableException("Callback '$this' is not callable.");
		}
		return call_user_func_array($this->cb, $args);
	}

	/**
	 * Returns PHP callback pseudotype.
	 * @return string|array|Closure
	 */
	public function getNative()
	{
		return $this->cb;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		if ($this->cb instanceof Closure)
		{
			return '{closure}';
		}
		else if (is_string($this->cb) && $this->cb[0] === "\0")
		{
			return '{lambda}';
		}
		is_callable($this->cb, TRUE, $textual);
		return $textual;
	}

	/** @var array Simulate closure scope in php 5.2 @access private */
	static $vars = array();

	/**
	 * Simulate closure scope in php 5.2
	 * <code>
	 * 	function () use ($foo, $bar) {}
	 * </code>
	 * <code>
	 * 	create_function('', 'extract(Callback::$vars['.Callback::uses(array('foo'=>$foo,'bar'=>$bar)).'], EXTR_REFS);')
	 * </code>
	 * @access private
	 * @see Builder\PhpParser::replaceClosures()
	 * @param array
	 * @return int
	 */
	static function uses($args)
	{
		self::$vars[] = $args;
		return count(self::$vars)-1;
	}

}
