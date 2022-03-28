<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323101446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card RENAME INDEX idx_490f70c6ea000b10 TO IDX_161498D3EA000B10');
        $this->addSql('ALTER TABLE card RENAME INDEX idx_490f70c620cc0f69 TO IDX_161498D34CE34BEC');
        $this->addSql('ALTER TABLE card_tag RENAME INDEX idx_c1ad92084ce34bec TO IDX_537933424ACC9A20');
        $this->addSql('ALTER TABLE card_tag RENAME INDEX idx_c1ad9208bad26311 TO IDX_53793342BAD26311');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE axie_class CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE card CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE card RENAME INDEX idx_161498d34ce34bec TO IDX_490F70C620CC0F69');
        $this->addSql('ALTER TABLE card RENAME INDEX idx_161498d3ea000b10 TO IDX_490F70C6EA000B10');
        $this->addSql('ALTER TABLE card_tag RENAME INDEX idx_537933424acc9a20 TO IDX_C1AD92084CE34BEC');
        $this->addSql('ALTER TABLE card_tag RENAME INDEX idx_53793342bad26311 TO IDX_C1AD9208BAD26311');
        $this->addSql('ALTER TABLE part CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tag CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
