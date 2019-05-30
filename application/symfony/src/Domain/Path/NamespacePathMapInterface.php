<?php

namespace Infinito\Domain\Path;

/**
 * Allows to map a path to an namespace.
 *
 * @author kevinfrantz
 */
interface NamespacePathMapInterface
{
    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace): void;

    /**
     * @param string $path
     */
    public function setPath(string $path): void;

    /**
     * @return string
     */
    public function getNamespace(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param array|string[] $folders
     */
    public function setFolders(array $folders): void;

    /**
     * @return array|string[]
     */
    public function getFolders(): array;
}