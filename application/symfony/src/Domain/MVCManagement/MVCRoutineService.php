<?php

namespace App\Domain\MVCManagement;

use FOS\RestBundle\View\View;
use App\Entity\EntityInterface;
use App\Domain\ActionManagement\ActionHandlerServiceInterface;
use App\Domain\TemplateManagement\TemplateNameServiceInterface;

/**
 * @author kevinfrantz
 */
final class MVCRoutineService implements MVCRoutineServiceInterface
{
    /**
     * @var ActionHandlerServiceInterface
     */
    private $actionHandlerService;

    /**
     * @var TemplateNameServiceInterface
     */
    private $templateNameService;

    /**
     * @param EntityInterface[]|EntityInterface|null $result
     *
     * @return array Well formated data for view
     */
    private function getViewData($result): array
    {
        switch (gettype($result)) {
            case 'object':
                return ['entity' => $this->result];
            case 'array':
                return ['enitits' => $this->result];
            case 'null':
                return [];
        }
    }

    /**
     * @param ActionHandlerServiceInterface $actionHandlerService
     */
    public function __construct(ActionHandlerServiceInterface $actionHandlerService, TemplateNameServiceInterface $templateNameService)
    {
        $this->actionHandlerService = $actionHandlerService;
        $this->templateNameService = $templateNameService;
    }

    /**
     * {@inheritdoc}
     *
     * @see \App\Domain\MVCManagement\MVCRoutineServiceInterface::process()
     */
    public function process(): View
    {
        $result = $this->actionHandlerService->handle();
        $data = $this->getViewData($result);
        $view = $this->getView($data);

        return $view;
    }

    /**
     * {@inheritdoc}
     *
     * @see \App\Domain\MVCManagement\MVCRoutineServiceInterface::getView()
     */
    public function getView(array $data): View
    {
        $view = View::create();
        $view->setTemplate($this->templateNameService->getMoleculeTemplateName());
        $view->setData($data);

        return $view;
    }
}