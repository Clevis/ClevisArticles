<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * It defines some handful methods and enhances object core of PHP:
 *   - access to undeclared members throws exceptions
 *   - support for conventional properties with getters and setters
 *
 * Properties is a syntactic sugar which allows access public getter and setter
 * methods as normal object variables. A property is defined by a getter method
 * or setter method (no setter method means read-only property).
 * <code>
 * $val = $obj->label; // equivalent to $val = $obj->getLabel();
 * $obj->label = 'Nette'; // equivalent to $obj->setLabel('Nette');
 * </code>
 * Property names are case-sensitive, and they are written in the camelCaps
 * or PascalCaps.
 *
 * @author David Grudl
 * @copyright Nette Framework
 * @author Petr Procházka
 * @package Orm
 * @subpackage Common
 */
abstract class OrmObject
{

	/**
	 * Call to undefined method.
	 * @param string method name
	 * @param array arguments
	 * @return mixed
	 * @throws OrmMemberAccessException
	 */
	public function __call($name, $args)
	{
		return OrmObjectMixin::call($this, $name, $args);
	}

	/**
	 * Call to undefined static method.
	 * @param string method name (in lower case!)
	 * @param array arguments
	 * @return mixed
	 * @throws OrmMemberAccessException
	 */
	public static function __callStatic($name, $args)
	{
		return OrmObjectMixin::callStatic(__CLASS__, $name, $args);
	}

	/**
	 * Returns property value. Do not call directly.
	 * @param string property name
	 * @return mixed property value
	 * @throws OrmMemberAccessException if the property is not defined.
	 */
	public function &__get($name)
	{
		return OrmObjectMixin::get($this, $name);
	}

	/**
	 * Sets value of a property. Do not call directly.
	 * @param string property name
	 * @param mixed property value
	 * @return void
	 * @throws OrmMemberAccessException if the property is not defined or is read-only
	 */
	public function __set($name, $value)
	{
		return OrmObjectMixin::set($this, $name, $value);
	}

	/**
	 * Is property defined?
	 * @param string property name
	 * @return bool
	 */
	public function __isset($name)
	{
		return OrmObjectMixin::has($this, $name);
	}

	/**
	 * Access to undeclared property.
	 * @param string property name
	 * @return void
	 * @throws OrmMemberAccessException
	 */
	public function __unset($name)
	{
		OrmObjectMixin::remove($this, $name);
		// @codeCoverageIgnoreStart
	}	// @codeCoverageIgnoreEnd

}

require_once dirname(__FILE__) . '/../Orm.php';
