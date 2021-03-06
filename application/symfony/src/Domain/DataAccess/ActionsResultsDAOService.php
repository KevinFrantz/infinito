<?php

namespace Infinito\Domain\DataAccess;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Infinito\DBAL\Types\ActionType;
use Infinito\Entity\EntityInterface;
use Infinito\Exception\Collection\ContainsElementException;
use Infinito\Exception\Collection\NotSetElementException;
use Infinito\Exception\Type\InvalidChoiceTypeException;
use Infinito\Exception\Validation\ValueInvalidException;
use Infinito\Logic\Result\ResultInterface;
use Symfony\Component\Intl\Exception\NotImplementedException;

/**
 * @author kevinfrantz
 */
final class ActionsResultsDAOService extends AbstractActionsDAO implements ActionsResultsDAOServiceInterface
{
    /**
     * @var Collection|mixed[]
     */
    private $processedData;

    /**
     * @param EntityInterface|ResultInterface|null $data
     *
     * @return bool True if the data is valid
     */
    private function isValidActionData(string $actionType, $data): bool
    {
        switch ($actionType) {
            case ActionType::CREATE:
                return $data instanceof EntityInterface | null === $data;
            case ActionType::READ:
            case ActionType::UPDATE:
                return $data instanceof EntityInterface;
            case ActionType::DELETE:
                return null === $data;
            case ActionType::EXECUTE:
                return $data instanceof ResultInterface;
        }
        throw new NotImplementedException("The ActionType <<$actionType>> is not implemented in <<".__CLASS__.':'.__FUNCTION__.'>>');
    }

    /**
     * @throws InvalidChoiceTypeException
     */
    private function throwNoValidActionTypeException(string $actionType): void
    {
        throw new InvalidChoiceTypeException("The action type <<$actionType>> is not defined and not valid!");
    }

    private function isValidActionType(string $actionType): bool
    {
        return in_array($actionType, ActionType::getValues());
    }

    private function validateActionType(string $actionType): void
    {
        if (!$this->isValidActionType($actionType)) {
            $this->throwNoValidActionTypeException($actionType);
        }
    }

    /**
     * This function describes which data is expected.
     *
     * @param mixed $data
     *
     * @throws ValueInvalidException For false a exception is thrown
     */
    private function validateActionData(string $actionType, $data): void
    {
        if (!$this->isValidActionData($actionType, $data)) {
            throw new ValueInvalidException('Data <<'.gettype($data).(is_object($data) ? ':'.get_class($data) : '').">> is not valid for action type <<$actionType>>!");
        }
    }

    /**
     * @throws ContainsElementException
     */
    private function validateNotSet(string $actionType): void
    {
        if ($this->isDataStored($actionType)) {
            throw new ContainsElementException("Data for <<$actionType>> is allready stored.");
        }
    }

    /**
     * @throws NotSetElementException
     */
    private function validateSet(string $actionType): void
    {
        if (!$this->isDataStored($actionType)) {
            throw new NotSetElementException("No data for <<$actionType>> is stored.");
        }
    }

    public function __construct()
    {
        $this->processedData = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\DataAccess\ActionsDAOInterface::getAllStoredData()
     */
    public function getAllStoredData(): Collection
    {
        return $this->processedData;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\DataAccess\ActionsResultsDAOServiceInterface::setData()
     */
    public function setData(string $actionType, $data): void
    {
        $this->validateActionType($actionType);
        $this->validateActionData($actionType, $data);
        $this->validateNotSet($actionType);
        $this->processedData->set($actionType, $data);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\DataAccess\ActionsDAOInterface::isDataStored()
     */
    public function isDataStored(string $actionType): bool
    {
        return $this->processedData->containsKey($actionType);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\DataAccess\ActionsDAOInterface::getData()
     */
    public function getData(string $actionType)
    {
        $this->validateActionType($actionType);
        $this->validateSet($actionType);

        return $this->processedData->get($actionType);
    }
}
