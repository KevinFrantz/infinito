<?php

namespace tests\unit\Entity;

use Infinito\Entity\AbstractEntity;
use Infinito\Entity\EntityInterface;
use PHPUnit\Framework\TestCase;

class AbstractEntityTest extends TestCase
{
    /**
     * @var EntityInterface
     */
    protected $entity;

    public function setUp(): void
    {
        $this->entity = new class() extends AbstractEntity {
        };
    }

    public function testConstructor(): void
    {
        $this->assertEquals(0, $this->entity->getVersion());
        $this->assertNull($this->entity->getId());
    }

    public function testVersion(): void
    {
        $version = 123;
        $this->assertNull($this->entity->setVersion($version));
        $this->assertEquals($version, $this->entity->getVersion());
    }

    public function testId(): void
    {
        $id = 123;
        $this->assertNull($this->entity->setId($id));
        $this->assertEquals($id, $this->entity->getId());
    }
}
