<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627090512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, family_name VARCHAR(255) NOT NULL, given_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, ms_oid VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, is_author TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, answer_content LONGTEXT DEFAULT NULL, answer_author_id INT NOT NULL, answer_date_time DATETIME NOT NULL, related_comment_id_id INT DEFAULT NULL, INDEX IDX_DADD4A253E8CCC39 (related_comment_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, creation_date_time DATETIME NOT NULL, author_id INT DEFAULT NULL, related_idea_id INT DEFAULT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526C647625D8 (related_idea_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, upload_date DATETIME NOT NULL, name_file VARCHAR(255) NOT NULL, related_idea_id_id INT DEFAULT NULL, INDEX IDX_6354059B44EA532 (related_idea_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE idea (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, details LONGTEXT NOT NULL, state VARCHAR(255) NOT NULL, creation_datetime DATETIME NOT NULL, choice_mesures LONGTEXT NOT NULL, details_mesures LONGTEXT NOT NULL, choice_funding LONGTEXT NOT NULL, details_funding LONGTEXT NOT NULL, team VARCHAR(255) NOT NULL, files_idea VARCHAR(255) DEFAULT NULL, is_archived TINYINT(1) NOT NULL, author_id INT NOT NULL, validator_id INT DEFAULT NULL, INDEX IDX_A8BCA45F675F31B (author_id), INDEX IDX_A8BCA45B0644AEC (validator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE login (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(255) NOT NULL, datetime DATETIME NOT NULL, account_id_id INT NOT NULL, INDEX IDX_AA08CB1049CB4726 (account_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE managers (id INT AUTO_INCREMENT NOT NULL, family_name VARCHAR(255) NOT NULL, given_name VARCHAR(255) NOT NULL, team_id_id INT NOT NULL, INDEX IDX_A949E006B842D717 (team_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, account_id_id INT NOT NULL, INDEX IDX_57698A6A49CB4726 (account_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, label_teams VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, value INT NOT NULL, auhtor_id INT DEFAULT NULL, related_idea_id_id INT NOT NULL, INDEX IDX_5A108564221FC741 (auhtor_id), INDEX IDX_5A108564B44EA532 (related_idea_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A253E8CCC39 FOREIGN KEY (related_comment_id_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C647625D8 FOREIGN KEY (related_idea_id) REFERENCES idea (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059B44EA532 FOREIGN KEY (related_idea_id_id) REFERENCES idea (id)');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA45F675F31B FOREIGN KEY (author_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA45B0644AEC FOREIGN KEY (validator_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE login ADD CONSTRAINT FK_AA08CB1049CB4726 FOREIGN KEY (account_id_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE managers ADD CONSTRAINT FK_A949E006B842D717 FOREIGN KEY (team_id_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A49CB4726 FOREIGN KEY (account_id_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564221FC741 FOREIGN KEY (auhtor_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564B44EA532 FOREIGN KEY (related_idea_id_id) REFERENCES idea (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A253E8CCC39');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C647625D8');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059B44EA532');
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA45F675F31B');
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA45B0644AEC');
        $this->addSql('ALTER TABLE login DROP FOREIGN KEY FK_AA08CB1049CB4726');
        $this->addSql('ALTER TABLE managers DROP FOREIGN KEY FK_A949E006B842D717');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A49CB4726');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564221FC741');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564B44EA532');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE idea');
        $this->addSql('DROP TABLE login');
        $this->addSql('DROP TABLE managers');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
