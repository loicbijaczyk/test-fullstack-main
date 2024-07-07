<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240707083838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking DROP duration');
        $this->addSql('ALTER TABLE clocking ADD CONSTRAINT FK_D3E9DCCDA1F846FC FOREIGN KEY (clocking_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587B6D103F FOREIGN KEY (clocking_id) REFERENCES clocking (id)');
        $this->addSql('ALTER TABLE clocking_project ADD CONSTRAINT FK_29254587166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clocking DROP FOREIGN KEY FK_D3E9DCCDA1F846FC');
        $this->addSql('ALTER TABLE clocking ADD duration INT NOT NULL');
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587B6D103F');
        $this->addSql('ALTER TABLE clocking_project DROP FOREIGN KEY FK_29254587166D1F9C');
    }
}
