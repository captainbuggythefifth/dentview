<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class record_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='record';
                  
            //$this->load->library('encrypt');
      }
      
      function get_record_by_patient_id($patient_id)
      {
          $this->db->where('patient_id',$patient_id);
          $this->db->order_by('date','desc');
          $this->db->limit(5);
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function insert($record_info)
      {
       
          $result = $this->db->insert($this->table,$record_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function get_record($record_id)
      {
          $this->db->where('id',$record_id);
          //$this->db->order_by('date','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function update($record_info)
      {
          $this->db->where('id',$record_info['id']);
          
          $result =  $this->db->update($this->table,$record_info);
          if($result)
              return $result;
          else
              return false;
      }
      
      
      function get_record_by_patient_id_and_date($patient_id,$date)
      {
          $this->db->where('patient_id',$patient_id);
          $this->db->like('date', $date);
          $this->db->order_by('date','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function ordering($record_info)
      {
          $new_record = array();
          for($i=0;$i<count($record_info);$i++)
          {
              
              for($j=0;$j<count($record_info);$i++)
              {
                  $date = $record_info[$i]['date'][3].$record_info[$i]['date'][4];
                  $new_date = $record_info[$i]['date'][3].$record_info[$i]['date'][4];
              }
          }
      }
}
?>