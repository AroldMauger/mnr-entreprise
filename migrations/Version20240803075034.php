<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803075034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billing_item (id INT AUTO_INCREMENT NOT NULL, billing_id INT NOT NULL, quantity INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_60691BD93B025C87 (billing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billing_item ADD CONSTRAINT FK_60691BD93B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing_item DROP FOREIGN KEY FK_60691BD93B025C87');
        $this->addSql('DROP TABLE billing_item');
    }
}
