<?php

require '../vendor/autoload.php';
require_once './controlador_usuario.php';
require_once './controlador_arquivo.php';
require_once './controlador_evento.php';
require_once './controlador_disciplina.php';

$app = new Slim\App();

// MÉTODOS USUÁRIO
$app->group('/usuario', function () {
    $this->post('/inserir', 'controlador_usuario:inserir');
    $this->delete('/deletar_id', 'controlador_usuario:deletar_id');
    $this->delete('/deletar_email', 'controlador_usuario:deletar_email');
    $this->put('/atualizar_id', 'controlador_usuario:atualizar_id');
    $this->put('/atualizar_email', 'controlador_usuario:atualizar_email');
    $this->get('/get_id', 'controlador_usuario:get_id');
    $this->get('/get_email', 'controlador_usuario:get_email');
});

// MÉTODOS ARQUIVO
$app->group('/arquivo', function () {
    $this->post('/inserir', 'controlador_arquivo:inserir');
    $this->delete('/deletar_id', 'controlador_arquivo:deletar_id');
    $this->put('/atualizar_id', 'controlador_arquivo:atualizar_id');
    $this->get('/get_id', 'controlador_arquivo:get_id');
    $this->get('/get_idUsuario', 'controlador_arquivo:get_idUsuario');
    $this->get('/get_titulo', 'controlador_arquivo:get_titulo');
    $this->post('/inserir_arquivo', 'controlador_arquivo:inserir_arquivo');
});

// MÉTODOS EVENTO
$app->group('/evento', function () {
    $this->post('/inserir', 'controlador_evento:inserir');
    $this->delete('/deletar_id', 'controlador_evento:deletar_id');
    $this->put('/atualizar_id', 'controlador_evento:atualizar_id');
    $this->get('/get_id', 'controlador_evento:get_id');
    $this->get('/get_idUsuario', 'controlador_evento:get_idUsuario');
    $this->get('/get_titulo', 'controlador_evento:get_titulo');
});

// MÉTODOS DISCIPLINA
$app->group('/disciplina', function () {
    $this->post('/inserir', 'controlador_disciplina:inserir');
    $this->delete('/deletar_id', 'controlador_disciplina:deletar_id');
    $this->put('/atualizar_id', 'controlador_disciplina:atualizar_id');
    $this->get('/get_id', 'controlador_disciplina:get_id');
    $this->get('/get_idUsuario', 'controlador_disciplina:get_idUsuario');
    $this->get('/get_titulo', 'controlador_disciplina:get_titulo');
});

$app->run();
