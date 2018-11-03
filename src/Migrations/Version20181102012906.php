<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181102012906 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, fistname VARCHAR(50) NOT NULL, lastname VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, name VARCHAR(50) NOT NULL, created DATETIME NOT NULL, INDEX IDX_5C93B3A461220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE managers_projects (project_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6D19DAA3166D1F9C (project_id), INDEX IDX_6D19DAA3A76ED395 (user_id), PRIMARY KEY(project_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, project_id INT NOT NULL, name VARCHAR(100) NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_5058659761220EA6 (creator_id), INDEX IDX_50586597166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supervisors_tasks (task_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A96970D68DB60186 (task_id), INDEX IDX_A96970D6A76ED395 (user_id), PRIMARY KEY(task_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technicians_tasks (task_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_ECFD6C918DB60186 (task_id), INDEX IDX_ECFD6C91A76ED395 (user_id), PRIMARY KEY(task_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A461220EA6 FOREIGN KEY (creator_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE managers_projects ADD CONSTRAINT FK_6D19DAA3166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE managers_projects ADD CONSTRAINT FK_6D19DAA3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659761220EA6 FOREIGN KEY (creator_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE supervisors_tasks ADD CONSTRAINT FK_A96970D68DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE supervisors_tasks ADD CONSTRAINT FK_A96970D6A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE technicians_tasks ADD CONSTRAINT FK_ECFD6C918DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE technicians_tasks ADD CONSTRAINT FK_ECFD6C91A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A461220EA6');
        $this->addSql('ALTER TABLE managers_projects DROP FOREIGN KEY FK_6D19DAA3A76ED395');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_5058659761220EA6');
        $this->addSql('ALTER TABLE supervisors_tasks DROP FOREIGN KEY FK_A96970D6A76ED395');
        $this->addSql('ALTER TABLE technicians_tasks DROP FOREIGN KEY FK_ECFD6C91A76ED395');
        $this->addSql('ALTER TABLE managers_projects DROP FOREIGN KEY FK_6D19DAA3166D1F9C');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597166D1F9C');
        $this->addSql('ALTER TABLE supervisors_tasks DROP FOREIGN KEY FK_A96970D68DB60186');
        $this->addSql('ALTER TABLE technicians_tasks DROP FOREIGN KEY FK_ECFD6C918DB60186');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE managers_projects');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE supervisors_tasks');
        $this->addSql('DROP TABLE technicians_tasks');
    }
}
