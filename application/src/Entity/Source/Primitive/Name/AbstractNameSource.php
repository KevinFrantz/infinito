<?php

namespace App\Entity\Source\Primitive\Name;

use App\Entity\Source\Primitive\AbstractPrimitiveSource;
use App\Entity\Attribut\NameAttribut;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author kevinfrantz
 *
 * @todo Change to SINGLE_TABLE. JOINED was necessary because SINGLE_TABLE leaded to:
 *
 * @see << SQLSTATE[42S02]: Base table or view not found: 1146 Table 'DEV_DATABASE.source_data_name' doesn't exist >>
 * @ORM\Entity
 * @ORM\Table(name="source_data_name")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"nickname" = "NicknameSource","firstname" = "FirstNameSource", "surname" = "SurnameSource"})
 */
class AbstractNameSource extends AbstractPrimitiveSource implements NameSourceInterface
{
    use NameAttribut;

    /**
     * @todo Implement an extra assert Layer! - maybe ;)
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $name;

    public function __construct()
    {
        parent::__construct();
    }
}