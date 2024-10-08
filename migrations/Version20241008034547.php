<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008034547 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $especialidades = [
            "Construcciones",
            "Computación",
            "Electrónica",
            "Eléctrica",
            "Mecánica",
            "Química"
        ];

        foreach ($especialidades as $especialidad) {
            $this->addSql("INSERT INTO especialidad(nombre) VALUES('$especialidad')");
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM especialidad');
    }
}
