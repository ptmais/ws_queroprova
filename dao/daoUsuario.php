<?php

/**
 * Description of dao_usuario
 *
 * @author Alexandre
 */
class daoUsuario {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/Conexao.php';
        require_once dirname(__FILE__) . '/Mensagens.php';
        // opening db connection
        $db = new Conexao();
        $this->conn = $db->conectar();
    }

    public function inserir($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $nome = $param->nome;
        $sobrenome = $param->sobrenome;
        $email = $param->email;
        $senha = sha1($param->senha);
        $gcm_code = $param->gcm_code;
        // comando SQL
        $sql = "insert into usuario(nome, sobrenome, email, senha, gcm_code) values ("
                . "'$nome','$sobrenome','$email','$senha','$gcm_code')";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            $resposta["erro"] = false;
            $resposta["mensagem"] = USUARIO_INSERIDO_SUCESSO;
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
        $sql = "delete from usuario where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = USUARIO_DELETADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = USUARIO_DELETADO_FRACASSO;
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

    public function deletarPorEmail($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $email = $param->email;
        // comando SQL
        $sql = "delete from usuario where email='$email'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = USUARIO_DELETADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = USUARIO_DELETADO_FRACASSO;
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
        $sobrenome = $param->sobrenome;
        $email = $param->email;
        $senha = sha1($param->senha);
        $gcm_code = $param->gcm_code;
        // comando SQL
        $sql = "update usuario set nome='$nome', sobrenome='$sobrenome', email='$email', senha='$senha',"
                . "gcm_code='$gcm_code' where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = USUARIO_ATUALIZADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = USUARIO_ATUALIZADO_FRACASSO;
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

    public function atualizarPorEmail($param) {
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $id = $param->id;
        $nome = $param->nome;
        $sobrenome = $param->sobrenome;
        $email = $param->email;
        $senha = sha1($param->senha);
        $gcm_code = $param->gcm_code;
        // comando SQL
        $sql = "update usuario set nome='$nome', sobrenome='$sobrenome', email='$email', senha='$senha',"
                . "gcm_code='$gcm_code' where email='$email'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução tenha ocorrido com sucesso, o STATUS será 1
        if ($status_sql > 0) {
            if (mysqli_affected_rows($this->conn) > 0) {
                $resposta["erro"] = false;
                $resposta["mensagem"] = USUARIO_ATUALIZADO_SUCESSO;
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = USUARIO_ATUALIZADO_FRACASSO;
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
        $sql = "select * from usuario where id='$id'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $response = mysqli_fetch_assoc($status_sql);
            } else {
                $response["erro"] = false;
                $response["mensagem"] = USUARIO_NAO_ENCONTRADO;
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

    public function getPorEmail($param) {
        // retorno
        $response = array();
        // coleta dos parâmetros e salva cada um deles em variaveis separadas
        $email = $param['email'];
        // comando SQL
        $sql = "select * from usuario where email='$email'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                $response = mysqli_fetch_assoc($status_sql);
            } else {
                $response["erro"] = false;
                $response["mensagem"] = USUARIO_NAO_ENCONTRADO;
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

    public function getEmailCheck($email) {
        // comando SQL
        $sql = "select id from usuario where email='$email'";
        // execução do comando SQL e guarda seu STATUS de execução
        $status_sql = mysqli_query($this->conn, $sql);
        // caso a execução não tenha ocorrido algum erro
        if (!mysqli_errno($this->conn)) {
            if (mysqli_num_rows($status_sql) > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

}
