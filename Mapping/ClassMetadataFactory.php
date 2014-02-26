<?php
namespace Cygnus\DoctrineMagicEmbedBundle\Mapping;

use Cygnus\DoctrineMagicEmbedBundle\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Persistence\Mapping\ClassMetadataFactory as FactoryInterface;

class ClassMetadataFactory implements FactoryInterface
{

    protected $driver;

    private $loadedMetadata = array();

    private $cacheDriver = false;

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
            return $this->loadMetadata($className);
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
        $metadata = $this->newClassMetadataInstance($className);

        return $this->driver->loadMetadataForClass($metadata->getName(), $metadata);
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
