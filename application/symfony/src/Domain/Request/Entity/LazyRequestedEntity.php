<?php

namespace Infinito\Domain\Request\Entity;

use Infinito\Attribut\SlugAttributInterface;
use Infinito\Entity\EntityInterface;

/**
 * This class allows to use the RequestedEntity via LazyLoading
 * It reduce the ammount of requests which are send to the database.
 *
 * @author kevinfrantz
 */
class LazyRequestedEntity extends RequestedEntity
{
    /**
     * @var EntityInterface|null Important for lazy loading
     */
    private static $lazyLoadedEntity;

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\Request\Entity\RequestedEntity::loadEntity()
     */
    protected function loadEntity(): ?EntityInterface
    {
        return $this->lazyLoadEntity();
    }

    private function lazyLoadEntity(): ?EntityInterface
    {
        if ($this->isLazyLoadNeccessary()) {
            $entity = parent::loadEntity();
            self::$lazyLoadedEntity = $entity;
        }

        return self::$lazyLoadedEntity;
    }

    private function isLazyLoadNeccessary(): bool
    {
        if (self::$lazyLoadedEntity) {
            if ($this->hasId()) {
                return $this->id !== self::$lazyLoadedEntity->getId();
            }
            if ($this->hasSlug()) {
                if (self::$lazyLoadedEntity instanceof SlugAttributInterface) {
                    return $this->slug !== self::$lazyLoadedEntity->getSlug();
                }
            }
        }

        return true;
    }
}
