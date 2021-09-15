# Pequeno CRUD com PHP
Esse CRUD feito em PHP, PDO e orientçação a objetos permite que o usuário crie, altere e remova dados referentes à vagas de emprego. Cada uma das vagas contém um identificador único, um título, uma descrição, um status que sinaliza se a vaga está ou não ativa e a data de criação (incluindo hora e segundos).

O login e senha do banco de dados estão em `./app/Db/Database.php` e devem ser alteradas para a configuração do ambiente. 


## Banco de dados
A criação da tabela `vagas` no banco de dados é necessária:
```sql
  CREATE TABLE `vagas` (
  	`id` INT(11) NOT NULL AUTO_INCREMENT,
  	`titulo` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
  	`descricao` TEXT(65535) NOT NULL COLLATE 'utf8_general_ci',
  	`ativo` ENUM('s','n') NOT NULL COLLATE 'utf8_general_ci',
  	`data` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  	PRIMARY KEY (`id`) USING BTREE
  )
  COLLATE='utf8_general_ci'
  ENGINE=InnoDB
  AUTO_INCREMENT=1;
```

