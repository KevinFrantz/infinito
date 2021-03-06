<?php

namespace Infinito\Domain\Core;

use FOS\RestBundle\View\View;
use Infinito\Attribut\ActionTypeAttribut;
use Infinito\Domain\Process\ProcessServiceInterface;
use Infinito\Domain\View\ViewServiceInterface;

/**
 * @author kevinfrantz
 *
 * @todo Refactor this class
 * @todo Test this class
 * @todo Rename this class and domain to something like "CoreManagement"
 */
final class CoreService implements CoreServiceInterface
{
    use ActionTypeAttribut;
    /**
     * @var ViewServiceInterface
     */
    private $viewService;

    /**
     * @var ProcessServiceInterface
     */
    private $processService;

    public function __construct(ViewServiceInterface $viewBuilder, ProcessServiceInterface $processService)
    {
        $this->viewService = $viewBuilder;
        $this->processService = $processService;
    }

    /**
     * @todo Optimize the whole following function. It's just implemented like this for test reasons.
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\Core\CoreServiceInterface::process()
     */
    public function process(): View
    {
        $data = $this->processService->process();
        $view = $this->viewService->getView();
        $view->setData($data);

        return $view;
    }
}
