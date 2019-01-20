<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use App\Attribut\SourceAttribut;
use App\Attribut\IdAttribut;
use App\Entity\Source\Complex\UserSourceInterface;
use App\Entity\Source\Complex\UserSource;
use App\Attribut\VersionAttribut;

/**
 * @author kevinfrantz
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser implements UserInterface
{
    use SourceAttribut,IdAttribut, VersionAttribut;

    /**
     * @var UserSourceInterface
     * @ORM\OneToOne(targetEntity="App\Entity\Source\Complex\UserSource",cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="source_user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $source;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")(strategy="AUTO")
     */
    protected $id;

    /**
     * @version @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $version;

    /**
     * @todo Initialize all needed attributs
     */
    public function __construct()
    {
        parent::__construct();
        $this->version = 0;
        $this->isActive = true;
        $this->source = new UserSource();
        $this->source->setUser($this);
    }
}
