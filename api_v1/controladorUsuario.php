<?php

/**
 * Description of controlador_usuario
 *
 * @author Alexandre
 */
require_once '../dao/daoUsuario.php';

class controladorUsuario {

    protected $ci;
    private $dao;

    public function __construct(Interop\Container\ContainerInterface $ci) {
        include_once dirname(__FILE__) . '/API_KEY.php';
        $this->ci = $ci;
        $this->dao = new daoUsuario();
    }

    public function inserir($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->checkParametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                // verifica se o email já existe
                $check_email = $this->dao->getEmailCheck($param->email);
                if ($check_email) {
                    $resposta["erro"] = true;
                    $resposta["mensagem"] = 'Email já cadastrado.';
                    return $response->withJson($resposta);
                } else {
                    return $response->withJson($this->dao->inserir($param));
                }
            } else {
                return $response->withJson($check);
            }
            return $response->withJson($param);
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function deletarPorId($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->checkParametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->deletarPorId($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function deletarPorEmail($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->checkParametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->deletarPorEmail($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function atualizarPorId($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->checkParametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->atualizarPorId($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function atualizarPorEmail($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            if (sizeof($param) == 6) {
                // faz o checkup se todos os parâmetros foram preenchidos
                $check = $this->checkParametros($param);
                // caso o retorno do check seja vazio, indica que não possui erro
                if (empty($check)) {
                    return $response->withJson($this->dao->atualizarPorEmail($param));
                } else {
                    return $response->withJson($check);
                }
            } else {
                $resposta["erro"] = true;
                $resposta["mensagem"] = 'Número de parâmetros inválidos';
                return $response->withJson($resposta);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function getPorId($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = $request->getQueryParams();
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->checkParametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->getPorId($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function getPorEmail($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = $request->getQueryParams();
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->checkParametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->getPorEmail($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function checkParametros($parametros) {
        // recebe o array com os parametros de erro de campos vazios e salva-os em variaveis separadas
        $checkup = $this->getTextoErro($parametros);
        $erro = $checkup['erro'];
        $campos_vazios = $checkup['campos_vazios'];
        $quantidade = $checkup['quantidade'];
        // array que salva a array com as informações, será vazio caso não tenha erro
        $r = array();
        // caso ocorra algum erro (campo vazio) será formatado para a resposta JSON
        if ($erro) {
            $r['erro'] = $erro;
            if ($quantidade > 1) {
                $r['mensagem'] = 'Os seguintes campos estão vazios:' . $campos_vazios;
            } else {
                $r['mensagem'] = 'O seguinte campo esta vazio:' . $campos_vazios;
            }
        }
        return $r;
    }

    public function getTextoErro($parametros) {
        // salva a informação de que existe parâmetro vazio, ou seja, ocorreu algum erro
        $bool = false;
        // salva a quantidade de campos vazios, necessário para formar a frase no singular e no plural
        $qnt = 0;
        // salva os textos dos campos vazios
        $campos_vazios = "";
        // realiza a varredura por todos os parâmetros para verificar qual deles está vazio
        foreach ($parametros as $key => $value) {
            if ($value == '' || sizeof($value) == 0) {
                // caso esteja vazio, pega o nome do parâmetro e concatena com a frase
                $campos_vazios .= ' ' . $key . ',';
                // seta a variável informando que possui parâmetros vazios
                $bool = true;
                // incrementa a quantidade de campos vazios
                $qnt++;
            }
        }
        // deleta a última vírgula da frase que veio da varredura
        $msg_formadata = substr($campos_vazios, 0, -1);
        $array = array('erro' => $bool,
            'campos_vazios' => $msg_formadata,
            'quantidade' => $qnt);
        return $array;
    }

}
