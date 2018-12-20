<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181220134923 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_token CHANGE file file INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file_photos CHANGE file file INT DEFAULT NULL, CHANGE size size VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE user user INT DEFAULT NULL, CHANGE city city INT DEFAULT NULL, CHANGE views_count views_count INT DEFAULT NULL, CHANGE date_changed date_changed DATETIME DEFAULT NULL, CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services ADD service INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services ADD CONSTRAINT FK_8A5880D88157AA0F FOREIGN KEY (profile) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profile_services ADD CONSTRAINT FK_8A5880D8E19D9AD2 FOREIGN KEY (service) REFERENCES services (id)');
        $this->addSql('CREATE INDEX IDX_8A5880D8E19D9AD2 ON profile_services (service)');
        $this->addSql('ALTER TABLE reviews CHANGE author author INT DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE vkontakte_id vkontakte_id INT DEFAULT NULL, CHANGE register_code register_code VARCHAR(255) DEFAULT NULL, CHANGE register_date register_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_photos CHANGE file file INT DEFAULT NULL, CHANGE size size VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE file_token CHANGE file file INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE user user INT DEFAULT NULL, CHANGE city city INT DEFAULT NULL, CHANGE views_count views_count INT DEFAULT NULL, CHANGE date_changed date_changed DATETIME DEFAULT \'NULL\', CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services DROP FOREIGN KEY FK_8A5880D88157AA0F');
        $this->addSql('ALTER TABLE profile_services DROP FOREIGN KEY FK_8A5880D8E19D9AD2');
        $this->addSql('DROP INDEX IDX_8A5880D8E19D9AD2 ON profile_services');
        $this->addSql('ALTER TABLE profile_services DROP service, DROP active, CHANGE profile profile INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reviews CHANGE author author INT DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE vkontakte_id vkontakte_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE password password VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_code register_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_date register_date DATETIME DEFAULT \'NULL\'');
    }
}
