<?php

$conn = mysqli_connect(
    "localhost",
    "usuario",
    "senha",
    "nome_do_banco"
);

if(!$conn){
    die("Erro ao conectar");
}
