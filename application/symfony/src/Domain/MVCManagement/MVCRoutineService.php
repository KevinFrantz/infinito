<?php

namespace Infinito\Domain\MVCManagement;

use FOS\RestBundle\View\View;
use Infinito\Attribut\ActionTypeAttribut;
use Infinito\Domain\ViewManagement\ViewBuilderInterface;
use Infinito\Domain\ProcessManagement\ProcessServiceInterface;

/**
 * @author kevinfrantz
 *
 * @todo Refactor this class
 * @todo Test this class
 * @todo Rename this class and domain to something like "CoreManagement"
 */
final class MVCRoutineService implements MVCRoutineServiceInterface
{
    use ActionTypeAttribut;
    /**
     * @var ViewBuilderInterface
     */
    private $viewBuilder;

    /**
     * @var ProcessServiceInterface
     */
    private $processService;

    /**
     * @param ViewBuilderInterface    $viewBuilder
     * @param ProcessServiceInterface $processService
     */
    public function __construct(ViewBuilderInterface $viewBuilder, ProcessServiceInterface $processService)
    {
        $this->viewBuilder = $viewBuilder;
        $this->processService = $processService;
    }

    /**
     * @todo Optimize the whole following function. It's just implemented like this for test reasons.
     * {@inheritdoc}
     *
     * @see \Infinito\Domain\MVCManagement\MVCRoutineServiceInterface::process()
     */
    public function process(): View
    {
        $data = $this->processService->process();
        $view = $this->viewBuilder->getView();
        $view->setData($data);

        return $view;
    }
}
