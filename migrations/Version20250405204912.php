<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405204912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival DROP FOREIGN KEY FK_EE41DDD33902063D
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_EE41DDD33902063D ON line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_EE41DDD33902063D701E114E6EC2ABB5 ON line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival CHANGE stop_id line_stop_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival ADD CONSTRAINT FK_EE41DDD38CA6875A FOREIGN KEY (line_stop_id) REFERENCES line_stop (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EE41DDD38CA6875A ON line_arrival (line_stop_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_EE41DDD38CA6875A701E114E6EC2ABB5 ON line_arrival (line_stop_id, hour, minute)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival DROP FOREIGN KEY FK_EE41DDD38CA6875A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_EE41DDD38CA6875A ON line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_EE41DDD38CA6875A701E114E6EC2ABB5 ON line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival CHANGE line_stop_id stop_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival ADD CONSTRAINT FK_EE41DDD33902063D FOREIGN KEY (stop_id) REFERENCES line_stop (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EE41DDD33902063D ON line_arrival (stop_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_EE41DDD33902063D701E114E6EC2ABB5 ON line_arrival (stop_id, hour, minute)
        SQL);
    }
}
