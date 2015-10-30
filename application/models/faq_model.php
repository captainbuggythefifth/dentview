<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class faq_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='faq';
      }
      
      function get_all_active()
      {
          $this->db->where('status',"ACTIVE");
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function get_all_inactive()
      {
          $this->db->where('status',"INACTIVE");
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function insert($faq_info)
      {
       
          $result = $this->db->insert($this->table,$faq_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function update($faq_info)
      {
          $this->db->where('id',$faq_info['id']);
          $result = $this->db->update($this->table,$faq_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function get_faq_by_id($faq_id)
      {
          $this->db->where('id',$faq_id);
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
}
?>