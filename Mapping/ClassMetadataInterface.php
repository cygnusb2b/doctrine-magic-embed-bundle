<?php
namespace Cygnus\DoctrineMagicEmbedBundle\Mapping;

interface ClassMetadataInterface
{
    /**
     * Gets the fully-qualified class name of this persistent class.
     *
     * @return string
     */
    public function getName();

    /**
     * Gets the ReflectionClass instance for this mapped class.
     *
     * @return \ReflectionClass
     */
    public function getReflectionClass();
}
