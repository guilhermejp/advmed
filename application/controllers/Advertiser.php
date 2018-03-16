<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Advertiser extends CI_Controller {

    private $return = array('flag' => 'true', 'message' => '');

    public function __construct() {
        parent::__construct();
        $this->load->model('Advertiser_model');
        $this->load->model('Ad_model');
    }

    public function create() {
        $post = $this->input->post();
        if (!isset($post['name']) || $post['name'] == "" || !isset($post['address']) || !isset($post['phone'])) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Todos os dados são obrigatórios: name, address, phone!';
            echo json_encode($this->return);
            return false;
        }

        $insert = array("name" => $post['name'], "address" => $post['address'], "phone" => $post['phone']);
        $id = $this->Advertiser_model->insert($insert);

        if (!$id) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Erro ao efetuar ao inserir: mysql=>' . $this->db->_error_message();
            $this->return['id'] = $id;
            echo json_encode($this->return);
            return true;
        }

        $this->return['flag'] = 'true';
        $this->return['message'] = 'Anuciante cadastrado com sucesso!';
        $this->return['id'] = $id;
        echo json_encode($this->return);
        return true;
    }

    public function read() {
        $post = $this->input->post();

        if (!isset($post['id'])) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Deve ser informado um critério de busca, [id] ou [all] para todos registros!';
            echo json_encode($this->return);
            return false;
        }

        if (strtolower($post['id']) == "all") {
            $result = $this->Advertiser_model->get_all();
            if ($this->db->error()['code'] > 0) {
                $this->return['flag'] = 'false';
                $this->return['message'] = 'Erro ao excluir: mysql=>' . $this->db->error()['message'];
                echo json_encode($this->return);
                return true;
            }

            $this->return['flag'] = 'true';
            $this->return['message'] = is_object($result) === TRUE ? count($result) . ' registros retornados com sucesso' : 'Não há registro a listar.';
            $this->return['affected_rows'] = is_object($result) === TRUE ? count($result) : "0";
            $this->return['result'] = $result;
            echo json_encode($this->return);
            return false;
        } else {
            $result = $this->Advertiser_model->get($post['id']);
            if ($this->db->error()['code'] > 0) {
                $this->return['flag'] = 'false';
                $this->return['message'] = 'Erro ao excluir: mysql=>' . $this->db->error()['message'];
                echo json_encode($this->return);
                return true;
            }

            $this->return['flag'] = 'true';
            $this->return['message'] = is_object($result) === TRUE ? count($result) . ' registros retornados com sucesso' : 'Não há registro a listar.';
            $this->return['affected_rows'] = is_object($result) === TRUE ? count($result) : "0";
            $this->return['result'] = $result;
            echo json_encode($this->return);
            return false;
        }
    }

    public function update() {
        $post = $this->input->post();
        if (!isset($post['id']) || $post['id'] == "" || !isset($post['name']) || $post['name'] == "" || !isset($post['address']) || !isset($post['phone'])) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Todos os campos são obrigatório para atualização: id, name, address, phone!';
            echo json_encode($this->return);
            return false;
        }

        $update = array("name" => $post['name'], "address" => $post['address'], "phone" => $post['phone']);
        $result = $this->Advertiser_model->update($update, $post['id']);
        if ($this->db->error()['code'] > 0) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Erro ao atualizar: mysql=>' . $this->db->error()['message'];
            echo json_encode($this->return);
            return true;
        }

        $this->return['flag'] = 'true';
        $this->return['message'] = $result > 0 ? 'Anuciante atualizado com sucesso!' : 'Nenhum registro alterado!';
        $this->return['affected_rows'] = $result;
        echo json_encode($this->return);
        return true;
    }

    public function delete() {
        $post = $this->input->post();

        if (!isset($post['id']) || $post['id'] == "") {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Deve ser informado o [id] do anunciate para exclusão!';
            echo json_encode($this->return);
            return false;
        }

        $result = $this->Advertiser_model->delete($post['id']);
        if ($this->db->error()['code'] > 0) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Erro ao excluir: mysql=>' . $this->db->error()['message'];
            echo json_encode($this->return);
            return true;
        }

        $this->return['flag'] = 'true';
        $this->return['message'] = $result > 0 ? 'Anuciante excluído com sucesso!' : 'Nenhum registro excluído!';
        $this->return['affected_rows'] = $result;
        echo json_encode($this->return);
        return false;
    }

    public function payment() {
        $result = $this->Advertiser_model->value_pay_by_advertiser();
        if ($this->db->error()['code'] > 0) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Erro ao excluir: mysql=>' . $this->db->error()['message'];
            echo json_encode($this->return);
            return true;
        }

        $this->return['flag'] = 'true';
        $this->return['message'] = is_array($result) === TRUE ? count($result) . ' registros retornados com sucesso' : 'Não há registro a listar.';
        $this->return['affected_rows'] = is_array($result) === TRUE ? count($result) : "0";
        $this->return['result'] = json_encode($result);
        echo json_encode($this->return);
        return false;
    }

}
