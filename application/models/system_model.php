<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class system_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='system';
                  
            //$this->load->library('encrypt');
      }
      function insert($system_info)
      {
       
          $result = $this->db->insert($this->table,$system_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function update($system_info)
      {
          $this->db->where('id',$system_info['id']);
          $result = $this->db->update($this->table,$system_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function get_date($date)
      {
          $this->db->where('date',$date);
          $this->db->where('status','ACTIVE');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function get_date_active_or_inactive($date)
      {
          $this->db->where('date',$date);
          $result = $this->db->get($this->table);
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_system_time($system_id)
      {
          $this->db->where('id',$system_id);
          //s$this->db->where('status','ACTIVE');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function get_date_active_or_inactive_by_doctor($date, $doctor_id)
      {
          $this->db->where('date',$date);
          $this->db->where('doctor_id',$doctor_id);
          $result = $this->db->get($this->table);
          if($result)
            return $result->result_array();
          else
            return false;
      }
}
?>