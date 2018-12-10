<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181210173446 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city CHANGE name name VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE message_request ADD receiver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_request ADD CONSTRAINT FK_AB1FB593CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AB1FB593CD53EDB6 ON message_request (receiver_id)');
        $this->addSql('ALTER TABLE contact_info CHANGE house_number house_number VARCHAR(64) DEFAULT NULL, CHANGE postal_code postal_code VARCHAR(64) NOT NULL, CHANGE phone_number phone_number VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(64) NOT NULL, CHANGE last_name last_name VARCHAR(128) DEFAULT NULL, CHANGE gender gender VARCHAR(64) DEFAULT NULL, CHANGE position position VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE server_visit CHANGE ip ip VARCHAR(64) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city CHANGE name name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE contact_info CHANGE house_number house_number VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE postal_code postal_code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE phone_number phone_number VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE message_request DROP FOREIGN KEY FK_AB1FB593CD53EDB6');
        $this->addSql('DROP INDEX IDX_AB1FB593CD53EDB6 ON message_request');
        $this->addSql('ALTER TABLE message_request DROP receiver_id');
        $this->addSql('ALTER TABLE server_visit CHANGE ip ip VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE gender gender VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE position position VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
