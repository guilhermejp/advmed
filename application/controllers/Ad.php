<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ad extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ad_model');
        $this->load->model('Advertiser_model');
    }

    public function create() {
        $post = $this->input->post();
        if (!isset($post['status']) || !isset($post['value']) || !isset($post['id_advertiser'])) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Todos os dados são obrigatórios: status, value, id_advertiser!';
            echo json_encode($this->return);
            return false;
        }

        if ($post['status'] != "0" && $post['status'] != "1") {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Status deve ser 0 - desativo, 1 - ativo!';
            echo json_encode($this->return);
            return false;
        }
        
        if (!is_numeric($post['value'])) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'O valor deve ser numérico. ex.: 0.00 !';
            echo json_encode($this->return);
            return false;
        }

        $advertiser = $this->Advertiser_model->get($post['id_advertiser']);
        if (!is_object($advertiser)) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'O código do Anunciante não existe cadastrado, verifique o código correto!';
            echo json_encode($this->return);
            return false;
        }

        $insert = array("status" => $post['status'], "value" => $post['value'], "id_advertiser" => $post['id_advertiser']);
        $id = $this->Ad_model->insert($insert);

        if (!$id) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Erro ao efetuar ao inserir: mysql=>' . $this->db->_error_message();
            $this->return['id'] = $id;
            echo json_encode($this->return);
            return true;
        }

        $this->return['flag'] = 'true';
        $this->return['message'] = 'Anúncio cadastrado com sucesso!';
        $this->return['id'] = $id;
        echo json_encode($this->return);
        return true;
    }
    
    public function update_status() {
        $post = $this->input->post();
        if (!isset($post['id']) || !isset($post['status'])) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Campos obrigatório para atualização: id, status!';
            echo json_encode($this->return);
            return false;
        }
        
        if ($post['status'] != "0" && $post['status'] != "1") {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Status deve ser 0 - desativo, 1 - ativo!';
            echo json_encode($this->return);
            return false;
        }

        $update = array("status" => $post['status']);
        $result = $this->Ad_model->update($update, $post['id']);
        if ($this->db->error()['code'] > 0) {
            $this->return['flag'] = 'false';
            $this->return['message'] = 'Erro ao atualizar: mysql=>' . $this->db->error()['message'];
            echo json_encode($this->return);
            return true;
        }

        $this->return['flag'] = 'true';
        $this->return['message'] = $result > 0 ? 'Status do anuncio atualizado com sucesso!' : 'Nenhum registro alterado!';
        $this->return['affected_rows'] = $result;
        echo json_encode($this->return);
        return true;
    }

}
