<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405212018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE timetable_line (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_44285EF896901F54 (number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE timetable_line_arrival (id INT AUTO_INCREMENT NOT NULL, line_stop_id INT NOT NULL, hour INT NOT NULL, minute INT NOT NULL, INDEX IDX_3645590E8CA6875A (line_stop_id), UNIQUE INDEX UNIQ_3645590E8CA6875A701E114E6EC2ABB5 (line_stop_id, hour, minute), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE timetable_line_direction (id INT AUTO_INCREMENT NOT NULL, line_id INT NOT NULL, direction_name VARCHAR(255) NOT NULL, INDEX IDX_500A0EAE4D7B7542 (line_id), UNIQUE INDEX UNIQ_500A0EAE4D7B7542F641B14E (line_id, direction_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE timetable_line_stop (id INT AUTO_INCREMENT NOT NULL, line_direction_id INT NOT NULL, stop_id INT NOT NULL, stop_order INT NOT NULL, INDEX IDX_15AE98F996470CD5 (line_direction_id), INDEX IDX_15AE98F93902063D (stop_id), UNIQUE INDEX UNIQ_15AE98F996470CD53902063D (line_direction_id, stop_id), UNIQUE INDEX UNIQ_15AE98F996470CD578CB78AF (line_direction_id, stop_order), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE timetable_stop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2C6AFCB85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_arrival ADD CONSTRAINT FK_3645590E8CA6875A FOREIGN KEY (line_stop_id) REFERENCES timetable_line_stop (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_direction ADD CONSTRAINT FK_500A0EAE4D7B7542 FOREIGN KEY (line_id) REFERENCES timetable_line (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_stop ADD CONSTRAINT FK_15AE98F996470CD5 FOREIGN KEY (line_direction_id) REFERENCES timetable_line_direction (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_stop ADD CONSTRAINT FK_15AE98F93902063D FOREIGN KEY (stop_id) REFERENCES timetable_stop (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_direction DROP FOREIGN KEY FK_8E492AC14D7B7542
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival DROP FOREIGN KEY FK_EE41DDD38CA6875A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_stop DROP FOREIGN KEY FK_321BE56F3902063D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_stop DROP FOREIGN KEY FK_321BE56F96470CD5
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE line_direction
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE line
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE stop
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE line_stop
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE line_direction (id INT AUTO_INCREMENT NOT NULL, line_id INT NOT NULL, direction_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8E492AC14D7B7542F641B14E (line_id, direction_name), INDEX IDX_8E492AC14D7B7542 (line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE line (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_D114B4F696901F54 (number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE stop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_B95616B65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE line_arrival (id INT AUTO_INCREMENT NOT NULL, line_stop_id INT NOT NULL, hour INT NOT NULL, minute INT NOT NULL, INDEX IDX_EE41DDD38CA6875A (line_stop_id), UNIQUE INDEX UNIQ_EE41DDD38CA6875A701E114E6EC2ABB5 (line_stop_id, hour, minute), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE line_stop (id INT AUTO_INCREMENT NOT NULL, line_direction_id INT NOT NULL, stop_id INT NOT NULL, stop_order INT NOT NULL, INDEX IDX_321BE56F96470CD5 (line_direction_id), INDEX IDX_321BE56F3902063D (stop_id), UNIQUE INDEX UNIQ_321BE56F96470CD578CB78AF (line_direction_id, stop_order), UNIQUE INDEX UNIQ_321BE56F96470CD53902063D (line_direction_id, stop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_direction ADD CONSTRAINT FK_8E492AC14D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_arrival ADD CONSTRAINT FK_EE41DDD38CA6875A FOREIGN KEY (line_stop_id) REFERENCES line_stop (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_stop ADD CONSTRAINT FK_321BE56F3902063D FOREIGN KEY (stop_id) REFERENCES stop (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE line_stop ADD CONSTRAINT FK_321BE56F96470CD5 FOREIGN KEY (line_direction_id) REFERENCES line_direction (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_arrival DROP FOREIGN KEY FK_3645590E8CA6875A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_direction DROP FOREIGN KEY FK_500A0EAE4D7B7542
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_stop DROP FOREIGN KEY FK_15AE98F996470CD5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE timetable_line_stop DROP FOREIGN KEY FK_15AE98F93902063D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE timetable_line
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE timetable_line_arrival
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE timetable_line_direction
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE timetable_line_stop
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE timetable_stop
        SQL);
    }
}
