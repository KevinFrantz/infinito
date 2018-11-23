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
use App\Entity\Source\Complex\Collection\TreeCollectionSourceInterface;
use App\Entity\Attribut\SlugAttribut;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author kevinfrantz
 *
 * @ORM\Entity
 * @ORM\Table(name="source")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"primitive" = "App\Entity\Source\Primitive\AbstractPrimitiveSource", "collection" = "App\Entity\Source\Complex\Collection\AbstractCollectionSource","operation"="App\Entity\Source\Operation\AbstractOperation"})
 * @UniqueEntity("slug",ignoreNull=true)
 */
abstract class AbstractSource extends AbstractEntity implements SourceInterface
{
    use RelationAttribut,MembershipsAttribut, LawAttribut,SlugAttribut;

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
     * @todo Implement that just one table on database level is needed!
     * @todo Rename table to use the right schema
     *
     * @var Collection|TreeCollectionSourceInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Source\Complex\Collection\TreeCollectionSource",mappedBy="collection")
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
    }
}
