<?php

/**
 * Description of controlador_usuario
 *
 * @author Alexandre
 */
require_once '../dao/dao_evento.php';

class controlador_evento {

    protected $ci;
    private $dao;

    public function __construct(Interop\Container\ContainerInterface $ci) {
        include_once dirname(__FILE__) . '/API_KEY.php';
        $this->ci = $ci;
        $this->dao = new dao_evento();
    }

    public function inserir($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->check_parametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->inserir($param));
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

    public function deletar_id($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->check_parametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->deletar_id($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function atualizar_id($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = json_decode($request->getBody());
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->check_parametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->atualizar_id($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function get_id($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = $request->getQueryParams();
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->check_parametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->get_id($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function get_idUsuario($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = $request->getQueryParams();
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->check_parametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->get_idUsuario($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function get_titulo($request, $response) {
        // verfica se está autorizado
        $aut = $request->getHeader('Authorization');
        if ($aut[0] == AUTH) {
            // pega os parametros do corpo da solicitação HTTP
            $param = $request->getQueryParams();
            // faz o checkup se todos os parâmetros foram preenchidos
            $check = $this->check_parametros($param);
            // caso o retorno do check seja vazio, indica que não possui erro
            if (empty($check)) {
                return $response->withJson($this->dao->get_titulo($param));
            } else {
                return $response->withJson($check);
            }
        } else {
            $resposta["erro"] = true;
            $resposta["mensagem"] = 'Comando não autorizado.';
            return $response->withJson($resposta);
        }
    }

    public function check_parametros($parametros) {
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
