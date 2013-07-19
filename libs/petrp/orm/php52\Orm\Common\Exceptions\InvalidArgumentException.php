<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Argument does not match with the expected value.
 * @author Petr Procházka
 * @package Orm
 * @subpackage Common\Exceptions
 */
class OrmInvalidArgumentException extends LogicException
{

	/**
	 * @param string|array
	 * @param int
	 * @param Exception
	 */
	public function __construct($message = NULL, $code = NULL)
	{
		$message = ExceptionHelper::format($message, "%c1<%1&2%::>%s2 must be %s3<%!5%; '%v4' given>%s5.");
		parent::__construct($message, $code);
	}
}
