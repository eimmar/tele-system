<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181023141720 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_restriction_city (service_restriction_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_CC4D7722E5705B87 (service_restriction_id), INDEX IDX_CC4D77228BAC62AF (city_id), PRIMARY KEY(service_restriction_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_restriction_city ADD CONSTRAINT FK_CC4D7722E5705B87 FOREIGN KEY (service_restriction_id) REFERENCES service_restriction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_restriction_city ADD CONSTRAINT FK_CC4D77228BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234E5705B87');
        $this->addSql('DROP INDEX IDX_2D5B0234E5705B87 ON city');
        $this->addSql('ALTER TABLE city DROP service_restriction_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE service_restriction_city');
        $this->addSql('ALTER TABLE city ADD service_restriction_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234E5705B87 FOREIGN KEY (service_restriction_id) REFERENCES service_restriction (id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234E5705B87 ON city (service_restriction_id)');
    }
}
