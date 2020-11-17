<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Transaksi extends REST_Controller{

    function __construct($config = "rest"){
        parent::__construct($config);
        $this->load->database();
    }

    public function index_get(){

        $id = $this->get('id');
        $transaksi=[];
        if($id == ''){
            $data = $this->db->get('nation')->result();
            foreach($data as $row=>$key):
                $garden[]=["nationid"=>$key->nationid,
                            "country"=>$key->country,
                            "climate"=>$key->climate,
                            "_links"=>[(object)["href"=>"nation/{$key->nationid}",
                                        "rel"=>"flower",
                                        "type"=>"GET"]],
                        ];
                    endforeach;
        }else{
            $this->db->where('nationid', $id);
            $nation = $this->db->get('nation')->result();
        }
        $result=["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                 "code"=>200,
                 "message"=>"Response Successfully",
                 "data"=>$nation];
        $this->response($result, 200);
    }

    public function index_post(){
        $data = array(
                    'nationid' => $this->post('nationid'),
                    'country' => $this->post('country'),
                    'climate' => $this->post('climate'),
                    'flowerid'=>$this->post('flowerid'));
        $insert = $this->db->insert('nation', $data);
        if($insert){
            $result = ["took" => $_SERVER["REQUEST_TIME_FLOAT"],
                       "code"=>201,
                       "message"=>"Data has successfully added",
                       "data"=>$data];
            $this->response($result, 201);
        }else{
            $result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
                       "code"=>502,
                       "message"=>"Failed adding data",
                       "data"=>null];
            $this->response($result, 502);
        }
    }

    function index_put(){
      $id = $this->get('id');
      $data = array(
                  'nationid' => $this->put('nationid'),
                  'country' => $this->put('country'),
                  'climate' => $this->put('climate'),
                  'flowerid' => $this->put('flowerid'));
      $this->db->where('nationid', $id);
      $update = $this->db->update('transaknationsi', $data);
      if($update){
          $this->response($data, 200);
      } else{
          $this->response(array('status' => 'fail', 502));
      }
    }
  

    function index_delete() {
        $id = $this->get('id');
        $this->db->where('nationid', $id);
        $delete = $this->db->delete('nation');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else{
            $this->response(array('status' => 'fail', 502));
        }
    }
}

?>