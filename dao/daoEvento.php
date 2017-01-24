<?php

/**
 * Description of dao_usuario
 *
 * @author Alexandre
 */
class daoEvento {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/Conexao.php';
        require_once dirname(__FILE__) . '/Mensagens.php';
        // opening db connection
        $db = new Conexao();
        $this->conn = $db->conectar();
    }

    public function inserir($param) {
        $titulo = $param->titulo;
        $descricao = $param->descricao;
        $usuario = $param->usuario;
        $data = $param->data;
        // comando SQL
        $sql = "insert into evento(usuario, titulo, descricao, data) values ("
                . "'$usuario','$titulo','$descricao','$data')";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            $resposta["erro"] = false;
            $resposta["mensagem"] = EVENTO_INSERIDO_SUCESSO;
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
        $sql = "delete from evento where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = EVENTO_DELETADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = EVENTO_DELETADO_FRACASSO;
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
        $titulo = $param->titulo;
        $descricao = $param->descricao;
        $data = $param->data;
        // comando SQL
        $sql = "update evento set titulo='$titulo', data='$data', descricao='$descricao' where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = EVENTO_ATUALIZADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = EVENTO_ATUALIZADO_FRACASSO;
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
        $sql = "select * from evento where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $response = mysqli_fetch_assoc($status_sql);
            } else {
                $response["erro"] = false;
                $response["mensagem"] = EVENTO_NAO_ENCONTRADO;
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
        $sql = "select * from evento where usuario='$usuario'";
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
                $response["mensagem"] = ARQUIVO_NAO_ENCONTRADO;
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

    public function getPorTitulo($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $titulo = $param['titulo'];
        // comando SQL
        $sql = "select * from evento where titulo like '%$titulo%'";
        // execução do comando SQL e guarda seu STATUS de execução
        mysqli_set_charset($this->conn, 'UTF-8');
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
                $response["mensagem"] = ARQUIVO_NAO_ENCONTRADO;
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
