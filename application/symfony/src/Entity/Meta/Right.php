<?php

namespace Infinito\Entity\Meta;

use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Infinito\Attribut\ActionTypeAttribut;
use Infinito\Attribut\ConditionAttribut;
use Infinito\Attribut\GrantAttribut;
use Infinito\Attribut\LawAttribut;
use Infinito\Attribut\LayerAttribut;
use Infinito\Attribut\PriorityAttribut;
use Infinito\Attribut\RecieverAttribut;
use Infinito\Entity\Source\SourceInterface;
use Infinito\Logic\Operation\OperationInterface;

/**
 * @author kevinfrantz
 * @ORM\Table(name="meta_right")
 * @ORM\Entity(repositoryClass="Infinito\Repository\Meta\RightRepository")
 */
class Right extends AbstractMeta implements RightInterface
{
    use ActionTypeAttribut;
    use LawAttribut;
    use GrantAttribut;
    use ConditionAttribut;
    use RecieverAttribut;
    use LayerAttribut;
    use PriorityAttribut;

    /**
     * @todo Implement Integrationtests
     * @ORM\ManyToOne(targetEntity="Infinito\Entity\Source\AbstractSource",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id",onDelete="CASCADE")
     *
     * @var SourceInterface The requested source to which the law applies
     */
    protected $source;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int which priority has the right in a roleset
     */
    protected $priority;

    /**
     * @ORM\ManyToOne(targetEntity="Law", inversedBy="rights")
     * @ORM\JoinColumn(name="law_id", referencedColumnName="id",nullable=false)
     *
     * @deprecated it doesn't make sense to reference to the law, because the routing is allready possible over the source
     *
     * @var LawInterface
     */
    protected $law;

    /**
     * @ORM\Column(name="layer", type="LayerType", nullable=false)
     * @DoctrineAssert\Enum(entity="Infinito\DBAL\Types\Meta\Right\LayerType")
     *
     * @var string
     */
    protected $layer;

    /**
     * @todo Implement Integrationtests
     * @todo implement it on an correct way!
     * @ORM\ManyToOne(targetEntity="Infinito\Entity\Source\AbstractSource",cascade={"persist"})
     * @ORM\JoinColumn(name="reciever_id", referencedColumnName="id",onDelete="CASCADE",nullable=true)
     *
     * @var SourceInterface|null if null then the right should apply to all sources
     */
    protected $reciever;

    /**
     * @ORM\Column(type="boolean",name="`grant`")
     *
     * @var bool
     */
    protected $grant;

    /**
     * @ORM\Column(name="action", type="ActionType", nullable=false)
     * @DoctrineAssert\Enum(entity="Infinito\DBAL\Types\ActionType")
     *
     * @var string
     */
    protected $actionType;

    /**
     * @ORM\OneToOne(targetEntity="Infinito\Entity\Source\Operation\AbstractOperation",cascade={"persist"})
     * @ORM\JoinColumn(name="operation_id", referencedColumnName="id",nullable=true)
     *
     * @var OperationInterface
     */
    protected $condition;

    public function __construct()
    {
        parent::__construct();
        $this->grant = true;
        $this->priority = 0;
    }
}
