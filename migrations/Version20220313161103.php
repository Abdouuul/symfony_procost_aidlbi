<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220313161103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, delivery_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_worker (id INT AUTO_INCREMENT NOT NULL, app_job_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, dailycost DOUBLE PRECISION NOT NULL, employed_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7AB1D2E2EEE32329 (app_job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_worktimes (id INT AUTO_INCREMENT NOT NULL, app_worktime_project_id INT NOT NULL, app_worktime_worker_id INT NOT NULL, cost DOUBLE PRECISION NOT NULL, days INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_115E709A3DC4AFF7 (app_worktime_project_id), INDEX IDX_115E709A76CA438C (app_worktime_worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_worker ADD CONSTRAINT FK_7AB1D2E2EEE32329 FOREIGN KEY (app_job_id) REFERENCES app_job (id)');
        $this->addSql('ALTER TABLE app_worktimes ADD CONSTRAINT FK_115E709A3DC4AFF7 FOREIGN KEY (app_worktime_project_id) REFERENCES app_project (id)');
        $this->addSql('ALTER TABLE app_worktimes ADD CONSTRAINT FK_115E709A76CA438C FOREIGN KEY (app_worktime_worker_id) REFERENCES app_worker (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_worker DROP FOREIGN KEY FK_7AB1D2E2EEE32329');
        $this->addSql('ALTER TABLE app_worktimes DROP FOREIGN KEY FK_115E709A3DC4AFF7');
        $this->addSql('ALTER TABLE app_worktimes DROP FOREIGN KEY FK_115E709A76CA438C');
        $this->addSql('DROP TABLE app_job');
        $this->addSql('DROP TABLE app_project');
        $this->addSql('DROP TABLE app_worker');
        $this->addSql('DROP TABLE app_worktimes');
    }
}
