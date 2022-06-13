<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327080631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_language (category_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_63A1F5CE12469DE2 (category_id), INDEX IDX_63A1F5CE82F1BAF4 (language_id), PRIMARY KEY(category_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingridient (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_ingridient (meal_id INT NOT NULL, ingridient_id INT NOT NULL, INDEX IDX_8B010E81639666D6 (meal_id), INDEX IDX_8B010E81750B1398 (ingridient_id), PRIMARY KEY(meal_id, ingridient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_language (meal_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_B0C96AC7639666D6 (meal_id), INDEX IDX_B0C96AC782F1BAF4 (language_id), PRIMARY KEY(meal_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_tag (meal_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_78E3E97639666D6 (meal_id), INDEX IDX_78E3E97BAD26311 (tag_id), PRIMARY KEY(meal_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_category (meal_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_625E02B3639666D6 (meal_id), INDEX IDX_625E02B312469DE2 (category_id), PRIMARY KEY(meal_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_language (tag_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_E2EA0A6EBAD26311 (tag_id), INDEX IDX_E2EA0A6E82F1BAF4 (language_id), PRIMARY KEY(tag_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_language ADD CONSTRAINT FK_63A1F5CE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_language ADD CONSTRAINT FK_63A1F5CE82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_ingridient ADD CONSTRAINT FK_8B010E81639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_ingridient ADD CONSTRAINT FK_8B010E81750B1398 FOREIGN KEY (ingridient_id) REFERENCES ingridient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_language ADD CONSTRAINT FK_B0C96AC7639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_language ADD CONSTRAINT FK_B0C96AC782F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_tag ADD CONSTRAINT FK_78E3E97639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_tag ADD CONSTRAINT FK_78E3E97BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_category ADD CONSTRAINT FK_625E02B3639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_category ADD CONSTRAINT FK_625E02B312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_language ADD CONSTRAINT FK_E2EA0A6EBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_language ADD CONSTRAINT FK_E2EA0A6E82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_language DROP FOREIGN KEY FK_63A1F5CE12469DE2');
        $this->addSql('ALTER TABLE meal_category DROP FOREIGN KEY FK_625E02B312469DE2');
        $this->addSql('ALTER TABLE meal_ingridient DROP FOREIGN KEY FK_8B010E81750B1398');
        $this->addSql('ALTER TABLE category_language DROP FOREIGN KEY FK_63A1F5CE82F1BAF4');
        $this->addSql('ALTER TABLE meal_language DROP FOREIGN KEY FK_B0C96AC782F1BAF4');
        $this->addSql('ALTER TABLE tag_language DROP FOREIGN KEY FK_E2EA0A6E82F1BAF4');
        $this->addSql('ALTER TABLE meal_ingridient DROP FOREIGN KEY FK_8B010E81639666D6');
        $this->addSql('ALTER TABLE meal_language DROP FOREIGN KEY FK_B0C96AC7639666D6');
        $this->addSql('ALTER TABLE meal_tag DROP FOREIGN KEY FK_78E3E97639666D6');
        $this->addSql('ALTER TABLE meal_category DROP FOREIGN KEY FK_625E02B3639666D6');
        $this->addSql('ALTER TABLE meal_tag DROP FOREIGN KEY FK_78E3E97BAD26311');
        $this->addSql('ALTER TABLE tag_language DROP FOREIGN KEY FK_E2EA0A6EBAD26311');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_language');
        $this->addSql('DROP TABLE ingridient');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_ingridient');
        $this->addSql('DROP TABLE meal_language');
        $this->addSql('DROP TABLE meal_tag');
        $this->addSql('DROP TABLE meal_category');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_language');
    }
}
