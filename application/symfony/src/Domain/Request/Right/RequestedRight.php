<?php

namespace Infinito\Domain\Request\Right;

use Infinito\Attribut\ActionTypeAttribut;
use Infinito\Attribut\LayerAttribut;
use Infinito\Attribut\RecieverAttribut;
use Infinito\Attribut\RequestedEntityAttribut;
use Infinito\Domain\Request\Entity\RequestedEntity;
use Infinito\Domain\Request\Entity\RequestedEntityInterface;
use Infinito\Entity\Meta\MetaInterface;
use Infinito\Entity\Source\SourceInterface;
use Infinito\Exception\Collection\ContainsElementException;
use Infinito\Exception\Core\NoIdentityCoreException;
use Infinito\Exception\Core\NotCorrectInstanceCoreException;

/**
 * @author kevinfrantz
 *
 * @todo Check out if the performance of this class can be optimized!
 */
class RequestedRight implements RequestedRightInterface
{
    use LayerAttribut, RecieverAttribut, RequestedEntityAttribut, ActionTypeAttribut{
        setActionType as private setActionTypeTrait;
    }

    /**
     * @var SourceInterface
     */
    private $source;

    /**
     * @throws NotCorrectInstanceCoreException
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
        throw new NotCorrectInstanceCoreException('The entity instance '.get_class($entity).' can\'t be processed');
    }

    /**
     * @throws NoIdentityCoreException If the source has no id or slug
     */
    private function validateRequestedEntity(): void
    {
        if ($this->requestedEntity->hasIdentity()) {
            return;
        }
        throw new NoIdentityCoreException(get_class($this->requestedEntity).' needs to have a defined id or slug attribut!');
    }

    public function __construct(?RequestedEntity $requestedEntity = null)
    {
        if ($requestedEntity) {
            $this->setRequestedEntity($requestedEntity);
        }
    }

    /**
     * This function declares the attribute actionType as inmutable
     * {@inheritdoc}
     *
     * @see \Infinito\Attribut\ActionTypeAttributInterface::setActionType()
     */
    public function setActionType(string $actionType): void
    {
        if (isset($this->actionType)) {
            throw new ContainsElementException("The action type is allready set! Origine: $this->actionType New: $actionType");
        }
        $this->setActionTypeTrait($actionType);
    }

    /**
     * Uses some kind of Lazy loading.
     *
     * @see https://en.wikipedia.org/wiki/Lazy_loading
     * {@inheritdoc}
     * @see \Infinito\Domain\Request\Right\RequestedRightInterface::getSource()
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
     * @see \Infinito\Domain\Request\Right\RequestedRightInterface::setRequestedEntity()
     */
    final public function setRequestedEntity(RequestedEntityInterface $requestedEntity): void
    {
        $this->requestedEntity = $requestedEntity;
        if (!$requestedEntity->hasRequestedRight()) {
            $this->requestedEntity->setRequestedRight($this);
        }
    }
}
