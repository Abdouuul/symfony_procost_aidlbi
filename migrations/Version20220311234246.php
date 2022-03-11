<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311234246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_worktimes (id INT AUTO_INCREMENT NOT NULL, app_worktime_project_id INT NOT NULL, app_worktime_worker_id INT NOT NULL, cost DOUBLE PRECISION NOT NULL, days INT NOT NULL, INDEX IDX_115E709A3DC4AFF7 (app_worktime_project_id), INDEX IDX_115E709A76CA438C (app_worktime_worker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_worktimes ADD CONSTRAINT FK_115E709A3DC4AFF7 FOREIGN KEY (app_worktime_project_id) REFERENCES app_project (id)');
        $this->addSql('ALTER TABLE app_worktimes ADD CONSTRAINT FK_115E709A76CA438C FOREIGN KEY (app_worktime_worker_id) REFERENCES app_worker (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE app_worktimes');
    }
}
