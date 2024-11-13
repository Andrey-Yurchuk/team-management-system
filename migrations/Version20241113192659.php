<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113192659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, position VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, contact_number VARCHAR(15) NOT NULL, hire_date DATE NOT NULL, is_active TINYINT(1) NOT NULL, termination_date DATE DEFAULT NULL, birth_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE developers_projects (developer_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_23A8596B64DD9267 (developer_id), INDEX IDX_23A8596B166D1F9C (project_id), PRIMARY KEY(developer_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, client VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE developers_projects ADD CONSTRAINT FK_23A8596B64DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developers_projects ADD CONSTRAINT FK_23A8596B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developers_projects DROP FOREIGN KEY FK_23A8596B64DD9267');
        $this->addSql('ALTER TABLE developers_projects DROP FOREIGN KEY FK_23A8596B166D1F9C');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developers_projects');
        $this->addSql('DROP TABLE project');
    }
}
