<?php

use App\Core\Model;

class Cliente{

    public $id;
    public $nomeCliente;
    public $placaCarro;
    public $dataHoraEntrada;
    public $dataHoraSaida;
    public $valorTotal;
    public $precoId;

    public function listarTodos(){
        $sql = " SELECT * FROM cliente ORDER BY id DESC ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultado;
        } else {
            return [];
        }
    }

    public function inserir(){
        $sql = " INSERT INTO cliente (nome_cliente, placa_carro, data_hora_entrada, preco_id) VALUES (?, ?, ?, ?) ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nomeCliente);
        $stmt->bindValue(2, $this->placaCarro);
        $stmt->bindValue(3, $this->dataHoraEntrada);
        $stmt->bindValue(4, $this->precoId);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }
    }

    public function buscarPorId($id){
        $sql = " SELECT * FROM cliente WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $registro = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$registro) {
                return null;
            }

            $this->id = $registro->id;
            $this->nomeCliente = $registro->nome_cliente;
            $this->placaCarro = $registro->placa_carro;
            $this->dataHoraEntrada = $registro->data_hora_entrada;
            $this->dataHoraSaida = $registro->data_hora_saida;
            $this->valorTotal = $registro->valor_total;
            $this->precoId = $registro->preco_id;


            return $this;
        } else {
            return null;
        }
    }

    public function atualizar(){
        $sql = " UPDATE cliente SET data_hora_saida = ?, valor_total = ? WHERE id = ? ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->dataHoraSaida);
        $stmt->bindValue(2, $this->valorTotal);
        $stmt->bindValue(3, $this->id);

        return $stmt->execute();
    }

}