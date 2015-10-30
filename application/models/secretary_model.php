<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class secretary_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='secretary';
                  
            $this->load->library('encrypt');
      }
      
      function update($secretary_info)
      {
          $this->db->where('id', $secretary_info['id']);
          $result =  $this->db->update($this->table,$secretary_info);
          if($result)
              return $result;
          else
              return $result;
          
      }
      function insert($secretary_info)
      {
          $password = $this->encrypt->sha1($secretary_info['password']);
          $secretary = array(
              'first_name' => $secretary_info['first_name'],
              'last_name' => $secretary_info['last_name'],
              'email_add' => $secretary_info['email_add'],
              'password' => $password,
              'under_of' => $secretary_info['under_of']
              );
          
          $result = $this->db->insert($this->table,$secretary);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function get_secretary_by_email($email_add)
      {
          $this->db->where('email_add',$email_add);
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
      
      function get_secretary_by_id($secretary_id)
      {
          $this->db->where('id',$secretary_id);
          $result = $this->db->get($this->table);
          if( $result->num_rows > 0 )
            return $result->row_array();
          else
            return false;
      }
      
      function get_all_active()
      {
          $this->db->where('status',"ACTIVE");
          $result = $this->db->get($this->table);
          if( $result->num_rows > 0 )
            return $result->result_array();
          else
            return false;
      }
	
}
?>
