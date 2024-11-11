<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241111124603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reserva (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, libro_id INT NOT NULL, INDEX IDX_188D2E3BDB38439E (usuario_id), INDEX IDX_188D2E3BC0238522 (libro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BC0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE administrador ADD CONSTRAINT FK_44F9A521DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE copia_libro ADD ubicacion_fisica VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE libro DROP ubicacion_fisica');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BDB38439E');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BC0238522');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('ALTER TABLE administrador DROP FOREIGN KEY FK_44F9A521DB38439E');
        $this->addSql('ALTER TABLE copia_libro DROP ubicacion_fisica');
        $this->addSql('ALTER TABLE libro ADD ubicacion_fisica VARCHAR(255) NOT NULL');
    }
}
