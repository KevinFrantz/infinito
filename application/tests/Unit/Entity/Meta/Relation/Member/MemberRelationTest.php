<?php

namespace Tests\Unit\Entity\Meta\Relation\Member;

use PHPUnit\Framework\TestCase;
use App\Entity\Meta\Relation\Member\MemberRelation;
use App\Entity\Meta\Relation\Member\MemberRelationInterface;
use Doctrine\Common\Collections\Collection;

class MemberRelationTest extends TestCase
{
    /**
     * @var MemberRelationInterface
     */
    private $memberRelation;

    public function setUp(): void
    {
        $this->memberRelation = new MemberRelation();
    }

    public function testConstructor(): void
    {
        $this->assertInstanceOf(Collection::class, $this->memberRelation->getMembers());
        $this->assertInstanceOf(Collection::class, $this->memberRelation->getMembership());
    }
}
