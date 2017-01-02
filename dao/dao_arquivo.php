<?php

/**
 * Description of dao_usuario
 *
 * @author Alexandre
 */
class dao_arquivo {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/Conexao.php';
        require_once dirname(__FILE__) . '/Mensagens.php';
        // opening db connection
        $db = new Conexao();
        $this->conn = $db->conectar();
    }

    public function inserir_backup($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $titulo = $param->titulo;
        $disciplina = $param->disciplina;
        $descricao = $param->descricao;
        $usuario = $param->usuario;
        $link = $param->link;
        // comando SQL
        $sql = "insert into arquivo(titulo, disciplina, descricao, link, usuario) values ("
                . "'$titulo','$disciplina','$link','$descricao','$usuario')";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            $resposta["erro"] = false;
            $resposta["mensagem"] = ARQUIVO_INSERIDO_SUCESSO;
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $resposta["erro"] = true;
            $resposta["mensagem"] = $error;
        }
        // retorna a resposta da execução do comando SQL
        return $resposta;
    }

    public function inserir($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $titulo = $param[0];
        $disciplina = $param[1];
        $descricao = $param[2];
        $usuario = $param[3];
        $link = $param[4];
        // comando SQL
        $sql = "insert into arquivo(titulo, disciplina, descricao, link, usuario) values ("
                . "'$titulo','$disciplina','$link','$descricao','$usuario')";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            $resposta["erro"] = false;
            $resposta["mensagem"] = ARQUIVO_INSERIDO_SUCESSO;
        } else {
            // caso ocorra algum erro na execução, será informado o através do error MySQL
            $error = mysqli_error($this->conn);
            $resposta["erro"] = true;
            $resposta["mensagem"] = $error;
        }
        // retorna a resposta da execução do comando SQL
        return $resposta;
    }

    public function deletar_id($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param->id;
        // comando SQL
        $sql = "delete from arquivo where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = ARQUIVO_DELETADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = ARQUIVO_DELETADO_FRACASSO;
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

    public function atualizar_id($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param->id;
        $titulo = $param->titulo;
        $disciplina = $param->disciplina;
        $descricao = $param->descricao;
        // comando SQL
        $sql = "update arquivo set titulo='$titulo', disciplina='$disciplina', descricao='$descricao' where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = ARQUIVO_ATUALIZADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = ARQUIVO_ATUALIZADO_FRACASSO;
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

    public function get_id($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param['id'];
        // comando SQL
        $sql = "select * from arquivo where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $response = mysqli_fetch_assoc($status_sql);
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

    public function get_ultimo() {
        // retorno
        $response = array();
        // comando SQL
        $sql = "select max(id) from arquivo";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $response["erro"] = false;
                $response["mensagem"] = mysqli_fetch_assoc($status_sql)['max(id)'];
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

    public function get_idUsuario($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $usuario = $param['id'];
        // comando SQL
        $sql = "select * from arquivo where usuario='$usuario'";
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

    public function get_titulo($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $titulo = $param['titulo'];
        // comando SQL
        $sql = "select * from arquivo where titulo like '%$titulo%'";
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
