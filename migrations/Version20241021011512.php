<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241021011512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrador ADD CONSTRAINT FK_44F9A521DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE copia_libro ADD ubicacion_fisica VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE libro DROP ubicacion_fisica');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE libro ADD ubicacion_fisica VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE administrador DROP FOREIGN KEY FK_44F9A521DB38439E');
        $this->addSql('ALTER TABLE copia_libro DROP ubicacion_fisica');
    }
}
