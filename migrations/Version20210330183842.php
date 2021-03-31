<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330183842 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE astuce ADD useridastuce_id INT DEFAULT NULL, ADD categories_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE astuce ADD CONSTRAINT FK_977D7803D5BF69F FOREIGN KEY (useridastuce_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE astuce ADD CONSTRAINT FK_977D780A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_977D7803D5BF69F ON astuce (useridastuce_id)');
        $this->addSql('CREATE INDEX IDX_977D780A21214B7 ON astuce (categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE astuce DROP FOREIGN KEY FK_977D7803D5BF69F');
        $this->addSql('ALTER TABLE astuce DROP FOREIGN KEY FK_977D780A21214B7');
        $this->addSql('DROP INDEX IDX_977D7803D5BF69F ON astuce');
        $this->addSql('DROP INDEX IDX_977D780A21214B7 ON astuce');
        $this->addSql('ALTER TABLE astuce DROP useridastuce_id, DROP categories_id, DROP active');
    }
}
