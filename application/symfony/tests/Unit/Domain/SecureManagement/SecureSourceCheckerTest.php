<?php

namespace Tests\Unit\Domain\SecureManagement;

use PHPUnit\Framework\TestCase;
use App\Entity\Source\SourceInterface;
use App\Domain\SecureManagement\SecureSourceCheckerInterface;
use App\Entity\Source\AbstractSource;
use App\Domain\SecureManagement\SecureSourceChecker;
use App\Entity\Meta\Right;
use App\DBAL\Types\Meta\Right\LayerType;
use App\DBAL\Types\Meta\Right\CRUDType;
use App\Attribut\SourceAttribut;
use App\Attribut\SourceAttributInterface;
use App\Exception\SourceAccessDenied;

/**
 * @author kevinfrantz
 */
class SecureSourceCheckerTest extends TestCase
{
    /**
     * @var SourceInterface|SourceAttributInterface
     */
    private $source;

    /**
     * @var SourceInterface
     */
    private $recieverSource;

    /**
     * @var SecureSourceCheckerInterface
     */
    private $securerSourceChecker;

    private function createSourceMock(): SourceInterface
    {
        return new class() extends AbstractSource implements SourceAttributInterface {
            use SourceAttribut;
        };
    }

    public function setUp(): void
    {
        $this->source = $this->createSourceMock();
        $this->recieverSource = $this->createSourceMock();
        $this->securerSourceChecker = new SecureSourceChecker($this->source);
    }

    public function testFirstLevel(): void
    {
        $right = new Right();
        $right->setLayer(LayerType::SOURCE);
        $right->setCrud(CRUDType::UPDATE);
        $right->setReciever($this->recieverSource);
        $right->setSource($this->source);
        $this->source->getLaw()->getRights()->add($right);
        $requestedRight = clone $right;
        $this->assertTrue($this->securerSourceChecker->hasPermission($requestedRight));
        $requestedRight->setCrud(CRUDType::READ);
        $this->assertFalse($this->securerSourceChecker->hasPermission($requestedRight));
    }

    public function testSecondLevel(): void
    {
        $right = new Right();
        $right->setLayer(LayerType::SOURCE);
        $right->setCrud(CRUDType::UPDATE);
        $right->setReciever($this->recieverSource);
        $right->setSource($this->source);
        $this->source->getLaw()->getRights()->add($right);
        $attributSource = $this->createSourceMock();
        $childRight = clone $right;
        $attributSource->getLaw()->getRights()->add($childRight);
        $this->source->setSource($attributSource);
        $requestedRight = clone $right;
        $this->assertTrue($this->securerSourceChecker->hasPermission($requestedRight));
        $childRight->setCrud(CRUDType::READ);
        $this->expectException(SourceAccessDenied::class);
        $this->securerSourceChecker->hasPermission($requestedRight);
    }

    public function testThirdLevel(): void
    {
        $right = new Right();
        $right->setLayer(LayerType::SOURCE);
        $right->setCrud(CRUDType::UPDATE);
        $right->setReciever($this->recieverSource);
        $right->setSource($this->source);
        $this->source->getLaw()->getRights()->add($right);
        $attribut1Source = $this->createSourceMock();
        $attribut1Source->getLaw()->getRights()->add($right);
        $this->source->setSource($attribut1Source);
        $childRight = clone $right;
        $attribut2Source = $this->createSourceMock();
        $attribut2Source->getLaw()->getRights()->add($childRight);
        $attribut1Source->setSource($attribut2Source);
        $requestedRight = clone $right;
        $this->assertTrue($this->securerSourceChecker->hasPermission($requestedRight));
        $childRight->setCrud(CRUDType::READ);
        $this->expectException(SourceAccessDenied::class);
        $this->securerSourceChecker->hasPermission($requestedRight);
    }
}