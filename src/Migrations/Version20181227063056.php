<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227063056 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_token CHANGE file file INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file_photos DROP FOREIGN KEY FK_B061C6668C9F3610');
        $this->addSql('DROP INDEX IDX_B061C6668C9F3610 ON file_photos');
        $this->addSql('ALTER TABLE file_photos ADD author INT DEFAULT NULL, DROP file, CHANGE size size VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE file_photos ADD CONSTRAINT FK_B061C666BDAFD8C8 FOREIGN KEY (author) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_B061C666BDAFD8C8 ON file_photos (author)');
        $this->addSql('ALTER TABLE profile CHANGE user user INT DEFAULT NULL, CHANGE city city INT DEFAULT NULL, CHANGE views_count views_count INT DEFAULT NULL, CHANGE date_changed date_changed DATETIME DEFAULT NULL, CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services CHANGE profile profile INT DEFAULT NULL, CHANGE service service INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews CHANGE author author INT DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE vkontakte_id vkontakte_id INT DEFAULT NULL, CHANGE register_code register_code VARCHAR(255) DEFAULT NULL, CHANGE register_date register_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_photos DROP FOREIGN KEY FK_B061C666BDAFD8C8');
        $this->addSql('DROP INDEX IDX_B061C666BDAFD8C8 ON file_photos');
        $this->addSql('ALTER TABLE file_photos ADD file INT DEFAULT NULL, DROP author, CHANGE size size VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE file_photos ADD CONSTRAINT FK_B061C6668C9F3610 FOREIGN KEY (file) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_B061C6668C9F3610 ON file_photos (file)');
        $this->addSql('ALTER TABLE file_token CHANGE file file INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE user user INT DEFAULT NULL, CHANGE city city INT DEFAULT NULL, CHANGE views_count views_count INT DEFAULT NULL, CHANGE date_changed date_changed DATETIME DEFAULT \'NULL\', CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_services CHANGE profile profile INT DEFAULT NULL, CHANGE service service INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE reviews CHANGE author author INT DEFAULT NULL, CHANGE profile profile INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE vkontakte_id vkontakte_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE password password VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_code register_code VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE register_date register_date DATETIME DEFAULT \'NULL\'');
    }
}
