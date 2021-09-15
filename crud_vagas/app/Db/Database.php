<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database{

// Conexão com o banco de dados e seu nome
  const HOST = 'localhost';
  const NAME = 'vagas';

// Credenciais de usuário (devem ser mudadas para o ambiente)
  const USER = 'admin123';
  const PASS = 'admin123';


// Pega a tabela que será manipulada
  private $table;
  private $connection;

  // Define a tabela e instancia a conexão
  public function __construct($table = null){
    $this->table = $table;
    $this->setConnection();
  }

  // Método que cria uma conexão com o banco
  private function setConnection(){
    try{
      $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  // Método que executa as queries do banco
  public function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  // Esse método insere queries no banco
  public function insert($values){
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    $this->execute($query,array_values($values));

    return $this->connection->lastInsertId();
  }

  // Executa uma consulta no banco
  public function select($where = null, $order = null, $limit = null, $fields = '*'){
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

    return $this->execute($query);
  }

  // Executa as atualizações no banco
  public function update($where,$values){

    $fields = array_keys($values);

    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    $this->execute($query,array_values($values));
    return true;
  }

  // Exclui os dados no banco
  public function delete($where){
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
   
    $this->execute($query);
    return true;
  }

}