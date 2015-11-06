<?php

namespace Benoth\StaticReflection\Reflection;

abstract class Reflection implements \Reflector
{
    const IS_STATIC            = 1;
    const IS_ABSTRACT          = 2;
    const IS_FINAL             = 4;
    const IS_IMPLICIT_ABSTRACT = 16;
    const IS_EXPLICIT_ABSTRACT = 32;
    const IS_PUBLIC            = 256;
    const IS_PROTECTED         = 512;
    const IS_PRIVATE           = 1024;
    const IS_DEPRECATED        = 262144;

    /**
     * @type string
     */
    protected $name;

    /**
     * @type string
     */
    protected $fileName;

    /**
     * @type int
     */
    protected $startLine;

    /**
     * @type int
     */
    protected $endLine;

    /**
     * Constructs a new Reflection object.
     *
     * @param string $name The fully qualified name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the fully qualified entity name (with the namespace).
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the short name of the entity (without the namespace).
     *
     * @return string
     */
    public function getShortName()
    {
        $parts = explode('\\', $this->name);

        return end($parts);
    }

    /**
     * Gets the namespace name.
     *
     * @return string
     */
    public function getNamespaceName()
    {
        $parts = explode('\\', $this->name);
        array_pop($parts);

        return implode('\\', $parts);
    }

    /**
     * Checks if this entity is defined in a namespace.
     *
     * @return bool
     */
    public function inNamespace()
    {
        return strlen($this->getNamespaceName()) > 0;
    }

    /**
     * Gets the filename of the file in which the class has been defined.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Get the starting line number.
     *
     * @return int
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * Get the ending line number.
     *
     * @return int
     */
    public function getEndLine()
    {
        return $this->endLine;
    }

    /**
     * Gets a ReflectionExtension object for the extension which defined the entity.
     *
     * @return \ReflectionExtension|null Null for user defined
     */
    public function getExtension()
    {
        return;
    }

    /**
     * Gets the name of the extension which defined the entity.
     *
     * @return string|bool Extension name or false for user defined
     */
    public function getExtensionName()
    {
        return false;
    }

    /**
     * Returns a bitfield of the access modifiers for this class.
     *
     * @return int Bitmask of modifier constants
     */
    public function getModifiers()
    {
        $modifiers = 0;

        if (method_exists($this, 'isStatic') && $this->isStatic()) {
            $modifiers |= static::IS_STATIC;
        }
        if (method_exists($this, 'isAbstract') && $this->isAbstract()) {
            $modifiers |= static::IS_ABSTRACT;
        }
        if (method_exists($this, 'isFinal') && $this->isFinal()) {
            $modifiers |= static::IS_FINAL;
        }

        if (method_exists($this, 'isPublic') && $this->isPublic()) {
            $modifiers |= static::IS_PUBLIC;
        } elseif (method_exists($this, 'isProtected') && $this->isProtected()) {
            $modifiers |= static::IS_PROTECTED;
        } elseif (method_exists($this, 'isPrivate') && $this->isPrivate()) {
            $modifiers |= static::IS_PRIVATE;
        }

        return $modifiers;
    }

    /**
     * Returns the string representation of the Reflection object.
     *
     * @return string
     */
    public function __toString()
    {
        return static::export($this, true);
    }

    /**
     * Exports a reflected class.
     *
     * @param \Reflector $argument The reflection to export.
     * @param bool       $return   Setting to true will return the export, otherwise will emitt it.
     *
     * @return string|void
     */
    public static function export(\Reflector $argument, $return = false)
    {
        // @todo Implement export()
        // @see https://github.com/Roave/BetterReflection/blob/f8adf4865fa635166cf91a544882deab0cf5b7e6/src/Reflection/ReflectionClass.php#L96
        throw new \ReflectionException('Not implemented yet');
    }

    /**
     * Gets modifiers names.
     *
     * @param int $modifiers
     *
     * @return array An array of modifier names
     */
    public static function getModifierNames($modifiers)
    {
        $isAbstract         = ($modifiers & static::IS_ABSTRACT) === static::IS_ABSTRACT;
        $isFinal            = ($modifiers & static::IS_FINAL) === static::IS_FINAL;
        $isStatic           = ($modifiers & static::IS_STATIC) === static::IS_STATIC;
        $isExplicitAbstract = ($modifiers & static::IS_EXPLICIT_ABSTRACT) === static::IS_EXPLICIT_ABSTRACT;
        $isPublic           = ($modifiers & static::IS_PUBLIC) === static::IS_PUBLIC;
        $isProtected        = ($modifiers & static::IS_PROTECTED) === static::IS_PROTECTED;
        $isPrivate          = ($modifiers & static::IS_PRIVATE) === static::IS_PRIVATE;

        $returns = [];
        if ($isAbstract) {
            $returns[] = 'abstract';
        }
        if ($isFinal) {
            $returns[] = 'final';
        }
        if ($isStatic) {
            $returns[] = 'static';
        }
        if ($isExplicitAbstract) {
            $returns[] = 'abstract';
        }
        if ($isPublic && !$isProtected && !$isPrivate) {
            $returns[] = 'public';
        }
        if (!$isPublic && $isProtected && !$isPrivate) {
            $returns[] = 'protected';
        }
        if (!$isPublic && !$isProtected && $isPrivate) {
            $returns[] = 'private';
        }

        return array_unique($returns);
    }

    /**
     * Sets the filename of the file in which the class has been defined.
     *
     * @internal
     *
     * @param string $fileName
     *
     * @return self
     */
    public function setFilename($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Set the starting line number.
     *
     * @internal
     *
     * @param int $startLine
     *
     * @return self
     */
    public function setStartLine($startLine)
    {
        $this->startLine = $startLine;

        return $this;
    }

    /**
     * Set the starting line number.
     *
     * @internal
     *
     * @param int $endLine
     *
     * @return self
     */
    public function setEndLine($endLine)
    {
        $this->endLine = $endLine;

        return $this;
    }
}
