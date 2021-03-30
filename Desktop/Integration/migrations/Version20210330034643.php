<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330034643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, typereclamation_id INT NOT NULL, numcmd INT DEFAULT NULL, idc INT DEFAULT NULL, nomc VARCHAR(255) NOT NULL, pnomc VARCHAR(255) NOT NULL, mailc VARCHAR(255) NOT NULL, numclient INT NOT NULL, drc DATE NOT NULL, obrc VARCHAR(255) NOT NULL, desrec VARCHAR(2000) DEFAULT NULL, screenshot VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CE606404F2D655C2 (typereclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typereclamation (id INT AUTO_INCREMENT NOT NULL, tyrc VARCHAR(255) NOT NULL, etrc VARCHAR(255) DEFAULT NULL, comrc VARCHAR(255) DEFAULT NULL, ida INT DEFAULT NULL, color VARCHAR(7) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F2D655C2 FOREIGN KEY (typereclamation_id) REFERENCES typereclamation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F2D655C2');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE typereclamation');
    }
}
