<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181209123939 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("INSERT INTO order_status (code) VALUES ('Ruošiamas'),('Pateiktas'),('Vykdomas'),('Atšauktas'),('Įvykdytas')");
        $this->addSql("INSERT INTO request_status (code) VALUES ('Neperžiūrėtas'),('Peržiūrėtas')");
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("DELETE FROM order_status WHERE code IN ('Ruošiamas', 'Pateiktas', 'Vykdomas', 'Atšauktas', 'Įvykdytas')");
        $this->addSql("DELETE FROM request_status WHERE code IN ('Neperžiūrėtas', 'Peržiūrėtas')");
    }
}
