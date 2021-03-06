<?php

namespace Infinito\Domain\Request\Entity;

use Infinito\Attribut\ClassAttribut;
use Infinito\Attribut\RequestedRightAttribut;
use Infinito\Attribut\SlugAttribut;
use Infinito\Domain\Repository\LayerRepositoryFactoryService;
use Infinito\Domain\Repository\LayerRepositoryFactoryServiceInterface;
use Infinito\Domain\Request\Right\RequestedRightInterface;
use Infinito\Entity\AbstractEntity;
use Infinito\Entity\EntityInterface;
use Infinito\Entity\Source\AbstractSource;
use Infinito\Entity\Source\SourceInterface;
use Infinito\Exception\Attribut\AllreadyDefinedAttributException;
use Infinito\Exception\Attribut\UndefinedAttributException;
use Infinito\Exception\Core\NoIdentityCoreException;
use Infinito\Exception\Core\NotCorrectInstanceCoreException;
use Infinito\Exception\NotFound\EntityNotFoundException;
use Infinito\Repository\RepositoryInterface;
use Infinito\Repository\Source\SourceRepositoryInterface;

/**
 * @author kevinfrantz
 *
 * @todo Move lazy load to an own child class
 */
class RequestedEntity extends AbstractEntity implements RequestedEntityInterface
{
    use SlugAttribut,
    RequestedRightAttribut,
    ClassAttribut{ setClass as private setClassTrait; getClass as private getClassTrait; }

    /**
     * BE AWARE:
     * This attribut can lead to sideeffects, because it can be defined, or NULL.
     *
     * @var LayerRepositoryFactoryServiceInterface|null
     */
    private $layerRepositoryFactoryService;

    /**
     * @throws UndefinedAttributException
     */
    private function validateHasIdentity(): void
    {
        if ($this->hasId() || $this->hasSlug()) {
            return;
        }
        throw new NoIdentityCoreException('No identity attribut like id or slug was set!');
    }

    /**
     * @param EntityInterface $entity
     *
     * @throws EntityNotFoundException
     */
    private function validateLoadedEntity(?EntityInterface $entity): void
    {
        if ($entity) {
            return;
        }
        throw new EntityNotFoundException('Entity with {id:"'.$this->id.'",slug:"'.$this->slug.'"} not found');
    }

    /**
     * @return EntityInterface|SourceInterface|null
     */
    private function loadEntityBySlugOrId(): ?EntityInterface
    {
        if ($this->hasSlug()) {
            return $this->loadBySlug();
        }

        return $this->loadById();
    }

    private function loadBySlug(): ?SourceInterface
    {
        $repository = $this->getEntityRepository();
        if ($repository instanceof SourceRepositoryInterface) {
            return $repository->findOneBySlug($this->slug);
        }
        throw new NotCorrectInstanceCoreException('To read an entity by slug is just allowed for entitys of type '.AbstractSource::class);
    }

    private function loadById(): ?EntityInterface
    {
        $repository = $this->getEntityRepository();

        return $repository->find($this->id);
    }

    /**
     * @throws UndefinedAttributException
     */
    private function validateLayerRepositoryFactoryService(): void
    {
        if (!$this->layerRepositoryFactoryService) {
            throw new UndefinedAttributException('The operation is not possible, because the class '.LayerRepositoryFactoryService::class.' is not injected!');
        }
    }

    private function getEntityRepository(): RepositoryInterface
    {
        $this->validateLayerRepositoryFactoryService();
        $layer = $this->requestedRight->getLayer();
        $repository = $this->layerRepositoryFactoryService->getRepository($layer);

        return $repository;
    }

    protected function loadEntity(): ?EntityInterface
    {
        return $this->loadEntityBySlugOrId();
    }

    public function __construct(?LayerRepositoryFactoryServiceInterface $layerRepositoryFactoryService = null)
    {
        $this->layerRepositoryFactoryService = $layerRepositoryFactoryService;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\Request\Entity\RequestedEntityInterface::hasIdentity()
     */
    public function hasIdentity(): bool
    {
        return $this->hasId() || $this->hasSlug();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\Request\Entity\RequestedEntityInterface::setIdentity()
     */
    public function setIdentity($identity): void
    {
        if ($this->hasClass()) {
            throw new AllreadyDefinedAttributException('A identity can\'t be set if a class is allready defined!');
        }
        if (is_numeric($identity)) {
            $this->setId($identity);
            $this->slug = null;

            return;
        }
        $this->setSlug($identity);
        $this->id = null;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Attribut\ClassAttributInterface::setClass()
     */
    public function setClass(string $class): void
    {
        if ($this->hasIdentity()) {
            throw new AllreadyDefinedAttributException('A class can\'t be manual defined, if an identity is allready set!');
        }
        $this->setClassTrait($class);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\Request\Entity\RequestedEntityInterface::getEntity()
     */
    final public function getEntity(): EntityInterface
    {
        $this->validateHasIdentity();
        $entity = $this->loadEntity();
        $this->validateLoadedEntity($entity);

        return $entity;
    }

    /**
     * Overriding is neccessary to declare the correct relation.
     *
     * {@inheritdoc}
     *
     * @see \Infinito\Attribut\RequestedRightAttributInterface::setRequestedRight()
     */
    public function setRequestedRight(RequestedRightInterface $requestedRight): void
    {
        $this->requestedRight = $requestedRight;
        if (!$this->requestedRight->hasRequestedEntity()) {
            $this->requestedRight->setRequestedEntity($this);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Attribut\ClassAttributInterface::getClass()
     */
    public function getClass(): string
    {
        if ($this->hasClass()) {
            return $this->getClassTrait();
        }

        return get_class($this->getEntity());
    }
}
