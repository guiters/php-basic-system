<?php
include './phpforms.class.php'; //Chamo o modulo do formulario

$form = new form(); //inicio a classe


$form->configdatabase('usuario', 'configdatabase.json'); //leio o arquivo com todas as tabelas para a instalacao na base de dados
//$form->requetwait($_POST, 'usuario'); // fico aguardando os posts

//Configuro os inputs
$inputs = [
    [
        'id' => 'nome',
        'label' => 'Nome',
        'type' => 'text',
        'placeholder' => 'Nome',
    ]
    , [
        'id' => 'sobrenome',
        'label' => 'Sobrenome',
        'type' => 'text',
        'name' => 'last_name',
        'placeholder' => 'Sobrenome',
    ]
];

// mostro o formulario
echo $form->newform($inputs, 'POST', 'teste_new', 'cadastrar');
