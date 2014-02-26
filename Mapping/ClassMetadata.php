<?php
namespace Cygnus\DoctrineMagicEmbedBundle\Mapping;

class ClassMetadata implements ClassMetadataInterface
{
    /**
     * READ-ONLY: The name of the class.
     */
    public $name;

    /**
     * READ-ONLY: The namespace the document class is contained in.
     *
     * @var string
     * @todo Not really needed. Usage could be localized.
     */
    public $namespace;

    /**
     * The ReflectionClass instance of the mapped class.
     *
     * @var \ReflectionClass
     */
    public $reflClass;

    /**
     * The ReflectionProperty instances of the mapped class.
     *
     * @var \ReflectionProperty[]
     */
    public $reflFields = array();

    /**
     * The prototype from which new instances of the mapped class are created.
     *
     * @var object
     */
    private $prototype;

    /**
     * Initializes a new ClassMetadata instance that will hold the object-document mapping
     * metadata of the class with the given name.
     *
     * @param string $className The name of the class the new instance is used for.
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->reflClass = new \ReflectionClass($name);
        $this->namespace = $this->reflClass->getNamespaceName();
    }

    /**
     * Gets the fully-qualified class name for this mapped class.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setExposedField(array $mapping)
    {
        if ($this->reflClass->hasProperty($mapping['fieldName'])) {
            $reflProp = $this->reflClass->getProperty($mapping['fieldName']);
            $reflProp->setAccessible(true);
            $this->reflFields[$mapping['fieldName']] = $reflProp;
        }
    }

    /**
     * Gets the namespace for this mapped class.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Gets the ReflectionClass instance of the mapped class.
     *
     * @return \ReflectionClass
     */
    public function getReflectionClass()
    {
        if (!$this->reflClass) {
            $this->reflClass = new \ReflectionClass($this->getName());
        }
        return $this->reflClass;
    }
}
