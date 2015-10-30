<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tooth_adult_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='tooth_adult';
                  
            //$this->load->library('encrypt');
      }
      
      function get_tooth_adult_by_patient_id($patient_id)
      {
          $this->db->where('patient_id',$patient_id);
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function insert($tooth_adult_info)
      {
       
          $result = $this->db->insert($this->table,$tooth_adult_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function update($tooth_info)
      {
          $this->db->where('patient_id',$tooth_info['patient_id']);
          $result = $this->db->update($this->table,$tooth_info);
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