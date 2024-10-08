<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008195307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrador (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, funcion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_44F9A521DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clasificacion_decimal_dewey (id INT AUTO_INCREMENT NOT NULL, numero_cdd VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE copia_libro (id INT AUTO_INCREMENT NOT NULL, libro_id INT NOT NULL, disponibilidad_id INT NOT NULL, INDEX IDX_FCF8C128C0238522 (libro_id), INDEX IDX_FCF8C128B5C429C2 (disponibilidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE descriptor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disponibilidad_copia_libro (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE especialidad (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_prestamo (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estudiante (id INT AUTO_INCREMENT NOT NULL, especialidad_id INT NOT NULL, turno_id INT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, domicilio VARCHAR(255) NOT NULL, telefono VARCHAR(20) NOT NULL, anio INT NOT NULL, division INT NOT NULL, INDEX IDX_3B3F3FAD16A490EC (especialidad_id), INDEX IDX_3B3F3FAD69C5211E (turno_id), UNIQUE INDEX UNIQ_3B3F3FADDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, descriptor_primario_id INT NOT NULL, numero_cdd_id INT NOT NULL, titulo VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL, editorial VARCHAR(255) NOT NULL, numero_edicion SMALLINT NOT NULL, lugar_edicion VARCHAR(255) NOT NULL, idioma VARCHAR(50) NOT NULL, notas LONGTEXT DEFAULT NULL, numero_paginas VARCHAR(20) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_edicion DATETIME DEFAULT NULL, ubicacion_fisica VARCHAR(255) NOT NULL, publicacion_edicion DATE NOT NULL, INDEX IDX_5799AD2B81B9E13F (descriptor_primario_id), INDEX IDX_5799AD2B26936296 (numero_cdd_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro_autor (libro_id INT NOT NULL, autor_id INT NOT NULL, INDEX IDX_F7588AEFC0238522 (libro_id), INDEX IDX_F7588AEF14D45BBE (autor_id), PRIMARY KEY(libro_id, autor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro_descriptor (libro_id INT NOT NULL, descriptor_id INT NOT NULL, INDEX IDX_A0170132C0238522 (libro_id), INDEX IDX_A01701322A13D45 (descriptor_id), PRIMARY KEY(libro_id, descriptor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lista_deseados (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, UNIQUE INDEX UNIQ_C672CACCDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lista_deseados_libro (lista_deseados_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C3AEDE771EA8506 (lista_deseados_id), INDEX IDX_4C3AEDE7C0238522 (libro_id), PRIMARY KEY(lista_deseados_id, libro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, copia_libro_id INT NOT NULL, prestatario_id INT NOT NULL, estado_prestamo_id INT NOT NULL, fecha_solicitud DATE NOT NULL, fecha_prestamo DATE DEFAULT NULL, fecha_devolucion DATE DEFAULT NULL, INDEX IDX_F4D874F231984EB5 (copia_libro_id), INDEX IDX_F4D874F2AFA10618 (prestatario_id), INDEX IDX_F4D874F229566D3E (estado_prestamo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesor (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, domicilio VARCHAR(255) NOT NULL, telefono VARCHAR(40) NOT NULL, area_especialidad VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5B7406D9DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE turno (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, es_usuario_activo TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrador ADD CONSTRAINT FK_44F9A521DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE copia_libro ADD CONSTRAINT FK_FCF8C128C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE copia_libro ADD CONSTRAINT FK_FCF8C128B5C429C2 FOREIGN KEY (disponibilidad_id) REFERENCES disponibilidad_copia_libro (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FAD16A490EC FOREIGN KEY (especialidad_id) REFERENCES especialidad (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FAD69C5211E FOREIGN KEY (turno_id) REFERENCES turno (id)');
        $this->addSql('ALTER TABLE estudiante ADD CONSTRAINT FK_3B3F3FADDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B81B9E13F FOREIGN KEY (descriptor_primario_id) REFERENCES descriptor (id)');
        $this->addSql('ALTER TABLE libro ADD CONSTRAINT FK_5799AD2B26936296 FOREIGN KEY (numero_cdd_id) REFERENCES clasificacion_decimal_dewey (id)');
        $this->addSql('ALTER TABLE libro_autor ADD CONSTRAINT FK_F7588AEFC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_autor ADD CONSTRAINT FK_F7588AEF14D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_descriptor ADD CONSTRAINT FK_A0170132C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE libro_descriptor ADD CONSTRAINT FK_A01701322A13D45 FOREIGN KEY (descriptor_id) REFERENCES descriptor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista_deseados ADD CONSTRAINT FK_C672CACCDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE lista_deseados_libro ADD CONSTRAINT FK_4C3AEDE771EA8506 FOREIGN KEY (lista_deseados_id) REFERENCES lista_deseados (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista_deseados_libro ADD CONSTRAINT FK_4C3AEDE7C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F231984EB5 FOREIGN KEY (copia_libro_id) REFERENCES copia_libro (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2AFA10618 FOREIGN KEY (prestatario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F229566D3E FOREIGN KEY (estado_prestamo_id) REFERENCES estado_prestamo (id)');
        $this->addSql('ALTER TABLE profesor ADD CONSTRAINT FK_5B7406D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrador DROP FOREIGN KEY FK_44F9A521DB38439E');
        $this->addSql('ALTER TABLE copia_libro DROP FOREIGN KEY FK_FCF8C128C0238522');
        $this->addSql('ALTER TABLE copia_libro DROP FOREIGN KEY FK_FCF8C128B5C429C2');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FAD16A490EC');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FAD69C5211E');
        $this->addSql('ALTER TABLE estudiante DROP FOREIGN KEY FK_3B3F3FADDB38439E');
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B81B9E13F');
        $this->addSql('ALTER TABLE libro DROP FOREIGN KEY FK_5799AD2B26936296');
        $this->addSql('ALTER TABLE libro_autor DROP FOREIGN KEY FK_F7588AEFC0238522');
        $this->addSql('ALTER TABLE libro_autor DROP FOREIGN KEY FK_F7588AEF14D45BBE');
        $this->addSql('ALTER TABLE libro_descriptor DROP FOREIGN KEY FK_A0170132C0238522');
        $this->addSql('ALTER TABLE libro_descriptor DROP FOREIGN KEY FK_A01701322A13D45');
        $this->addSql('ALTER TABLE lista_deseados DROP FOREIGN KEY FK_C672CACCDB38439E');
        $this->addSql('ALTER TABLE lista_deseados_libro DROP FOREIGN KEY FK_4C3AEDE771EA8506');
        $this->addSql('ALTER TABLE lista_deseados_libro DROP FOREIGN KEY FK_4C3AEDE7C0238522');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F231984EB5');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2AFA10618');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F229566D3E');
        $this->addSql('ALTER TABLE profesor DROP FOREIGN KEY FK_5B7406D9DB38439E');
        $this->addSql('DROP TABLE administrador');
        $this->addSql('DROP TABLE autor');
        $this->addSql('DROP TABLE clasificacion_decimal_dewey');
        $this->addSql('DROP TABLE copia_libro');
        $this->addSql('DROP TABLE descriptor');
        $this->addSql('DROP TABLE disponibilidad_copia_libro');
        $this->addSql('DROP TABLE especialidad');
        $this->addSql('DROP TABLE estado_prestamo');
        $this->addSql('DROP TABLE estudiante');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE libro_autor');
        $this->addSql('DROP TABLE libro_descriptor');
        $this->addSql('DROP TABLE lista_deseados');
        $this->addSql('DROP TABLE lista_deseados_libro');
        $this->addSql('DROP TABLE prestamo');
        $this->addSql('DROP TABLE profesor');
        $this->addSql('DROP TABLE turno');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
