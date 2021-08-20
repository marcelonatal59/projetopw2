<?php
require_once "Conexao.php";
require_once "models/Cliente.php";

class ClienteController{
    private static $instance;
    private $conexao;

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new ClienteController();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public function getTodos(){
        $lstRetorno = array();
        $sql = "SELECT * FROM cliente ORDER BY nome ";
        $statement = $this->conexao->query($sql, PDO::FETCH_ASSOC);
        foreach ($statement as $row){
            $lstRetorno[] = $this->preencherCliente($row);
        }
        return $lstRetorno;
    }

    private function preencherCliente($row){
        $cliente = new Cliente();
        $cliente->setId($row['id']);
        $cliente->setNome($row['nome']);
        $cliente->setEmail($row['email']);
        $cliente->setTelefone($row['telefone']);

        return $cliente;
    }

    public function gravar(Cliente $cliente){
        if ($cliente->getId() == null){
            return $this->inserir($cliente);
        }else{
            return $this->alterar($cliente);
        }
    }

    private function inserir(Cliente $cliente){
        $sql = "INSERT INTO cliente (nome, email, telefone, senha) VALUES (:nome, :email, :telefone, :senha)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":nome", $cliente->getNome());
        $statement->bindValue(":email", $cliente->getEmail());
        $statement->bindValue(":telefone", $cliente->getTelefone());
        $statement->bindValue(":senha", $cliente->getSenha());
        return $statement->execute();
    }

    private function alterar(Cliente $cliente){
        $sql = "UPDATE cliente SET nome = :nome, telefone=:telefone WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":nome", $cliente->getNome());
        $statement->bindValue(":telefone", $cliente->getTelefone());
        $statement->bindValue(":id", $cliente->getId());
        return $statement->execute();
    }

    public function getCliente($id){
        $cliente = new Cliente();
        $sql = "SELECT * FROM cliente WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($retornoBanco as $row){
            $cliente = $this->preencherCliente($row);
        }
        return $cliente;
    }

    public function delete($id){
        $sql = "DELETE FROM cliente WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        return $statement->execute();
    }
}