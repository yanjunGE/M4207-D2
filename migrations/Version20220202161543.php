<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202161543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acces (id INT AUTO_INCREMENT NOT NULL, util_id INT NOT NULL, doc_id INT NOT NULL, autor_id INT NOT NULL, INDEX IDX_D0F43B10CF5D2E80 (util_id), INDEX IDX_D0F43B10895648BC (doc_id), INDEX IDX_D0F43B1014D45BBE (autor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation (id INT AUTO_INCREMENT NOT NULL, lecture TINYINT(1) NOT NULL, ecriture TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, chemin VARCHAR(255) NOT NULL, date DATETIME NOT NULL, actif TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B10CF5D2E80 FOREIGN KEY (util_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B10895648BC FOREIGN KEY (doc_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE acces ADD CONSTRAINT FK_D0F43B1014D45BBE FOREIGN KEY (autor_id) REFERENCES autorisation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B1014D45BBE');
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B10895648BC');
        $this->addSql('ALTER TABLE acces DROP FOREIGN KEY FK_D0F43B10CF5D2E80');
        $this->addSql('DROP TABLE acces');
        $this->addSql('DROP TABLE autorisation');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE utilisateur');
    }
}
