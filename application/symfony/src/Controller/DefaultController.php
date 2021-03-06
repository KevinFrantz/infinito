<?php

namespace Infinito\Controller;

use Infinito\DBAL\Types\Meta\Right\LayerType;
use Infinito\DBAL\Types\RESTResponseType;
use Infinito\Domain\Fixture\FixtureSource\HomepageFixtureSource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This controller offers the standart routes for the template.
 *
 * @author kevinfrantz
 */
final class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(): Response
    {
        return $this->redirectToRoute('infinito_api_rest_layer_read', [
            'identity' => HomepageFixtureSource::getSlug(),
            'layer' => LayerType::SOURCE,
            '_format' => RESTResponseType::HTML,
        ]);
    }
}
