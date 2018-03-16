<?php

class Advertiser_model extends MY_Model {

    public $table = 'advertiser'; // you MUST mention the table name
    public $primary_key = 'id'; // you MUST mention the primary key
    public $fillable = array(); // If you want, you can set an array with the fields that can be filled by insert/update
    public $protected = array(); // ...Or you can set an array with the fields that cannot be filled by insert/update

    public function __construct() {
        $this->has_many['ad'] = array('foreign_model' => 'Ad_model', 'foreign_table' => 'ad', 'foreign_key' => 'id_advertiser', 'local_key' => 'id');
        parent::__construct();
        $this->timestamps = FALSE;
    }

    public function value_pay_by_advertiser() {
        $query = "SELECT a.name, SUM(ad.value) FROM `advertiser` as a
                    INNER JOIN `ad` as ad
                    ON ad.id_advertiser = a.id
                    WHERE ad.status = '1'
                    GROUP BY a.id";
        
         $result = $this->db->query($query);
         return $result->result_array();
        
    }

}

?>