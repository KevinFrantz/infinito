<?php

namespace App\Domain\SecureManagement;

use App\Domain\RequestManagement\Right\RequestedRightInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\RightManagement\RightTransformerServiceInterface;

/**
 * @author kevinfrantz
 */
final class SecureEntityChecker implements SecureEntityCheckerInterface
{
    /**
     * @var RightTransformerServiceInterface
     */
    private $rightTransformerService;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RightTransformerServiceInterface $rightTransformerService)
    {
        $this->rightTransformerService = $rightTransformerService;
    }

    public function check(RequestedRightInterface $requestedRight): bool
    {
        $source = $requestedRight->getSource();
        $secureSourceChecker = new SecureSourceChecker($source);
        $transformedRequestedRight = $this->rightTransformerService->transform($requestedRight);

        return $secureSourceChecker->hasPermission($transformedRequestedRight);
    }
}
