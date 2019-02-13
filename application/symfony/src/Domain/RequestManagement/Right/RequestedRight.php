<?php

namespace App\Domain\RequestManagement\Right;

use App\Entity\Source\SourceInterface;
use App\Attribut\CrudAttribut;
use App\Attribut\LayerAttribut;
use App\Attribut\RecieverAttribut;
use App\Exception\PreconditionFailedException;
use App\Domain\RequestManagement\Entity\RequestedEntityInterface;
use App\Attribut\RequestedEntityAttribut;
use App\Entity\Meta\MetaInterface;
use App\Exception\NotCorrectInstanceException;
use App\Domain\RequestManagement\Entity\RequestedEntity;

/**
 * @author kevinfrantz
 *
 * @todo Check out if the performance of this class can be optimized!
 */
class RequestedRight implements RequestedRightInterface
{
    use CrudAttribut, LayerAttribut, RecieverAttribut, RequestedEntityAttribut;

    /**
     * @var SourceInterface
     */
    private $source;

    /**
     * @throws NotCorrectInstanceException
     */
    private function loadSource(): void
    {
        $entity = $this->requestedEntity->getEntity();
        if ($entity instanceof SourceInterface) {
            $this->source = $entity;

            return;
        }
        if ($entity instanceof MetaInterface) {
            $this->source = $entity->getSource();

            return;
        }
        throw new NotCorrectInstanceException('The entity instance '.get_class($entity).' can\'t be processed');
    }

    /**
     * @throws PreconditionFailedException If the source has no id or slug
     */
    private function validateRequestedEntity(): void
    {
        if ($this->requestedEntity->hasSlug() || $this->requestedEntity->hasId()) {
            return;
        }
        throw new PreconditionFailedException(get_class($this->requestedEntity).' needs to have a defined attribut id or slug!');
    }

    /**
     * @param RequestedEntity|null $requestedEntity
     */
    public function __construct(?RequestedEntity $requestedEntity = null)
    {
        if ($requestedEntity) {
            $this->setRequestedEntity($requestedEntity);
        }
    }

    /**
     * Uses some kind of Lazy loading.
     *
     * @see https://en.wikipedia.org/wiki/Lazy_loading
     * {@inheritdoc}
     * @see \App\Domain\RequestManagement\Right\RequestedRightInterface::getSource()
     */
    final public function getSource(): SourceInterface
    {
        $this->validateRequestedEntity();
        $this->loadSource();

        return $this->source;
    }

    /**
     * Overriding is neccessary to declare the correct relation.
     *
     * {@inheritdoc}
     *
     * @see \App\Domain\RequestManagement\Right\RequestedRightInterface::setRequestedEntity()
     */
    final public function setRequestedEntity(RequestedEntityInterface $requestedEntity): void
    {
        $this->requestedEntity = $requestedEntity;
        if (!$requestedEntity->hasRequestedRight()) {
            $this->requestedEntity->setRequestedRight($this);
        }
    }
}
