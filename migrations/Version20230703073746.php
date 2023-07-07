<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703073746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ecard (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, painting_id INT DEFAULT NULL, sent_to VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', sended_at DATETIME NOT NULL, INDEX IDX_A0A048EFA76ED395 (user_id), INDEX IDX_A0A048EFB00EB939 (painting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ecard ADD CONSTRAINT FK_A0A048EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ecard ADD CONSTRAINT FK_A0A048EFB00EB939 FOREIGN KEY (painting_id) REFERENCES painting (id)');
        $this->addSql('ALTER TABLE painting CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecard DROP FOREIGN KEY FK_A0A048EFA76ED395');
        $this->addSql('ALTER TABLE ecard DROP FOREIGN KEY FK_A0A048EFB00EB939');
        $this->addSql('DROP TABLE ecard');
        $this->addSql('ALTER TABLE painting CHANGE image image VARCHAR(255) NOT NULL');
    }
}
