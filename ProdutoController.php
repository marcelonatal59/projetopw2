<?php
require_once "Conexao.php";
require_once "../models/Produto.php";

class ProdutoController{

    private static $instance;
    private $conexao;

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new ProdutoController();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->conexao = Conexao::getInstance();
    }

    public function getTodos(){
        $lstRetorno = array();
        $sql = "SELECT p.*, c.descricao AS categoria FROM produto p INNER JOIN categoria c ON c.id = p.categoria_id ORDER BY nome ";
        $statement = $this->conexao->query($sql, PDO::FETCH_ASSOC);
        foreach ($statement as $row){
            $lstRetorno[] = $this->preencherProduto($row);
        }
        return $lstRetorno;
    }

    public function getUltimosTres(){
        $lstRetorno = array();
        $sql = "SELECT p.*, c.descricao AS categoria FROM produto p INNER JOIN categoria c ON c.id = p.categoria_id ORDER BY p.id DESC LIMIT 3";
        $statement = $this->conexao->query($sql, PDO::FETCH_ASSOC);
        foreach ($statement as $row){
            $lstRetorno[] = $this->preencherProduto($row);
        }
        return $lstRetorno;
    }

    public function getProdutosByCategoria($categoria){
        $lstRetorno = array();
        $sql = "SELECT p.*, c.descricao AS categoria FROM produto p INNER JOIN categoria c ON c.id = p.categoria_id WHERE p.categoria_id = :categoria ORDER BY p.nome";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":categoria", $categoria);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($retornoBanco as $row){
            $lstRetorno[] = $this->preencherProduto($row);
        }
        return $lstRetorno;
    }

    private function preencherProduto($row){
        $produto = new Produto();
        $produto->setId($row['id']);
        $produto->setNome($row['nome']);
        $produto->setDescricao($row['descricao']);
        $produto->setValor($row['valor']);
        $produto->setImagem($row['imagem']);
        $produto->getCategoria()->setId($row['categoria_id']);
        $produto->getCategoria()->setDescricao($row['categoria']);
        return $produto;
    }

    public function gravar(Produto $produto){
        if ($produto->getId() == null){
            return $this->inserir($produto);
        }else{
            return $this->alterar($produto);
        }
    }

    private function inserir(Produto $produto){
        $sql = "INSERT INTO produto (nome, descricao, categoria_id, valor, imagem) VALUES (:nome, :descricao, :categoria, :valor, :imagem)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":nome", $produto->getNome());
        $statement->bindValue(":descricao", $produto->getDescricao());
        $statement->bindValue(":categoria", $produto->getCategoria()->getId());
        $statement->bindValue(":valor", $produto->getValor());
        $statement->bindValue(":imagem", $produto->getImagem());
        return $statement->execute();
    }

    private function alterar(Produto $produto){
        if ($produto->getImagem() == ""){
            $sql = "UPDATE produto SET nome = :nome, descricao = :descricao, categoria_id=:categoria, valor=:valor WHERE id = :id";
        }else{
            $sql = "UPDATE produto SET nome = :nome, descricao = :descricao, categoria_id=:categoria, valor=:valor, imagem=:imagem WHERE id = :id";
        }
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":nome", $produto->getNome());
        $statement->bindValue(":descricao", $produto->getDescricao());
        $statement->bindValue(":categoria", $produto->getCategoria()->getId());
        $statement->bindValue(":valor", $produto->getValor());
        if ($produto->getImagem() != ""){
            $statement->bindValue(":imagem", $produto->getImagem());
        }
        $statement->bindValue(":id", $produto->getId());
        return $statement->execute();
    }

    public function getProduto($id){
        $produto = new Produto();
        $sql = "SELECT p.*, c.descricao AS categoria FROM produto p INNER JOIN categoria c ON c.id = p.categoria_id WHERE p.id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($retornoBanco as $row){
            $produto = $this->preencherProduto($row);
        }
        return $produto;
    }

    public function delete($id){
        $sql = "DELETE FROM produto WHERE id = :id";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":id", $id);
        return $statement->execute();
    }
}