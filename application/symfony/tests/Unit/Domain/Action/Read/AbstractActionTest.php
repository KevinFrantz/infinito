<?php

namespace tests\Unit\Domain\Action\Read;

use Infinito\Domain\Action\AbstractAction;
use Infinito\Domain\Action\ActionDependenciesDAOServiceInterface;
use Infinito\Domain\Action\ActionInterface;
use Infinito\Exception\Validation\FormInvalidException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author kevinfrantz
 */
class AbstractActionTest extends TestCase
{
    /**
     * @var ActionInterface
     */
    private $action;

    /**
     * @var ActionDependenciesDAOServiceInterface|MockObject
     */
    private $actionService;

    public function setUp(): void
    {
        $this->actionService = $this->createMock(ActionDependenciesDAOServiceInterface::class);
        $this->action = new class($this->actionService) extends AbstractAction {
            public $isSecure;
            public $validByForm;

            protected function isSecure(): bool
            {
                return $this->isSecure;
            }

            protected function isValid(): bool
            {
                return $this->validByForm;
            }

            protected function proccess()
            {
            }
        };
    }

    public function testNotValidByFormException(): void
    {
        $this->action->isSecure = true;
        $this->action->validByForm = false;
        $this->expectException(FormInvalidException::class);
        $this->action->execute();
    }
}
