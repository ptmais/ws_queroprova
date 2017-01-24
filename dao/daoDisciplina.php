<?php

/**
 * Description of dao_usuario
 *
 * @author Alexandre
 */
class daoDisciplina {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/Conexao.php';
        require_once dirname(__FILE__) . '/Mensagens.php';
        // opening db connection
        $db = new Conexao();
        $this->conn = $db->conectar();
    }

    public function inserir($param) {
        $nome = $param->nome;
        $cor = $param->cor;
        $usuario = $param->usuario;
        // comando SQL
        $sql = "insert into disciplina(nome, cor, usuario) values ("
                . "'$nome','$cor','$usuario')";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            $resposta["erro"] = false;
            $resposta["mensagem"] = DISCIPLINA_INSERIDO_SUCESSO;
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $resposta["erro"] = true;
            $resposta["mensagem"] = $error;
        }
        // fechamando da conexão
        mysqli_close($this->conn);
        // retorna a resposta da execução do comando SQL
        return $resposta;
    }

    public function deletarPorId($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param->id;
        // comando SQL
        $sql = "delete from disciplina where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = DISCIPLINA_DELETADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = DISCIPLINA_DELETADO_FRACASSO;
            }
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $resposta["erro"] = true;
            $resposta["mensagem"] = $error;
        }
        // fechamando da conexão
        mysqli_close($this->conn);
        // retorna a resposta da execução do comando SQL
        return $resposta;
    }

    public function atualizarPorId($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param->id;
        $nome = $param->nome;
        $cor = $param->cor;
        $usuario = $param->usuario;
        // comando SQL
        $sql = "update disciplina set nome='$nome', cor='$cor', usuario='$usuario' where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = DISCIPLINA_ATUALIZADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = DISCIPLINA_ATUALIZADO_FRACASSO;
            }
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $resposta["erro"] = true;
            $resposta["mensagem"] = $error;
        }
        // fechamando da conexão
        mysqli_close($this->conn);
        // retorna a resposta da execução do comando SQL
        return $resposta;
    }

    public function getPorId($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param['id'];
        // comando SQL
        $sql = "select * from disciplina where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $response = mysqli_fetch_assoc($status_sql);
            } else {
                $response["erro"] = false;
                $response["mensagem"] = DISCIPLINA_NAO_ENCONTRADO;
            }
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $response["erro"] = true;
            $response["mensagem"] = $error;
        }
        // fechamando da conexão
        mysqli_close($this->conn);
        // retorna a resposta da execução do comando SQL
        return $response;
    }

    public function getPorIdUsuario($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $usuario = $param['id'];
        // comando SQL
        $sql = "select * from disciplina where usuario='$usuario'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $arquivos = array();
                while ($row = mysqli_fetch_assoc($status_sql)) {
                    $arquivos[] = $row;
                }
                $response = $arquivos;
            } else {
                $response["erro"] = false;
                $response["mensagem"] = DISCIPLINA_NAO_ENCONTRADO;
            }
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $response["erro"] = true;
            $response["mensagem"] = $error;
        }
        // fechamando da conexão
        mysqli_close($this->conn);
        // retorna a resposta da execução do comando SQL
        return $response;
    }

}
