<?php declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Cities;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220065112 extends AbstractMigration implements ContainerAwareInterface
{

    /**@var ContainerInterface $container*/
    private $container = null;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function up(Schema $schema)
    {

        /**@var EntityManager $em*/
        $em = $this->container->get("doctrine.orm.entity_manager");

        $cs = new Cities();
        $cs->setCity("Минск");
        $em->persist($cs);
        $em->flush();

    }


    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
