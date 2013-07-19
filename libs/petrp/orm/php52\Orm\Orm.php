<?php
/**
 * Orm
 * @author Petr Procházka (petr@petrp.cz)
 * @license "New" BSD License
 */

/**
 * Orm.
 * @author Petr Procházka
 * @package Orm
 */
final class Orm
{

	/** @var string <generation>.<major>.<minor> */
	const VERSION = '0.4.0-RC6';

	/** @var int <generation> * 10000 + <major> * 100 + <minor> */
	const VERSION_ID = 399.999999;

	/** @var string <gitCommitHash> released on <date> */
	const REVISION = '1e8e475 released on 2013-04-23';

	/** @var string 5.3|5.2 */
	const PACKAGE = '5.2';

}

if (!defined('PHP_VERSION_ID'))
{
	// php < 5.2.7
	$tmp = explode('.', PHP_VERSION);
	define('PHP_VERSION_ID', ($tmp[0] * 10000 + $tmp[1] * 100 + $tmp[2]));
}

require_once dirname(__FILE__) . '/Common/Object.php';
require_once dirname(__FILE__) . '/Common/ObjectMixin.php';
require_once dirname(__FILE__) . '/Common/Callback.php';
require_once dirname(__FILE__) . '/Common/Inflector.php';
require_once dirname(__FILE__) . '/Common/AnnotationsParser.php';
require_once dirname(__FILE__) . '/Common/Exceptions/ExceptionHelper.php';
require_once dirname(__FILE__) . '/Common/Exceptions/BadReturnException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/DeprecatedException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/EntityNotFoundException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/InvalidArgumentException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/InvalidEntityException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/NotImplementedException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/NotSupportedException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/RequiredArgumentException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/MemberAccessException.php';
require_once dirname(__FILE__) . '/Common/Exceptions/NotCallableException.php';

require_once dirname(__FILE__) . '/RepositoryContainer/IRepositoryContainer.php';
require_once dirname(__FILE__) . '/RepositoryContainer/RepositoryContainer.php';
require_once dirname(__FILE__) . '/RepositoryContainer/Exceptions/RepositoryNotFoundException.php';
require_once dirname(__FILE__) . '/RepositoryContainer/Exceptions/RepositoryAlreadyRegisteredException.php';

require_once dirname(__FILE__) . '/Repository/IRepository.php';
require_once dirname(__FILE__) . '/Repository/Repository.php';
require_once dirname(__FILE__) . '/Repository/Helpers/RepositoryHelper.php';
require_once dirname(__FILE__) . '/Repository/Helpers/IdentityMap.php';
require_once dirname(__FILE__) . '/Repository/Helpers/PerformanceHelper.php';
require_once dirname(__FILE__) . '/Repository/Helpers/MapperAutoCaller.php';
require_once dirname(__FILE__) . '/Repository/Helpers/MapperAutoCallerException.php';
require_once dirname(__FILE__) . '/Repository/Exceptions/RecursiveException.php';

require_once dirname(__FILE__) . '/Repository/Events/Events.php';
require_once dirname(__FILE__) . '/Repository/Events/EventArguments.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListener.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerHydrateBefore.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerHydrateAfter.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerAttach.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersistBefore.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersistBeforeInsert.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersistBeforeUpdate.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersist.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersistAfterInsert.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersistAfterUpdate.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerPersistAfter.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerRemoveBefore.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerRemoveAfter.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerFlushBefore.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerFlushAfter.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerCleanBefore.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerCleanAfter.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerSerializeBefore.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerSerializeAfter.php';
require_once dirname(__FILE__) . '/Repository/Events/Types/IListenerSerializeConventional.php';

require_once dirname(__FILE__) . '/Entity/IEntity.php';
require_once dirname(__FILE__) . '/Entity/EntityFragments/EventEntityFragment.php';
require_once dirname(__FILE__) . '/Entity/EntityFragments/AttachableEntityFragment.php';
require_once dirname(__FILE__) . '/Entity/EntityFragments/ValueEntityFragment.php';
require_once dirname(__FILE__) . '/Entity/EntityFragments/BaseEntityFragment.php';
require_once dirname(__FILE__) . '/Entity/Entity.php';
require_once dirname(__FILE__) . '/Entity/Helpers/EntityHelper.php';
require_once dirname(__FILE__) . '/Entity/Helpers/ValidationHelper.php';
require_once dirname(__FILE__) . '/Entity/Helpers/EntityToArray.php';
require_once dirname(__FILE__) . '/Entity/Helpers/EntityToArrayNoModeException.php';
require_once dirname(__FILE__) . '/Entity/Exceptions/EntityAlreadyAttachedException.php';
require_once dirname(__FILE__) . '/Entity/Exceptions/EntityNotAttachedException.php';
require_once dirname(__FILE__) . '/Entity/Exceptions/EntityNotPersistedException.php';
require_once dirname(__FILE__) . '/Entity/Exceptions/NotValidException.php';
require_once dirname(__FILE__) . '/Entity/Exceptions/PropertyAccessException.php';
require_once dirname(__FILE__) . '/Entity/Exceptions/EntityWasRemovedException.php';

