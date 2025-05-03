<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325124714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_option ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE stock_option ADD CONSTRAINT FK_90A0D226F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_90A0D226F347EFB ON stock_option (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_option DROP FOREIGN KEY FK_90A0D226F347EFB');
        $this->addSql('DROP INDEX IDX_90A0D226F347EFB ON stock_option');
        $this->addSql('ALTER TABLE stock_option DROP produit_id');
    }
}
