<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008230622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrador (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, funcion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_44F9A521DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrador ADD CONSTRAINT FK_44F9A521DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrador DROP FOREIGN KEY FK_44F9A521DB38439E');
        $this->addSql('DROP TABLE administrador');
    }
}
