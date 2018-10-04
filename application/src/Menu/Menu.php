<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Event\Menu\MenuEvent;
use App\DBAL\Types\MenuEventType;

class Menu
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var FactoryInterface
     */
    private $factory;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
    }

    public function SourceNavbar(RequestStack $request): ItemInterface
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'navbar-nav mr-auto',
            ],
        ]);

        $this->dispatcher->dispatch(MenuEventType::SOURCE, new MenuEvent($this->factory, $menu, $request));

        return $menu;
    }

    public function userTopbar(RequestStack $request): ItemInterface
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'navbar-nav mr-auto',
            ],
        ]);

        $this->dispatcher->dispatch(MenuEventType::USER, new MenuEvent($this->factory, $menu, $request));

        return $menu;
    }
}
