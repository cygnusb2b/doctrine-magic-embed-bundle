<?php
namespace Cygnus\DoctrineMagicEmbedBundle\Mapping;

use Cygnus\DoctrineMagicEmbedBundle\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Persistence\Mapping\ClassMetadataFactory as FactoryInterface;
use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;

class ClassMetadataFactory implements FactoryInterface
{

    protected $driver;

    private $loadedMetadata = array();

    private $cacheDriver = false;

    private $reflectionService;

    public function __construct(AnnotationDriver $driver)
    {
        $this->driver = $driver;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Forces the factory to load the metadata of all classes known to the underlying
     * mapping driver.
     *
     * @return array The ClassMetadata instances of all mapped classes.
     */
    public function getAllMetadata()
    {

        $driver = $this->getDriver();
        $metadata = array();
        // foreach ($driver->getAllClassNames() as $className) {
        //     $metadata[] = $this->getMetadataFor($className);
        // }

        $metadata[] = $this->getMetadataFor($className);

        return $metadata;
    }



    /**
     * Gets the class metadata descriptor for a class.
     *
     * @param string $className The name of the class.
     * @todo Do we want to add support for class aliases? e.g. NamespaceHere:ClassHere
     * @todo Need to implement metadata caching
     * @return ClassMetadata
     */
    public function getMetadataFor($className)
    {
        if (isset($this->loadedMetadata[$className])) {
            // Return metadata if it's already loaded
            return $this->loadedMetadata[$className];
        }

        if ($this->cacheDriver) {
            // Attempt to retrieve metadata from cache
        } else {
            // Load metadata for this class
            $this->loadMetadata($className);
            return $this->loadedMetadata[$className];
        }

    }

    /**
     * Loads the metadata of the class in question 
     *
     * @param string $className The name of the class for which the metadata should get loaded.
     * @todo  Determine how to handle parent classes
     * @return array
     */
    protected function loadMetadata($className)
    {
        

        $parentClasses = $this->getParentClasses($className);
        $parentClasses[] = $className;

        foreach ($parentClasses as $className) {
            // if (isset($this->loadedMetadata[$className])) {
            //     $parent = $this->loadedMetadata[$className];
            //     if ($this->isEntity($parent)) {
            //         $rootEntityFound = true;
            //         array_unshift($visited, $className);
            //     }
            //     continue;
            // }

            $metadata = $this->newClassMetadataInstance($className);
            $this->driver->loadMetadataForClass($metadata->getName(), $metadata);


            // $this->initializeReflection($class, $reflService);

            // $this->doLoadMetadata($class, $parent, $rootEntityFound, $visited);

            $this->loadedMetadata[$className] = $metadata;

            // $parent = $class;

            // if ($this->isEntity($class)) {
            //     $rootEntityFound = true;
            //     array_unshift($visited, $className);
            // }

            // $this->wakeupReflection($class, $reflService);

            $loaded[] = $className;
        }
        return $loaded;
    }

    /**
     * Creates a new ClassMetadata instance for the given class name.
     *
     * @param string $className
     * @return Cygnus\DoctrineMagicEmbedBundle\Mapping\ClassMetadata
     */
    protected function newClassMetadataInstance($className)
    {
        return new ClassMetadata($className);
    }

    /**
     * Checks whether the factory has the metadata for a class loaded already.
     *
     * @param string $className
     *
     * @return boolean TRUE if the metadata of the class in question is already loaded, FALSE otherwise.
     */
    public function hasMetadataFor($className)
    {

    }

    /**
     * Sets the metadata descriptor for a specific class.
     *
     * @param string $className
     *
     * @param ClassMetadata $class
     */
    public function setMetadataFor($className, $class)
    {

    }

    /**
     * Gets an array of parent classes for the given entity class.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getParentClasses($className)
    {
        // Collect parent classes, ignoring transient (not-mapped) classes.
        $parentClasses = array();
        foreach (array_reverse($this->getReflectionService()->getParentClasses($className)) as $parentClass) {
            $parentClasses[] = $parentClass;
        }
        return $parentClasses;
    }

    /**
     * Gets the reflection service associated with this metadata factory.
     *
     * @return ReflectionService
     */
    public function getReflectionService()
    {
        if ($this->reflectionService === null) {
            $this->reflectionService = new RuntimeReflectionService();
        }
        return $this->reflectionService;
    }

    /**
     * Returns whether the class with the specified name should have its metadata loaded.
     * This is only the case if it is either mapped directly or as a MappedSuperclass.
     *
     * @param string $className
     *
     * @return boolean
     */
    public function isTransient($className)
    {
        return false;
    }
}
