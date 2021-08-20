<?php
require_once "./controllers/Conexao.php";
require_once "./models/Produto.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Carrinho de Compras</title>
</head>

<body>
<div align="center">
    <table cellSpacing=1 cellPadding=0 width="50%" align=center border=0>
        <tr>
            <td>
                <?php
                //*********************************************************************
                // GERA A INSTRUÇÃO SQL E CHAMA A FUNÇÃO PARA GERAR AS COLUNAS
                //*********************************************************************
                $sql = "SELECT produto ORDER BY RAND() LIMIT 0,4";
                GeraColunas(2, $sql)
                ?>
            </td>
        </tr>
    </table>
    <?php
    //*********************************************************************
    // FUNÇÃO: GERACOLUNAS
    // Parametros:
    //  $pNumColunas (int)   > Quant. de colunas para distribuição
    //  $pQuery    (string) > Query de registros
    //*********************************************************************
    function GeraColunas($pNumColunas, $pQuery) {
        $resultado = PDO :: query ($pQuery);
        echo ("<table width='100%' border='0'>\n");
        for($i = 0; $i <= PDOStatement :: rowCount ()($resultado); ++$i) {

            for ($intCont = 0; $intCont < $pNumColunas; $intCont++) {
                $linha = PDOStatement :: fetch ($resultado);
                if ($i > $linha) {
                    if ( $intCont < $pNumColunas-1) echo "</tr>\n";
                    break;
                }

                $id = $linha[0];
                $nome = $linha[1];
                $imagem = $linha[2];
                $valor = number_format($linha[3],2,",",".");

                if ( $intCont == 0 ) echo "<tr>\n";
                echo "<td>";
                // Aqui você inclui o conteudo
                echo "<table width='266' border='0' cellspacing='0' cellpadding='0'>";
                echo "<tr>";
                echo "<td width='250' height='141' valign='middle'><div align='center'><img src='produtos/".$imagem."' border='0' width='189' height='141' /></div></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>";
                echo "<table width='92%' border='0' align='center' cellpadding='0' cellspacing='0'>";
                echo "<tr>";
                echo "<td><div align='center' style='font-size:10px;font-family:Verdana'><strong><a href='carrinho.php?cod=".$id."&acao=incluir'>".$nome."</a></strong></div><strong><div align='center'><font color='#FF0000' size='4px'> R$ ".$valor." </font></strong></div></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td><div align='center' style='font-size:10px;font-family:Verdana'><a href='carrinho.php?cod=".$id."&acao=incluir'><img src='imgs/add_carrinho.jpg' border='0'/></a></div><br></td>";
                echo "</tr>";
                echo "</table>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                // Aqui é o final do conteudo
                echo "</td>";

                if ( $intCont == $pNumColunas-1 ) {
                    echo "</tr>\n";
                } else { $i++; }
            }

        }
        echo ('</table>');
    }

    ?>
</div>
</body>
</html>