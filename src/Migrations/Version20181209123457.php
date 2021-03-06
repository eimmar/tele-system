<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181209123457 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_info (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, user_id INT DEFAULT NULL, house_number VARCHAR(255) DEFAULT NULL, street VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, INDEX IDX_E376B3A88BAC62AF (city_id), INDEX IDX_E376B3A8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, main_order_id INT NOT NULL, date DATETIME NOT NULL, total_sum DOUBLE PRECISION NOT NULL, used_minutes INT NOT NULL, used_msg INT NOT NULL, used_mbs INT NOT NULL, debt DOUBLE PRECISION NOT NULL, INDEX IDX_9065174454BD7C4D (main_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_request (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, user_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, INDEX IDX_AB1FB5936BF700BD (status_id), INDEX IDX_AB1FB593A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, user_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, total_sum DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, date_created DATETIME NOT NULL, date_modified DATETIME NOT NULL, INDEX IDX_E52FFDEE6BF700BD (status_id), INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_visit (id INT AUTO_INCREMENT NOT NULL, visit_date DATETIME NOT NULL, ip VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, special_price DOUBLE PRECISION DEFAULT NULL, mb_limit INT NOT NULL, msg_limit INT NOT NULL, talk_minute_limit INT NOT NULL, speed_mb INT NOT NULL, is_limited TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_restriction (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, date_created DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, speed_limit_mb INT DEFAULT NULL, date_modified DATETIME NOT NULL, INDEX IDX_B603BD62ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_restriction_city (service_restriction_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_CC4D7722E5705B87 (service_restriction_id), INDEX IDX_CC4D77228BAC62AF (city_id), PRIMARY KEY(service_restriction_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request_status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, birth_date DATETIME DEFAULT NULL, is_individual TINYINT(1) NOT NULL, salary DOUBLE PRECISION NOT NULL, position VARCHAR(255) DEFAULT NULL, work_since_date DATETIME DEFAULT NULL, additional_compensation DOUBLE PRECISION NOT NULL, is_blocked TINYINT(1) NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME NOT NULL, last_visit_date DATETIME NOT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, original_service_id INT NOT NULL, main_order_id INT NOT NULL, date_from DATETIME NOT NULL, date_to DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, service_type VARCHAR(255) DEFAULT NULL, INDEX IDX_52EA1F0980EBDE72 (original_service_id), INDEX IDX_52EA1F0954BD7C4D (main_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_info ADD CONSTRAINT FK_E376B3A88BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE contact_info ADD CONSTRAINT FK_E376B3A8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_9065174454BD7C4D FOREIGN KEY (main_order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE message_request ADD CONSTRAINT FK_AB1FB5936BF700BD FOREIGN KEY (status_id) REFERENCES request_status (id)');
        $this->addSql('ALTER TABLE message_request ADD CONSTRAINT FK_AB1FB593A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_restriction ADD CONSTRAINT FK_B603BD62ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_restriction_city ADD CONSTRAINT FK_CC4D7722E5705B87 FOREIGN KEY (service_restriction_id) REFERENCES service_restriction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_restriction_city ADD CONSTRAINT FK_CC4D77228BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0980EBDE72 FOREIGN KEY (original_service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0954BD7C4D FOREIGN KEY (main_order_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_9065174454BD7C4D');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F0954BD7C4D');
        $this->addSql('ALTER TABLE service_restriction DROP FOREIGN KEY FK_B603BD62ED5CA9E6');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F0980EBDE72');
        $this->addSql('ALTER TABLE service_restriction_city DROP FOREIGN KEY FK_CC4D7722E5705B87');
        $this->addSql('ALTER TABLE contact_info DROP FOREIGN KEY FK_E376B3A88BAC62AF');
        $this->addSql('ALTER TABLE service_restriction_city DROP FOREIGN KEY FK_CC4D77228BAC62AF');
        $this->addSql('ALTER TABLE message_request DROP FOREIGN KEY FK_AB1FB5936BF700BD');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6BF700BD');
        $this->addSql('ALTER TABLE contact_info DROP FOREIGN KEY FK_E376B3A8A76ED395');
        $this->addSql('ALTER TABLE message_request DROP FOREIGN KEY FK_AB1FB593A76ED395');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('DROP TABLE contact_info');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE message_request');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE server_visit');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_restriction');
        $this->addSql('DROP TABLE service_restriction_city');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE request_status');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE order_item');
    }
}
