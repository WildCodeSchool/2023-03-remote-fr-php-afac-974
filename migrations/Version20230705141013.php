<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705141013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_painting (user_id INT NOT NULL, painting_id INT NOT NULL, INDEX IDX_86340FA0A76ED395 (user_id), INDEX IDX_86340FA0B00EB939 (painting_id), PRIMARY KEY(user_id, painting_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_painting ADD CONSTRAINT FK_86340FA0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_painting ADD CONSTRAINT FK_86340FA0B00EB939 FOREIGN KEY (painting_id) REFERENCES painting (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_painting DROP FOREIGN KEY FK_86340FA0A76ED395');
        $this->addSql('ALTER TABLE user_painting DROP FOREIGN KEY FK_86340FA0B00EB939');
        $this->addSql('DROP TABLE user_painting');
    }
}
