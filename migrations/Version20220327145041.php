<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327145041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gat (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gat_meal (gat_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_78F77D77D3CEB55 (gat_id), INDEX IDX_78F77D7639666D6 (meal_id), PRIMARY KEY(gat_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gat_language (gat_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_55F50F897D3CEB55 (gat_id), INDEX IDX_55F50F8982F1BAF4 (language_id), PRIMARY KEY(gat_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gat_meal ADD CONSTRAINT FK_78F77D77D3CEB55 FOREIGN KEY (gat_id) REFERENCES gat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gat_meal ADD CONSTRAINT FK_78F77D7639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gat_language ADD CONSTRAINT FK_55F50F897D3CEB55 FOREIGN KEY (gat_id) REFERENCES gat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gat_language ADD CONSTRAINT FK_55F50F8982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE deleted_at deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gat_meal DROP FOREIGN KEY FK_78F77D77D3CEB55');
        $this->addSql('ALTER TABLE gat_language DROP FOREIGN KEY FK_55F50F897D3CEB55');
        $this->addSql('DROP TABLE gat');
        $this->addSql('DROP TABLE gat_meal');
        $this->addSql('DROP TABLE gat_language');
        $this->addSql('ALTER TABLE meal CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE deleted_at deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
