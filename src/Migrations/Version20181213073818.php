<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181213073818 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, author INT DEFAULT NULL, profile INT DEFAULT NULL, text LONGTEXT NOT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_6970EB0FBDAFD8C8 (author), UNIQUE INDEX UNIQ_6970EB0F8157AA0F (profile), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FBDAFD8C8 FOREIGN KEY (author) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F8157AA0F FOREIGN KEY (profile) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profile ADD views_count INT DEFAULT NULL, ADD date_changed DATETIME NOT NULL, ADD type INT DEFAULT NULL, ADD address VARCHAR(255) NOT NULL, ADD avatar VARCHAR(255) NOT NULL, CHANGE user user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD $registerDate DATETIME DEFAULT NULL, DROP registerDate, CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE register_code register_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE reviews');
        $this->addSql('ALTER TABLE profile DROP views_count, DROP date_changed, DROP type, DROP address, DROP avatar, CHANGE user user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD registerDate DATETIME DEFAULT \'NULL\', DROP $registerDate, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE password password VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_code register_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
