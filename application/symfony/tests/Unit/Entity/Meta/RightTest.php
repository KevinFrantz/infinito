<?php

namespace tests\unit\Entity;

use PHPUnit\Framework\TestCase;
use App\DBAL\Types\Meta\Right\CRUDType;
use App\Entity\Meta\RightInterface;
use App\Entity\Meta\Right;
use App\Entity\Meta\Law;
use App\DBAL\Types\Meta\Right\LayerType;
use App\Exception\NoValidChoiceException;
use App\Entity\Source\AbstractSource;

/**
 * @todo Implement reciever test
 *
 * @author kevinfrantz
 */
class RightTest extends TestCase
{
    /**
     * @var RightInterface
     */
    private $right;

    public function setUp(): void
    {
        $this->right = new Right();
    }

    public function testConstructorGeneral(): void
    {
        $this->assertTrue($this->right->getGrant());
        $this->assertEquals(0, $this->right->getPriority());
    }

    public function testConstructorReciever(): void
    {
        $this->expectException(\TypeError::class);
        $this->right->getReciever();
    }

    public function testConstructorLayer(): void
    {
        $this->expectException(\TypeError::class);
        $this->assertNull($this->right->getLayer());
    }

    public function testConstructorLaw(): void
    {
        $this->expectException(\TypeError::class);
        $this->assertNull($this->right->getLaw());
    }

    public function testConstructorCondition(): void
    {
        $this->expectException(\TypeError::class);
        $this->right->getCondition();
    }

    public function testConstructorType(): void
    {
        $this->expectException(\TypeError::class);
        $this->assertNull($this->right->getType());
    }

    public function testLaw(): void
    {
        $law = new Law();
        $this->assertNull($this->right->setLaw($law));
        $this->assertEquals($law, $this->right->getLaw());
    }

    public function testRight(): void
    {
        foreach (CRUDType::getChoices() as $key => $value) {
            $this->assertNull($this->right->setType($key));
            $this->assertEquals($key, $this->right->getType());
        }
        $this->expectException(NoValidChoiceException::class);
        $this->right->setType('NoneValidType');
    }

    public function testLayer(): void
    {
        foreach (LayerType::getChoices() as $key => $value) {
            $this->assertNull($this->right->setLayer($key));
            $this->assertEquals($key, $this->right->getLayer());
        }
        $this->expectException(NoValidChoiceException::class);
        $this->right->setLayer('NoneValidLayer');
    }

    /**
     * Just to test if the clone function works like assumed.
     */
    public function testClone(): void
    {
        $source = $this->createMock(AbstractSource::class);
        $reciever = $this->createMock(AbstractSource::class);
        $grant = false;
        $type = CRUDType::READ;
        $layer = LayerType::SOURCE;
        $this->right->setSource($source);
        $this->right->setReciever($reciever);
        $this->right->setGrant($grant);
        $this->right->setType($type);
        $this->right->setLayer($layer);
        $rightClone = clone $this->right;
        $this->assertEquals($source, $rightClone->getSource());
        $this->assertEquals($reciever, $rightClone->getReciever());
        $this->assertEquals($grant, $rightClone->getGrant());
        $this->assertEquals($type, $rightClone->getType());
        $this->assertEquals($layer, $rightClone->getLayer());
    }
}