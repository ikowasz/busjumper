<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405204526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
           SET FOREIGN_KEY_CHECKS = 0;
        SQL);
        $this->addSql(<<<'SQL'

            TRUNCATE TABLE line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            TRUNCATE TABLE line_stop
        SQL);
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE line_stop ADD stop_order INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_321BE56F96470CD578CB78AF ON line_stop (line_direction_id, stop_order)
        SQL);
        $this->addSql(<<<'SQL'
           SET FOREIGN_KEY_CHECKS = 1;
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_321BE56F96470CD578CB78AF ON line_stop
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_stop DROP stop_order
        SQL);
    }
}
