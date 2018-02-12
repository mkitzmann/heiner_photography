<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180212131259 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo ADD project_id INT DEFAULT NULL, DROP project');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_14B78418166D1F9C ON photo (project_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418166D1F9C');
        $this->addSql('DROP INDEX IDX_14B78418166D1F9C ON photo');
        $this->addSql('ALTER TABLE photo ADD project INT NOT NULL, DROP project_id');
    }
}
