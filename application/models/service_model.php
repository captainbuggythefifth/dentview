<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class service_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='service';
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
      
      function get_all()
      {
          $this->db->where('status = ','active');
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
      
      
      function check_id($service_id)
      {
          $this->db->where('id',$service_id);
          $this->db->where('status','active');
            $result = $this->db->get($this->table);
            if($result->num_rows > 0)
             {
                  return true;
             }
             else
             {
                  return false;
             }
      }
      
      function get_service($service_id)
      {
            $this->db->where('id = ',$service_id);
          $this->db->where('status = ','active');
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
      
      
      
      function get_all_active_or_inactive()
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
      
      function get_service_active_or_inactive($service_id)
      {
          $this->db->where('id = ',$service_id);
          //$this->db->where('status = ','active');
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
      
      function get_all_not($service_ids)
      {
          //echo $service_ids;
          $string = $service_ids;
            $tok = strtok($string, ",");
            $this->db->where_not_in('id',$tok);
            while ($tok !== false) {
                $this->db->where_not_in('id',$tok);;
                $tok = strtok(",");
            }
              //$this->db->where_not_in('id',$service_ids[$i]);
              
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
              return $result->result_array();
          else
              return false;
      }
      
      function update($service_info)
      {
          $this->db->where('id',$service_info['id']);
          $result =  $this->db->update($this->table,$service_info);
          if($result)
              return true;
          else
              return false;
      }
      
      
}
?>
