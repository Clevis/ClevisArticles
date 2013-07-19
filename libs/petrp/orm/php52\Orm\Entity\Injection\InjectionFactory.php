<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Factory for IEntityInjection.
 * @author Petr Procházka
 * @package Orm
 * @subpackage Entity\Injection
 */
class InjectionFactory
{
	private $className;
	private $callback;

	/**
	 * @todo remove
	 */
	private function __construct()
	{
	}

	/**
	 * @param OrmCallback
	 * @param string
	 * @return OrmCallback
	 */
	public static function create(OrmCallback $callback, $className)
	{
		$factory = new self;
		$factory->callback = $callback->getNative();
		$factory->className = $className;
		return OrmCallback::create($factory, 'call');
	}

	/**
	 * @param IEntity
	 * @param mixed
	 * @return IEntityInjection
	 */
	public function call(IEntity $entity, $value)
	{
		$result = call_user_func($this->callback, $this->className, $entity, $value);
		if (!($result instanceof IEntityInjection))
		{
			$tmp = array(NULL, $this->className . ' factory');
			if (is_array($this->callback) AND count($this->callback) === 2)
			{
				$tmp = $this->callback;
			}
			throw new BadReturnException(array($tmp[0], $tmp[1], 'IEntityInjection', $result));
		}
		return $result;
	}

}
