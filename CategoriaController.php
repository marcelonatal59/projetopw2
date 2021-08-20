<?php
require_once "Conexao.php";
require_once "../models/Categoria.php";

class CategoriaController{

    private static $instance;
    private $conexao;

    /**
     * @return mixed
     */
    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new CategoriaController();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public function gravar(Categoria $categoria){
        if ($categoria->getId() == null){
            return $this->inserir($categoria);
        }else{
            return $this->alterar($categoria);
        }
    }

    private function alterar(Categoria $categoria){
        $sql = "UPDATE categoria SET descricao = :descricao WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":descricao", $categoria->getDescricao());
        $statement->bindValue(":id", $categoria->getId());
        return $statement->execute();
    }

    private function inserir(Categoria $categoria){
        $sql = "INSERT INTO categoria (descricao) VALUES (:descricao)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":descricao", $categoria->getDescricao());
        return $statement->execute();
    }

    public function getTodos(){
        $lstRetorno = array();
        $sql = "SELECT * FROM categoria ORDER BY descricao";
        $statement = $this->conexao->query($sql, PDO::FETCH_ASSOC);
        foreach ($statement as $row){
            $lstRetorno[] = $this->preencherCategoria($row);
        }
        return $lstRetorno;
    }

    public function getCategoria($id){
        $categoria = new Categoria();
        $sql = "SELECT * FROM categoria WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($retornoBanco as $row){
            $categoria = $this->preencherCategoria($row);
        }
        return $categoria;
    }

    private function preencherCategoria($row){
        $categoria = new Categoria();
        $categoria->setId($row['id']);
        $categoria->setDescricao($row['descricao']);
        return $categoria;
    }

    public function delete($id){
        $sql = "DELETE FROM categoria WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        return $statement->execute();
    }

}