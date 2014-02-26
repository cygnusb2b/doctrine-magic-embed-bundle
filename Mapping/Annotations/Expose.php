<?php
namespace Cygnus\DoctrineMagicEmbedBundle\Mapping\Annotations;

use Doctrine\Common\Annotations\Annotation;

/** @Annotation */
final class Expose extends Annotation
{
    public $expose = true;
}
