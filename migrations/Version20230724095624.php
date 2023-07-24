<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724095624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecard DROP FOREIGN KEY FK_A0A048EFB00EB939');
        $this->addSql('ALTER TABLE ecard ADD CONSTRAINT FK_A0A048EFB00EB939 FOREIGN KEY (painting_id) REFERENCES painting (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecard DROP FOREIGN KEY FK_A0A048EFB00EB939');
        $this->addSql('ALTER TABLE ecard ADD CONSTRAINT FK_A0A048EFB00EB939 FOREIGN KEY (painting_id) REFERENCES painting (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
