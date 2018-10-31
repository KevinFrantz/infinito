<?php

namespace App\Entity\Meta;

use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class LawTest extends TestCase
{
    /**
     * @var LawInterface
     */
    protected $law;

    public function setUp(): void
    {
        $this->law = new Law();
    }

    public function testConstruct(): void
    {
        $this->assertInstanceOf(Collection::class, $this->law->getRights());
    }

    public function testRights(): void
    {
        $right = new Right();
        $rights = new ArrayCollection([$right, new Right(), new Right()]);
        $this->assertNull($this->law->setRights($rights));
        $this->assertEquals($right, $this->law->getRights()->get(0));
    }
}
