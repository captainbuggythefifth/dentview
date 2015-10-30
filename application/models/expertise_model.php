<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class expertise_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='expertise';
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
          $this->db->where('id = ',$service_id);
          $this->db->where('status = ','active');
            $result = $this->db->get($this->table);
            if( $result->num_rows > 0 )
             {
                  return true;
             }
             else
             {
                  return false;
             }
      }
      
      function get_all_from_doctor($doctor_id)
      {
          $this->db->where('doctor_id = ',$doctor_id);
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
}
?>

