<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003033705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrador (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, funcion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_44F9A521DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disponibilidad_copia_libro (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE especialidad (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudiante (id INT AUTO_INCREMENT NOT NULL, especialidad_id INT NOT NULL, turno_id INT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, domicilio VARCHAR(255) NOT NULL, telefono VARCHAR(40) NOT NULL, INDEX IDX_3B3F3FAD16A490EC (especialidad_id), INDEX IDX_3B3F3FAD69C5211E (turno_id), UNIQUE INDEX UNIQ_3B3F3FADDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE turno (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FAD16A490EC FOREIGN KEY (especialidad_id) REFERENCES especialidad (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FAD69C5211E FOREIGN KEY (turno_id) REFERENCES turno (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FADDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE copia_libro ADD disponibilidad_id INT NOT NULL');
        $this->addSql('ALTER TABLE copia_libro ADD CONSTRAINT FK_FCF8C128B5C429C2 FOREIGN KEY (disponibilidad_id) REFERENCES disponibilidad_copia_libro (id)');
        $this->addSql('CREATE INDEX IDX_FCF8C128B5C429C2 ON copia_libro (disponibilidad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE copia_libro DROP FOREIGN KEY FK_FCF8C128B5C429C2');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FAD16A490EC');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FAD69C5211E');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FADDB38439E');
        $this->addSql('DROP TABLE disponibilidad_copia_libro');
        $this->addSql('DROP TABLE especialidad');
        $this->addSql('DROP TABLE estudiante');
        $this->addSql('DROP TABLE turno');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP INDEX IDX_FCF8C128B5C429C2 ON copia_libro');
        $this->addSql('ALTER TABLE copia_libro DROP disponibilidad_id');
    }
}