require_once dirname(__FILE__) . '/Entity/Injection/IEntityInjection.php';
require_once dirname(__FILE__) . '/Entity/Injection/IEntityInjectionLoader.php';
require_once dirname(__FILE__) . '/Entity/Injection/IEntityInjectionStaticLoader.php';
require_once dirname(__FILE__) . '/Entity/Injection/InjectionFactory.php';
require_once dirname(__FILE__) . '/Entity/Injection/Injection.php';

require_once dirname(__FILE__) . '/Entity/MetaData/MetaData.php';
require_once dirname(__FILE__) . '/Entity/MetaData/MetaDataProperty.php';
require_once dirname(__FILE__) . '/Entity/MetaData/AnnotationMetaData.php';
require_once dirname(__FILE__) . '/Entity/MetaData/MetaDataException.php';
require_once dirname(__FILE__) . '/Entity/MetaData/AnnotationMetaDataException.php';
require_once dirname(__FILE__) . '/Entity/MetaData/MetaDataNestingLevelException.php';

require_once dirname(__FILE__) . '/Mappers/IMapper.php';
require_once dirname(__FILE__) . '/Mappers/Mapper.php';
require_once dirname(__FILE__) . '/Mappers/DibiMapper.php';
require_once dirname(__FILE__) . '/Mappers/ArrayMapper.php';
require_once dirname(__FILE__) . '/Mappers/FileMapper.php';
require_once dirname(__FILE__) . '/Mappers/Helpers/DibiPersistenceHelper.php';
require_once dirname(__FILE__) . '/Mappers/Helpers/DibiJoinHelper.php';
require_once dirname(__FILE__) . '/Mappers/Exceptions/MapperPersistenceException.php';
require_once dirname(__FILE__) . '/Mappers/Exceptions/MapperJoinException.php';
require_once dirname(__FILE__) . '/Mappers/Exceptions/ArrayMapperLockException.php';

require_once dirname(__FILE__) . '/Mappers/Factory/IMapperFactory.php';
require_once dirname(__FILE__) . '/Mappers/Factory/MapperFactory.php';
require_once dirname(__FILE__) . '/Mappers/Factory/AnnotationClassParser.php';
require_once dirname(__FILE__) . '/Mappers/Factory/Exceptions/AnnotationClassParserException.php';
require_once dirname(__FILE__) . '/Mappers/Factory/Exceptions/AnnotationClassParserMorePossibleClassesException.php';
require_once dirname(__FILE__) . '/Mappers/Factory/Exceptions/AnnotationClassParserNoClassFoundException.php';

require_once dirname(__FILE__) . '/Mappers/Conventional/IConventional.php';
require_once dirname(__FILE__) . '/Mappers/Conventional/IDatabaseConventional.php';
require_once dirname(__FILE__) . '/Mappers/Conventional/NoConventional.php';
require_once dirname(__FILE__) . '/Mappers/Conventional/SqlConventional.php';

require_once dirname(__FILE__) . '/Mappers/Collection/IEntityCollection.php';
require_once dirname(__FILE__) . '/Mappers/Collection/ArrayCollection.php';
require_once dirname(__FILE__) . '/Mappers/Collection/BaseDibiCollection.php';
require_once dirname(__FILE__) . '/Mappers/Collection/DibiCollection.php';
require_once dirname(__FILE__) . '/Mappers/Collection/DataSourceCollection.php';
require_once dirname(__FILE__) . '/Mappers/Collection/Helpers/HydrateEntityIterator.php';
require_once dirname(__FILE__) . '/Mappers/Collection/Helpers/FetchAssoc.php';
require_once dirname(__FILE__) . '/Mappers/Collection/Helpers/FindByHelper.php';

require_once dirname(__FILE__) . '/Relationships/IRelationship.php';
require_once dirname(__FILE__) . '/Relationships/BaseToMany.php';
require_once dirname(__FILE__) . '/Relationships/OneToMany.php';
require_once dirname(__FILE__) . '/Relationships/ManyToMany.php';
require_once dirname(__FILE__) . '/Relationships/Mappers/IManyToManyMapper.php';
require_once dirname(__FILE__) . '/Relationships/Mappers/ArrayManyToManyMapper.php';
require_once dirname(__FILE__) . '/Relationships/Mappers/DibiManyToManyMapper.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaData.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaDataToOne.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaDataOneToOne.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaDataManyToOne.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaDataToMany.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaDataOneToMany.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipMetaDataManyToMany.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipLoader.php';
require_once dirname(__FILE__) . '/Relationships/MetaData/RelationshipLoaderException.php';
require_once dirname(__FILE__) . '/Relationships/Exceptions/BadEntityException.php';

require_once dirname(__FILE__) . '/DI/IServiceContainer.php';
require_once dirname(__FILE__) . '/DI/ServiceContainer.php';
require_once dirname(__FILE__) . '/DI/IServiceContainerFactory.php';
require_once dirname(__FILE__) . '/DI/ServiceContainerFactory.php';
require_once dirname(__FILE__) . '/DI/Exceptions/FrozenContainerException.php';
require_once dirname(__FILE__) . '/DI/Exceptions/InvalidServiceFactoryException.php';
require_once dirname(__FILE__) . '/DI/Exceptions/ServiceAlreadyExistsException.php';
require_once dirname(__FILE__) . '/DI/Exceptions/ServiceNotFoundException.php';
require_once dirname(__FILE__) . '/DI/Exceptions/ServiceNotInstanceOfException.php';
