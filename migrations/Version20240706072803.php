<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706072803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clocking_project (id INT AUTO_INCREMENT NOT NULL, duration INT DEFAULT NULL, clocking_id INT DEFAULT NULL, project_id INT DEFAULT NULL, INDEX IDX_29254587B6D103F (clocking_id), INDEX IDX_29254587166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587B6D103F FOREIGN KEY (clocking_id) REFERENCES clocking (id)');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('DROP INDEX IDX_D3E9DCCD4431A71B ON clocking');
        $this->addSql('ALTER TABLE clocking DROP clocking_project_id');
        $this->addSql('ALTER TABLE clocking ADD CONSTRAINT FK_D3E9DCCDA1F846FC FOREIGN KEY (clocking_user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587B6D103F');
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587166D1F9C');
        $this->addSql('DROP TABLE clocking_project');
        $this->addSql('ALTER TABLE clocking DROP FOREIGN KEY FK_D3E9DCCDA1F846FC');
        $this->addSql('ALTER TABLE clocking ADD clocking_project_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_D3E9DCCD4431A71B ON clocking (clocking_project_id)');
    }
}