<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='admin';
                  
            $this->load->library('encrypt');
      }
      
      function update($admin_info)
      {
          $this->db->where('id', $admin_info['id']);
          $result =  $this->db->update($this->table,$admin_info);
          if($result)
              return $result;
          else
              return $result;
          
      }
      function insert($admin_info)
      {
          $password = $this->encrypt->sha1($admin_info['password']);
          $admin = array(
              'first_name' => $admin_info['first_name'],
              'last_name' => $admin_info['last_name'],
              'email_add' => $admin_info['email_add'],
              'password' => $password,
              'approved_by' => $admin_info['approved_by']
              );
          
          $result = $this->db->insert($this->table,$admin);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function get_admin_by_email($email_add)
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
      
      function get_admin_by_id($admin_id)
      {
          $this->db->where('id',$admin_id);
          $result = $this->db->get($this->table);
          if( $result->num_rows > 0 )
            return $result->row_array();
          else
            return false;
      }
	
}
?>
