<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Vaga{

  // Criação dos atributos da vaga 
  public $id; // identificador único
  public $titulo; // título da vaga
  public $descricao; // descrição da vaga
  public $ativo; // define se a vaga está ativa (s/n)
  public $data; // data de publicação da vaga

  // Realiza o cadastro de uma nova vaga no banco
  public function cadastrar(){

    $this->data = date('Y-m-d H:i:s');

    $obDatabase = new Database('vagas');
    $this->id = $obDatabase->insert([
      'titulo'    => $this->titulo,
      'descricao' => $this->descricao,
      'ativo'     => $this->ativo,
      'data'      => $this->data
      ]);

    return true;
  }

  // Realiza a atualização da vaga no banco
  public function atualizar(){
    return (new Database('vagas'))->update('id = '.$this->id,[
       'titulo'    => $this->titulo,
       'descricao' => $this->descricao,
       'ativo'     => $this->ativo,
       'data'      => $this->data
       ]);
  }

  // Realiza a exclusão da vaga no banco
  public function excluir(){
    return (new Database('vagas'))->delete('id = '.$this->id);
  }

  // Obtém as vagas do banco
  public static function getVagas($where = null, $order = null, $limit = null){
    return (new Database('vagas'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  // Realiza a busca da vaga no banco por meio do ID
  public static function getVaga($id){
    return (new Database('vagas'))->select('id = '.$id)->fetchObject(self::class);
  }

}