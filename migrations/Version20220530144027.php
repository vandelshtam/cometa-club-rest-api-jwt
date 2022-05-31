<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530144027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setting_options (id INT AUTO_INCREMENT NOT NULL, payments_singleline INT DEFAULT NULL, payments_direct INT DEFAULT NULL, cash_back INT DEFAULT NULL, all_price_pakage INT DEFAULT NULL, accrual_limit INT DEFAULT NULL, system_revenues INT DEFAULT NULL, update_day INT DEFAULT NULL, limit_wallet_from_line INT DEFAULT NULL, payments_direct_fast INT DEFAULT NULL, multi_pakage_day DATETIME DEFAULT NULL, name_multi_pakage VARCHAR(255) DEFAULT NULL, start_day INT DEFAULT NULL, privileget_members INT DEFAULT NULL, fast_start DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE setting_options');
    }
}
