<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510070646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content_ingridient (content_id INT NOT NULL, ingridient_id INT NOT NULL, INDEX IDX_85540EF984A0A3ED (content_id), INDEX IDX_85540EF9750B1398 (ingridient_id), PRIMARY KEY(content_id, ingridient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_ingridient ADD CONSTRAINT FK_85540EF984A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_ingridient ADD CONSTRAINT FK_85540EF9750B1398 FOREIGN KEY (ingridient_id) REFERENCES ingridient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE content_ingridient');
    }
}
