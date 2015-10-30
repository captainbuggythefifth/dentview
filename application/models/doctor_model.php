<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class doctor_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='doctor';
                  
            $this->load->library('encrypt');
                      
      }
      
      function insert($doctor_info)
      {
          $doctor_info['password'] = $this->encrypt->sha1($doctor_info['password']);
          $result = $this->db->insert($this->table,$doctor_info);
            if($result)
            {
                  return true;
            }
            else
            {
                  return false;
            }
      }
      function update($doctor_info)
      {
          //print_r($doctor_info);
          $this->db->where('id', $doctor_info['id']);
          $result =  $this->db->update($this->table,$doctor_info);
          if($result)
              return true;
          else
              return false;
          
      }
      
      function get_all()
      {
          $this->db->where('status','active');
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
      
      function get_doctor_by_email($email_add)
      {
          $this->db->where('email_add',$email_add);
          $result = $this->db->get($this->table);
          if($result)
            return $result->row_array();
          else
            return false;
      }
      
      function get_doctor_by_id($doctor_id)
      {
          $this->db->where('id',$doctor_id);
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function confirm_email_and_password($email_add, $password)
      {
          $this->db->where('email_add',$email_add);
          $result = $this->db->get($this->table);
          $result = $result->row_array();
          $decodedPassword = $this->encrypt->sha1($password);
          if($decodedPassword == $result['password'])
              return true;
          else
              return false;
          
      }
      
       function get_all_active_or_inactive()
      {
          //$this->db->where('status','active');
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
