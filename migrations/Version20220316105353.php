<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316105353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE axie_class (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, part_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, cost SMALLINT NOT NULL, damage INT NOT NULL, shield INT NOT NULL, heal INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_490F70C6EA000B10 (class_id), INDEX IDX_490F70C620CC0F69 (part_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_tag (card_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C1AD92084CE34BEC (card_id), INDEX IDX_C1AD9208BAD26311 (tag_id), PRIMARY KEY(card_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_490F70C6EA000B10 FOREIGN KEY (class_id) REFERENCES axie_class (id)');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_490F70C620CC0F69 FOREIGN KEY (part_id) REFERENCES part (id)');
        $this->addSql('ALTER TABLE card_tag ADD CONSTRAINT FK_C1AD92084CE34BEC FOREIGN KEY (card_id) REFERENCES card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE card_tag ADD CONSTRAINT FK_C1AD9208BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_490F70C6EA000B10');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_490F70C620CC0F69');
        $this->addSql('ALTER TABLE card_tag DROP FOREIGN KEY FK_C1AD92084CE34BEC');
        $this->addSql('ALTER TABLE card_tag DROP FOREIGN KEY FK_C1AD9208BAD26311');
        $this->addSql('DROP TABLE axie_class');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }
}
