<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003023002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE copia_libro (id INT AUTO_INCREMENT NOT NULL, libro_id INT NOT NULL, INDEX IDX_FCF8C128C0238522 (libro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE descriptor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro_descriptor (libro_id INT NOT NULL, descriptor_id INT NOT NULL, INDEX IDX_A0170132C0238522 (libro_id), INDEX IDX_A01701322A13D45 (descriptor_id), PRIMARY KEY(libro_id, descriptor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE copia_libro ADD CONSTRAINT FK_FCF8C128C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE libro_descriptor ADD CONSTRAINT FK_A0170132C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_descriptor ADD CONSTRAINT FK_A01701322A13D45 FOREIGN KEY (descriptor_id) REFERENCES descriptor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro ADD descriptor_primario_id INT NOT NULL');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B81B9E13F FOREIGN KEY (descriptor_primario_id) REFERENCES descriptor (id)');
        $this->addSql('CREATE INDEX IDX_5799AD2B81B9E13F ON libro (descriptor_primario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B81B9E13F');
        $this->addSql('ALTER TABLE copia_libro DROP FOREIGN KEY FK_FCF8C128C0238522');
        $this->addSql('ALTER TABLE libro_descriptor DROP FOREIGN KEY FK_A0170132C0238522');
        $this->addSql('ALTER TABLE libro_descriptor DROP FOREIGN KEY FK_A01701322A13D45');
        $this->addSql('DROP TABLE copia_libro');
        $this->addSql('DROP TABLE descriptor');
        $this->addSql('DROP TABLE libro_descriptor');
        $this->addSql('DROP INDEX IDX_5799AD2B81B9E13F ON libro');
        $this->addSql('ALTER TABLE libro DROP descriptor_primario_id');
    }
}
