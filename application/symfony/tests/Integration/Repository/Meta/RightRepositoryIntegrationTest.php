<?php

namespace tests\Integration\Repository\Meta;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Infinito\DBAL\Types\Meta\Right\CRUDType;
use Infinito\DBAL\Types\Meta\Right\LayerType;
use Infinito\Entity\Meta\Law;
use Infinito\Entity\Meta\LawInterface;
use Infinito\Entity\Meta\Right;
use Infinito\Entity\Meta\RightInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @todo specify tests for all attributes
 *
 * @author kevinfrantz
 */
class RightRepositoryIntegrationTest extends KernelTestCase
{
    /**
     * @var int
     */
    const PRIORITY = 123;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $rightRepository;

    /**
     * @var RightInterface
     */
    private $loadedRight;

    /**
     * @var RightInterface
     */
    private $right;

    /**
     * @var LawInterface
     */
    private $law;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->rightRepository = $this->entityManager->getRepository(Right::class);
        $this->right = new Right();
        $this->right->setPriority(self::PRIORITY);
        $this->right->setLayer(LayerType::SOURCE);
        $this->right->setActionType(CRUDType::READ);
        $this->law = new Law();
        $this->entityManager->persist($this->law);
    }

    public function testCreation(): void
    {
        $this->right->setLaw($this->law);
        $this->entityManager->persist($this->right);
        $this->entityManager->flush();
        $rightId = $this->right->getId();
        $this->loadedRight = $this->rightRepository->find($rightId);
        $this->assertEquals($rightId, $this->loadedRight->getId());
        $this->assertEquals(self::PRIORITY, $this->loadedRight->getPriority());
        $this->deleteRight();
        $this->assertNull($this->rightRepository->find($rightId));
        $this->loadedRight = null;
    }

    public function testThatEveryEntityHasAPersistedLaw(): void
    {
        foreach ($this->rightRepository->findAll() as $right) {
            $this->assertInstanceOf(LawInterface::class, $right->getLaw());
            $this->assertGreaterThan(0, $right->getLaw()->getId());
        }
    }

    private function deleteRight(): void
    {
        $this->entityManager->remove($this->loadedRight);
        $this->entityManager->flush();
        $this->entityManager->remove($this->law);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase::tearDown()
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
