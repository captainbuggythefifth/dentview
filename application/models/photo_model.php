<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class photo_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='photo';
      }
      
      function get_photo_by_id($photo_id)
      {
          $this->db->where('id',$photo_id);
          $result = $this->db->get($this->table);
          if( $result->num_rows > 0 )
          {
              return $result->row_array();
          }
          else
          {
              return false;
          }
          
          
      }
      
      function insert($data)
      {
          $result = $this->db->insert($this->table,$data);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function get_photo($from,$from_id)
      {
          $this->db->where('from =',$from);
          $this->db->where('from_id =',$from_id);
          $this->db->where('status =',"ACTIVE");
          $result = $this->db->get($this->table);
            if( $result->num_rows > 1 )
             {
                return $result->result_array();
             //print_r($result->result_array());
                
             }
            elseif($result->num_rows == 1) 
               {
                    return $result->row_array();
               }
             else
             {
                  return false;
             }
      }
      
      function update($field)
      {
          $this->db->where('id =',$field['id']);
          //$this->db->where('status =',"ACTIVE");
          $result = $this->db->update($this->table,$field);
            return $result;
      }
      
      function get_all_photo_from_service()
      {
          $this->db->where('from =',"service");
          $this->db->where('status =',"ACTIVE");
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
      
      function get_all_photo_from_service_id($service_id)
      {
          
          $this->db->where('from =',"service");
          $this->db->where('from_id =',$service_id);
          $this->db->where('status =',"ACTIVE");
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
      
      function get_all_photo_from_service_id_active_or_inactive($service_id)
      {
          
          $this->db->where('from =',"service");
          $this->db->where('from_id =',$service_id);
          //$this->db->where('status =',"ACTIVE");
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
