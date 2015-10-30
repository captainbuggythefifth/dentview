<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer_care_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='customer_care';
                  
            //$this->load->library('encrypt');
      }
      
      function get_customer_care_by_id($customer_care_id)
      {
          $this->db->where('id',$customer_care_id);
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function insert($customer_care_info)
      {
       
          $result = $this->db->insert($this->table,$customer_care_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function update($customer_care_info)
      {
          $this->db->where('id',$customer_care_info['id']);
          $result = $this->db->update($this->table,$customer_care_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function get_all()
      {
          $this->db->order_by('date',"asc");
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function get_all_active()
      {
          $this->db->order_by('date',"asc");
          $this->db->where('status',"ACTIVE");
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function get_all_inactive()
      {
          $this->db->order_by('date',"asc");
          $this->db->where('status',"INACTIVE");
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      
}
?>
