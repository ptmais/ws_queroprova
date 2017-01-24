<?php

require '../vendor/autoload.php';
require_once './controladorUsuario.php';
require_once './controladorArquivo.php';
require_once './controladorEvento.php';
require_once './controladorDisciplina.php';

$app = new Slim\App();

// MÉTODOS USUÁRIO
$app->group('/usuario', function () {
    $this->post('/inserir', 'controladorUsuario:inserir');
    $this->delete('/deletarPorId', 'controladorUsuario:deletarPorId');
    $this->delete('/deletarPorEmail', 'controladorUsuario:deletarPorEmail');
    $this->put('/atualizarPorId', 'controladorUsuario:atualizarPorId');
    $this->put('/atualizarPorEmail', 'controladorUsuario:atualizarPorEmail');
    $this->get('/getPorId', 'controladorUsuario:getPorId');
    $this->get('/getPorEmail', 'controladorUsuario:getPorEmail');
});

// MÉTODOS ARQUIVO
$app->group('/arquivo', function () {
    $this->post('/inserirBd', 'controladorArquivo:inserirBd');
    $this->post('/inserirServidor', 'controladorArquivo:inserirServidor');
    $this->delete('/deletarPorId', 'controladorArquivo:deletarPorId');
    $this->put('/atualizarPorId', 'controladorArquivo:atualizarPorId');
    $this->get('/getPorId', 'controladorArquivo:getPorId');
    $this->get('/getPorIdUsuario', 'controladorArquivo:getPorIdUsuario');
    $this->get('/getPorTitulo', 'controladorArquivo:getPorTitulo');
});

// MÉTODOS EVENTO
$app->group('/evento', function () {
    $this->post('/inserir', 'controladorEvento:inserir');
    $this->delete('/deletarPorId', 'controladorEvento:deletarPorId');
    $this->put('/atualizarPorId', 'controladorEvento:atualizarPorId');
    $this->get('/getPorId', 'controladorEvento:getPorId');
    $this->get('/getPorIdUsuario', 'controladorEvento:getPorIdUsuario');
    $this->get('/getPorTitulo', 'controladorEvento:getPorTitulo');
});

// MÉTODOS DISCIPLINA
$app->group('/disciplina', function () {
    $this->post('/inserir', 'controladorDisciplina:inserir');
    $this->delete('/deletarPorId', 'controladorDisciplina:deletarPorId');
    $this->put('/atualizarPorId', 'controladorDisciplina:atualizarPorId');
    $this->get('/getPorId', 'controladorDisciplina:getPorId');
    $this->get('/getPorIdUsuario', 'controladorDisciplina:getPorIdUsuario');
    $this->get('/getPorTitulo', 'controladorDisciplina:getPorTitulo');
});

$app->run();
