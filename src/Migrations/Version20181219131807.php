<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181219131807 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file_token (id INT AUTO_INCREMENT NOT NULL, file INT DEFAULT NULL, token VARCHAR(250) NOT NULL, dateCreated DATETIME NOT NULL, type VARCHAR(2) NOT NULL, INDEX IDX_F5B4110C8C9F3610 (file), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_photos (id INT AUTO_INCREMENT NOT NULL, author INT DEFAULT NULL, realFileName VARCHAR(500) NOT NULL, uniqFileName VARCHAR(500) NOT NULL, dateCreated DATETIME NOT NULL, filePath VARCHAR(500) NOT NULL, type VARCHAR(500) NOT NULL, size VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_token ADD CONSTRAINT FK_F5B4110C8C9F3610 FOREIGN KEY (file) REFERENCES file_photos (id)');
        $this->addSql('ALTER TABLE profile CHANGE user user INT DEFAULT NULL, CHANGE views_count views_count INT DEFAULT NULL, CHANGE date_changed date_changed DATETIME DEFAULT NULL, CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews CHANGE author author INT DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE vkontakte_id vkontakte_id INT DEFAULT NULL, CHANGE register_code register_code VARCHAR(255) DEFAULT NULL, CHANGE register_date register_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_token DROP FOREIGN KEY FK_F5B4110C8C9F3610');
        $this->addSql('DROP TABLE file_token');
        $this->addSql('DROP TABLE file_photos');
        $this->addSql('ALTER TABLE profile CHANGE user user INT DEFAULT NULL, CHANGE views_count views_count INT DEFAULT NULL, CHANGE date_changed date_changed DATETIME DEFAULT \'NULL\', CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\', CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews CHANGE author author INT DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE vkontakte_id vkontakte_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE password password VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_code register_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_date register_date DATETIME DEFAULT \'NULL\'');
    }
}
