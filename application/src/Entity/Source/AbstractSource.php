<?php

namespace App\Entity\Source;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use App\Entity\AbstractEntity;
use Doctrine\Common\Collections\Collection;
use App\Entity\Meta\RelationInterface;
use App\Entity\Attribut\RelationAttribut;
use App\Entity\Meta\Relation;
use App\Entity\Attribut\LawAttribut;
use App\Entity\Meta\LawInterface;
use App\Entity\Meta\Law;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Attribut\MembershipsAttribut;
use App\Entity\Attribut\SlugAttribut;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Attribut\MembersAttribut;

/**
 * @author kevinfrantz
 *
 * @ORM\Entity
 * @ORM\Table(name="source")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 * "text" = "App\Entity\Source\Primitive\Text\TextSource",
 * "operation"="App\Entity\Source\Operation\AbstractOperation",
 * "user" = "App\Entity\Source\Complex\UserSource",
 * "fullpersonname" = "App\Entity\Source\Complex\FullPersonNameSource",
 * "personidentitysource"="App\Entity\Source\Complex\PersonIdentitySource",
 * "fullpersonnamesource"="App\Entity\Source\Complex\FullPersonNameSource",
 * "member" = "App\Entity\Source\Complex\Collection\TreeCollectionSource",
 * "and" = "App\Entity\Source\Operation\AndOperation",
 * "nickname" = "App\Entity\Source\Primitive\Name\NicknameSource",
 * "firstname" = "App\Entity\Source\Primitive\Name\FirstNameSource",
 * "surname" = "App\Entity\Source\Primitive\Name\SurnameSource"
 * })
 * @UniqueEntity("slug",ignoreNull=true)
 */
abstract class AbstractSource extends AbstractEntity implements SourceInterface
{
    use RelationAttribut,MembershipsAttribut, LawAttribut,SlugAttribut,MembersAttribut;

    /**
     * System slugs should be writen in UPPER CASES
     * Slugs which are defined by the user are checked via the assert.
     *
     * @ORM\Column(type="string",length=30,nullable=true,unique=true)
     * @Assert\Regex(pattern="/^[a-z]+$/")
     *
     * @var string
     */
    protected $slug;

    /**
     * @var RelationInterface
     * @ORM\OneToOne(targetEntity="App\Entity\Meta\Relation",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="relation_id", referencedColumnName="id", onDelete="CASCADE")
     * @Exclude
     */
    protected $relation;

    /**
     * Many Sources have many Source Members.
     *
     * @var Collection|SourceInterface[]
     * @ORM\ManyToMany(targetEntity="AbstractSource", inversedBy="memberships",cascade={"persist"})
     * @ORM\JoinTable(name="source_members",
     *      joinColumns={@ORM\JoinColumn(name="source_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="member_id", referencedColumnName="id")}
     *      )
     */
    protected $members;

    /**
     * @var Collection|SourceInterface[]
     * @ORM\ManyToMany(targetEntity="AbstractSource",mappedBy="members",cascade={"persist"})
     */
    protected $memberships;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Meta\Law",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="law_id", referencedColumnName="id")
     *
     * @var LawInterface
     */
    protected $law;

    public function __construct()
    {
        parent::__construct();
        $this->relation = new Relation();
        $this->relation->setSource($this);
        $this->law = new Law();
        $this->memberships = new ArrayCollection();
        $this->members = new ArrayCollection();
    }
}
