<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class prescription_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
            parent::__construct();
            $this->table='prescription';
           
      }
      
      
      function insert($prescription_info)
      {
          //print_r($prescription_info);
          $result = $this->db->insert($this->table,$prescription_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function get_prescription($prescription_id)
      {
          $this->db->where('id',$prescription_id);
          //$this->db->order_by('date','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function update($prescription_info)
      {
          $this->db->where('id',$prescription_info['id']);
          
          $result =  $this->db->update($this->table,$prescription_info);
          if($result)
              return $result;
          else
              return false;
      }
      
      function get_all()
      {
         $result = $this->db->get($this->table);
         if( $result->num_rows > 0 )
         {
               return $result->result_array();
         }
         else
         {
               return false;
         }
      }
      
}
?>