<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * OrmObject behaviour mixin.
 *
 * @author David Grudl
 * @copyright Nette Framework
 * @author Petr Procházka
 * @package Orm
 * @subpackage Common
 */
final class OrmObjectMixin
{
	/** @var array */
	private static $methods;

	/**
	 * Call to undefined method.
	 * @param object
	 * @param string method name
	 * @param array arguments
	 * @return mixed
	 * @throws OrmMemberAccessException
	 */
	public static function call($_this, $name, $args)
	{
		$class = get_class($_this);
		throw new OrmMemberAccessException("Call to undefined method $class::$name().");
	}

	/**
	 * Call to undefined static method.
	 * @param object
	 * @param string method name
	 * @param array arguments
	 * @return mixed
	 * @throws OrmMemberAccessException
	 */
	public static function callStatic($class, $name, $args)
	{
		throw new OrmMemberAccessException("Call to undefined static method $class::$name().");
	}

	/**
	 * Returns property value.
	 * @param object
	 * @param string property name
	 * @return mixed property value
	 * @throws OrmMemberAccessException if the property is not defined.
	 */
	public static function & get($_this, $name)
	{
		$class = get_class($_this);

		if ($name === '')
		{
			throw new OrmMemberAccessException("Cannot read a class '$class' property without name.");
		}

		if (!isset(self::$methods[$class])) {
			// get_class_methods returns ONLY PUBLIC methods of objects
			// but returns static methods too (nothing doing...)
			// and is much faster than reflection
			// (works good since 5.0.4)
			self::$methods[$class] = array_flip(get_class_methods($class));
		}

		// property getter support
		$name[0] = $name[0] & "\xDF"; // case-sensitive checking, capitalize first character
		$m = 'get' . $name;
		if (isset(self::$methods[$class][$m])) {
			// ampersands:
			// - uses &__get() because declaration should be forward compatible (e.g. with Nette\Utils\Html)
			// - doesn't call &$_this->$m because user could bypass property setter by: $x = & $obj->property; $x = 'new value';
			$val = $_this->$m();
			return $val;
		}

		$m = 'is' . $name;
		if (isset(self::$methods[$class][$m])) {
			$val = $_this->$m();
			return $val;
		}

		$type = isset(self::$methods[$class]['set' . $name]) ? 'a write-only' : 'an undeclared';
		$name = func_get_arg(1);
		throw new OrmMemberAccessException("Cannot read $type property $class::\$$name.");
	}

	/**
	 * Sets value of a property.
	 * @param object
	 * @param string property name
	 * @param mixed property value
	 * @return void
	 * @throws OrmMemberAccessException if the property is not defined or is read-only
	 */
	public static function set($_this, $name, $value)
	{
		$class = get_class($_this);

		if ($name === '')
		{
			throw new OrmMemberAccessException("Cannot write to a class '$class' property without name.");
		}

		if (!isset(self::$methods[$class]))
		{
			self::$methods[$class] = array_flip(get_class_methods($class));
		}

		// property setter support
		$name[0] = $name[0] & "\xDF"; // case-sensitive checking, capitalize first character

		$m = 'set' . $name;
		if (isset(self::$methods[$class][$m]))
		{
			$_this->$m($value);
			return;
		}

		$type = (
			isset(self::$methods[$class]['get' . $name]) OR
			isset(self::$methods[$class]['is' . $name])
		) ? 'a read-only' : 'an undeclared';
		$name = func_get_arg(1);
		throw new OrmMemberAccessException("Cannot write to $type property $class::\$$name.");
	}

	/**
	 * Throws exception.
	 * @param object
	 * @param string property name
	 * @param mixed property value
	 * @throws OrmMemberAccessException
	 */
	public static function remove($_this, $name)
	{
		$class = get_class($_this);
		throw new OrmMemberAccessException("Cannot unset the property $class::\$$name.");
	}

	/**
	 * Is property defined?
	 * @param object
	 * @param string property name
	 * @return bool
	 */
	public static function has($_this, $name)
	{
		if ($name === '')
		{
			return false;
		}

		$class = get_class($_this);
		if (!isset(self::$methods[$class]))
		{
			self::$methods[$class] = array_flip(get_class_methods($class));
		}

		$name[0] = $name[0] & "\xDF";
		return isset(self::$methods[$class]['get' . $name]) OR isset(self::$methods[$class]['is' . $name]);
	}

}
