<?php
require_once 'Conexao.php';
class PedidoController
{

    private static $instance;
    private $conexao;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PedidoController();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->conexao = Conexao::getInstance();
    }

    public function inserir($cliente)
    {
        $sql = "INSERT INTO pedido (cliente_id, data_pedido) VALUES (:cliente, CURRENT_DATE)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":cliente", $cliente);
        return $statement->execute();
    }

    public function getIdPedido($cliente, $data)
    {
        $pedido = null;
        $sql = "SELECT max(id) AS id FROM pedido WHERE cliente_id = :cliente AND data_pedido = :data";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":cliente", $cliente);
        $statement->bindValue(":data", $data);
        $statement->execute();
        $retornoBanco = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($retornoBanco as $row) {
            $pedido = $row['id'];
        }
        return $pedido;
    }

    public function inserirItensPedido($pedido, $produto, $quantidade, $valorProduto){
        $sql = "INSERT INTO itempedido (pedido_id, produto_id, quantidade, valor_produto) 
            VALUES (:pedido, :produto,:quantidade,:valorpoduto)";
        $statement = $this->conexao->prepare($sql);
        $statement->bindValue(":pedido", $pedido);
        $statement->bindValue(":produto", $produto);
        $statement->bindValue(":quantidade", $quantidade);
        $statement->bindValue(":valorpoduto", $valorProduto);
        return $statement->execute();
    }
}