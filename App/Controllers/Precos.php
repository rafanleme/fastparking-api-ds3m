<?php

use App\Core\Controller;

class Precos extends Controller{

    public function index(){
        $precoModel = $this->model("Preco");

        $preco = $precoModel->getUltimoInserido();

        if (!$preco) {
            http_response_code(204);
            exit;
        }

        echo json_encode($preco, JSON_UNESCAPED_UNICODE);
    }

    public function store(){
        $novoPreco = $this->getRequestBody();

        $precoModel = $this->model("Preco");
        $precoModel->primeiraHora = $novoPreco->primeira_hora;
        $precoModel->demaisHoras = $novoPreco->demais_horas;

        $precoModel = $precoModel->inserir();

        if ($precoModel) {
            http_response_code(201); //created
            echo json_encode($precoModel);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problemas ao inserir preco"]);
        }
    }

}