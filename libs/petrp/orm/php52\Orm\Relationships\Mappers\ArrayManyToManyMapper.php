<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Mapper for ManyToMany relationship.
 * It saves array of id at parent entity.
 *
 * @see IMapper::createManyToManyMapper()
 * @see ArrayMapper::createManyToManyMapper()
 * @author Petr Procházka
 * @package Orm
 * @subpackage Relationships\Mappers
 */
class ArrayManyToManyMapper extends OrmObject implements IManyToManyMapper
{

	/** @var RelationshipMetaDataManyToMany */
	private $meta;

	/**
	 * @param array id => id {@see ManyToMany::$injectedValue}
	 * @return array id => id will be set as {@see ManyToMany::$injectedValue}
	 */
	public function validateInjectedValue($injectedValue)
	{
		if ($this->meta->getWhereIsMapped() !== RelationshipMetaDataToMany::MAPPED_THERE)
		{
			if (ValidationHelper::isValid(array('array'), $injectedValue) AND $injectedValue)
			{
				$injectedValue = array_combine($injectedValue, $injectedValue);
			}
			else
			{
				$injectedValue = array();
			}
			return $injectedValue;
		}
	}

	/** @param RelationshipMetaDataManyToMany */
	public function attach(RelationshipMetaDataManyToMany $meta)
	{
		$this->meta = $meta;
	}

	/**
	 * @param IEntity
	 * @param array id => id
	 * @param array id => id {@see ManyToMany::$injectedValue}
	 * @return array id => id will be set as {@see ManyToMany::$injectedValue}
	 */
	public function add(IEntity $parent, array $ids, $injectedValue)
	{
		if ($this->meta->getWhereIsMapped() === RelationshipMetaDataToMany::MAPPED_THERE)
		{
			throw new OrmNotSupportedException('IManyToManyMapper::add() has not supported on inverse side.');
		}

		$parent->markAsChanged($this->meta->getParentParam());
		$injectedValue = $injectedValue + $ids;
		return $injectedValue;
	}

	/**
	 * @param IEntity
	 * @param array id => id
	 * @param array id => id {@see ManyToMany::$injectedValue}
	 * @return array id => id will be set as {@see ManyToMany::$injectedValue}
	 */
	public function remove(IEntity $parent, array $ids, $injectedValue)
	{
		if ($this->meta->getWhereIsMapped() === RelationshipMetaDataToMany::MAPPED_THERE)
		{
			throw new OrmNotSupportedException('IManyToManyMapper::remove() has not supported on inverse side.');
		}

		$parent->markAsChanged($this->meta->getParentParam());
		$injectedValue = array_diff_key($injectedValue, $ids);
		return $injectedValue;
	}

	/**
	 * @param IEntity
	 * @param array id => id
	 * @param array id => id {@see ManyToMany::$injectedValue}
	 * @return array id => id
	 */
	public function load(IEntity $parent, $injectedValue)
	{
		$mapped = $this->meta->getWhereIsMapped();
		if ($mapped === RelationshipMetaDataToMany::MAPPED_THERE OR $mapped === RelationshipMetaDataToMany::MAPPED_BOTH)
		{
			$childRepo = $parent->getModel()->{$this->meta->getChildRepository()};
			$childParam = $this->meta->getChildParam();
			$pid = $parent->id;
			$value = array();
			if ($mapped === RelationshipMetaDataToMany::MAPPED_BOTH)
			{
				$value = $injectedValue;
			}
			foreach ($childRepo->mapper->findAll() as $child)
			{
				$childInjectedValue = $child->{$childParam}->getInjectedValue();
				if ($childInjectedValue AND isset($childInjectedValue[$pid]))
				{
					$value[$child->id] = $child->id;
				}
			}
			return $value;
		}
		else
		{
			return $injectedValue;
		}
	}

	/** @deprecated */
	final public function setInjectedValue($value)
	{
		throw new OrmDeprecatedException(array($this, 'setInjectedValue()', $this, 'validateInjectedValue()'));
	}

	/** @deprecated */
	final public function getInjectedValue()
	{
		throw new OrmDeprecatedException(array($this, 'getInjectedValue()', $this, 'validateInjectedValue()'));
	}

	/** @deprecated */
	final public function setValue($value)
	{
		throw new OrmDeprecatedException(array($this, 'setValue()', $this, 'setInjectedValue()'));
	}

	/** @deprecated */
	final public function getValue()
	{
		throw new OrmDeprecatedException(array($this, 'getValue()', $this, 'getInjectedValue()'));
	}

	/** @deprecated */
	final public function setParams($parentIsFirst)
	{
		throw new OrmDeprecatedException(array($this, 'setParams()', $this, 'attach()'));
	}

}
