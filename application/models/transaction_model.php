<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transaction_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='transaction';
                  
            //$this->load->library('encrypt');
      }
      
      function get_transaction_by_patient_id($patient_id)
      {
          $this->db->where('patient_id',$patient_id);
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function insert($transaction_info)
      {
       
          $result = $this->db->insert($this->table,$transaction_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function update($transaction_info)
      {
          $this->db->where('patient_id',$transaction_info['patient_id']);
          $result = $this->db->update($this->table,$transaction_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
}
?>