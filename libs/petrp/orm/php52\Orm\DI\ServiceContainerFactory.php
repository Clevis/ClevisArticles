<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * DI Container Factory.
 * @author Petr Procházka
 * @package Orm
 * @subpackage DI
 */
class ServiceContainerFactory extends OrmObject implements IServiceContainerFactory
{
	/** @var IServiceContainer */
	private $container;

	/** @param IServiceContainer|NULL */
	public function __construct(IServiceContainer $container = NULL)
	{
		if (!$container) $container = new ServiceContainer;
		$container->addService('annotationsParser', 'OrmAnnotationsParser');
		$container->addService('annotationClassParser', array($this, 'createAnnotationClassParser'));
		$container->addService('mapperFactory', array($this, 'createMapperFactory'));
		$container->addService('repositoryHelper', 'RepositoryHelper');
		$container->addService('dibi', array($this, 'createDibi'));
		if ($performanceHelperCache = $this->getPerformanceHelperCacheFactory())
		{
			$container->addService('performanceHelperCache', $performanceHelperCache);
		}
		$this->container = $container;
	}

	/** @return IServiceContainer */
	public function getContainer()
	{
		return $this->container;
	}

	/**
	 * @param IServiceContainer
	 * @return AnnotationClassParser
	 */
	public function createAnnotationClassParser(IServiceContainer $container)
	{
		return new AnnotationClassParser($container->getService('annotationsParser', 'OrmAnnotationsParser'));
	}

	/**
	 * @param IServiceContainer
	 * @return IMapperFactory
	 */
	public function createMapperFactory(IServiceContainer $container)
	{
		return new MapperFactory($container->getService('annotationClassParser', 'AnnotationClassParser'));
	}

	/** @return DibiConnection */
	public function createDibi()
	{
		return dibi::getConnection();
	}

	/** @return Closure */
	protected function getPerformanceHelperCacheFactory()
	{
		foreach (array('Nette\Environment', 'NEnvironment', 'Environment') as $class)
		{
			if (class_exists($class))
			{
				return create_function('', 'extract(OrmCallback::$vars['.OrmCallback::uses(array('class'=>$class)).'], EXTR_REFS); return call_user_func(array($class, \'getCache\'), \'PerformanceHelper\'); ');
			}	// @codeCoverageIgnoreStart
		}
	}			// @codeCoverageIgnoreEnd

}
