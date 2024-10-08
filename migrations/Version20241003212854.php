<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003212854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estado_prestamo (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lista_deseados (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, UNIQUE INDEX UNIQ_C672CACCDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lista_deseados_libro (lista_deseados_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_4C3AEDE771EA8506 (lista_deseados_id), INDEX IDX_4C3AEDE7C0238522 (libro_id), PRIMARY KEY(lista_deseados_id, libro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, copia_libro_id INT NOT NULL, prestatario_id INT NOT NULL, estado_prestamo_id INT NOT NULL, fecha_solicitud DATE NOT NULL, fecha_prestamo DATE DEFAULT NULL, fecha_devolucion DATE DEFAULT NULL, INDEX IDX_F4D874F231984EB5 (copia_libro_id), INDEX IDX_F4D874F2AFA10618 (prestatario_id), INDEX IDX_F4D874F229566D3E (estado_prestamo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesor (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, dni VARCHAR(8) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, domicilio VARCHAR(255) NOT NULL, telefono VARCHAR(40) NOT NULL, area_especialidad VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5B7406D9DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lista_deseados ADD CONSTRAINT FK_C672CACCDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE lista_deseados_libro ADD CONSTRAINT FK_4C3AEDE771EA8506 FOREIGN KEY (lista_deseados_id) REFERENCES lista_deseados (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista_deseados_libro ADD CONSTRAINT FK_4C3AEDE7C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F231984EB5 FOREIGN KEY (copia_libro_id) REFERENCES copia_libro (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2AFA10618 FOREIGN KEY (prestatario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F229566D3E FOREIGN KEY (estado_prestamo_id) REFERENCES estado_prestamo (id)');
        $this->addSql('ALTER TABLE profesor ADD CONSTRAINT FK_5B7406D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE estudiante CHANGE telefono telefono VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE usuario ADD es_usuario_activo TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lista_deseados DROP FOREIGN KEY FK_C672CACCDB38439E');
        $this->addSql('ALTER TABLE lista_deseados_libro DROP FOREIGN KEY FK_4C3AEDE771EA8506');
        $this->addSql('ALTER TABLE lista_deseados_libro DROP FOREIGN KEY FK_4C3AEDE7C0238522');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F231984EB5');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2AFA10618');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F229566D3E');
        $this->addSql('ALTER TABLE profesor DROP FOREIGN KEY FK_5B7406D9DB38439E');
        $this->addSql('DROP TABLE estado_prestamo');
        $this->addSql('DROP TABLE lista_deseados');
        $this->addSql('DROP TABLE lista_deseados_libro');
        $this->addSql('DROP TABLE prestamo');
        $this->addSql('DROP TABLE profesor');
        $this->addSql('ALTER TABLE usuario DROP es_usuario_activo');
        $this->addSql('ALTER TABLE estudiante CHANGE telefono telefono VARCHAR(40) NOT NULL');
    }
}
