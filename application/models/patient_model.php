<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class patient_model extends CI_Model
{

      private $table;

      function __construct()
      {
                  parent::__construct();
                  
                  $this->load->library('encrypt');
                  $this->table='patient';
                 // $this->password_check();
      }
	  
      
      function insert($patient_info)
      {
          
          
            //$password = $this->encrypt->encode($patient_info['password']);
            //$password = $patient_info['password'];
            $password = $this->encrypt->sha1($patient_info['password']);
            $patient = array(
                  'first_name' => $patient_info['first_name'],
                'mi' => $patient_info['mi'],
                'last_name' => $patient_info['last_name'],
                'email_add' => $patient_info['email_add'],
                'mobile_number' => $patient_info['mobile_number'],
                'password' => $password,
                'address' => $patient_info['address'],
                'age' => $patient_info['age'],
                'gender' => $patient_info['gender'],
                'occupation' => $patient_info['occupation'],
                'marital_status' => $patient_info['marital_status'],
                'last_logged_in' => $patient_info['last_logged_in'],
             );
          
            $result = $this->db->insert($this->table,$patient);
            if($result)
            {
                  return true;
            }
            else
            {
                  return false;
            }
          
      }
      
      function get_patient_by_email($email_add)
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
          //$decodedPassword = $this->encrypt->decode($result['password']);
          
          $decodedPassword = $this->encrypt->sha1($password);
          if($decodedPassword == $result['password'])
              return true;
          else
              return false;
          
      }
      
//      function password_check()
//      {
//          $this->db->where('status = ','active');
//          $result = $this->db->get($this->table);
//	  if( $result->num_rows > 0 )
//          {
//              $result = $result->result_array();
//              
//              foreach($result as $patient)
//              {
//                  
//                  $ctr = 0;
//                  for($i=0;;$i++)
//                  {
//                      $ctr++;
//                      if(!isset($patient['password'][$i]))
//                          break;
//                  }
//                  if($ctr < 20)
//                  {
//                      $ctr = 0;
//                      $patient['password'] = $this->encrypt->sha1($patient['password']);
//                      $result = $this->update($patient);
//                  }
//              }
//          }
//      }
//      
      function get_id_and_full_name($email_add)
      {
          $patient_info;
          $this->db->where('email_add',$email_add);
          $result = $this->db->get($this->table);
          if(!$result)
              return false;
          else
          {
              $result = $result->row_array();
              $patient_info = array('id'=>$result['id'],
                  'first_name'=>$result['first_name'],
                  'last_name'=>$result['last_name']);
              
              return $patient_info;
          }
          
      }
      
      function get_patient_by_id($id)
      {
          $patient_info = array();
          $this->db->where('id',$id);
          $result = $this->db->get($this->table);
          if(!$result)
              return false;
          else
          {
              
              return $result->row_array();;
          }
      }
      
      function update_last_logged_in($patient_info)
      {
          $patient_info['last_logged_in'] = date('Y-m-d');
          $this->db->where('id', $patient_info['id']);
          $result =  $this->db->update($this->table,$patient_info);
          if($result)
              return true;
          else
              return false;
          
      }
      
      function update($patient_info)
      {
//          $encrypted_password = $this->encrypt->encode($patient_info['password']);
//          $patient_info['password'] = $encrypted_password;
          $this->db->where('id', $patient_info['id']);
          $result =  $this->db->update($this->table,$patient_info);
          if($result)
              return true;
          else
              return false;
          
      }
      
      function get_all()
      {
             $this->db->where('status','ACTIVE');
             $this->db->order_by("first_name", "asc");
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
      
      
      function get_all_active_or_inactive()
      {
         //$this->db->where('status','ACTIVE');
         $this->db->order_by("first_name", "asc");
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
      
      
      function get_all_active()
      {
          $this->db->where('status','ACTIVE');
          $this->db->order_by("last_name", "asc");
          
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
      function get_all_deactivated()
      {
          $this->db->where('status','INACTIVE');
          $this->db->order_by("first_name", "asc");
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
      
      function deactivate($patient_id)
      {
          $patient = $this->get_patient_by_id($patient_id);
          if($patient)
          {
              $patient_info = $patient;
              $patient_info['status'] = "INACTIVE";
              $confirm = $this->update($patient_info);
              if($confirm)
                  return true;
              else
                  return false;
          }
          else
             return false;
      }
      
      function activate($patient_id)
      {
          $patient = $this->get_patient_by_id($patient_id);
          if($patient)
          {
              $patient_info = $patient;
              $patient_info['status'] = "ACTIVE";
              $confirm = $this->update($patient_info);
              if($confirm)
                  return true;
              else
                  return false;
          }
          else
             return false;
      }
      
      function get_active_patients_by_last_name($last_name)
      {
          $this->db->like('last_name',$last_name);
          $this->db->order_by("last_name", "asc");
          $this->db->order_by("status", "ACTIVE");
          
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
	   
//      function insert($data)
//      {
//					$password=$this->encrypt->encode($data['password']);
//                  $customers = array(
//                                              'firstname' => $data['firstname'],
//                                               'mi' => $data['mi'],
//                                               'lastname' => $data['lastname'],
//                                               'email_add' => $data['email_add'],
//												'password' => $password,
//                                                 'place' => $data['place'],
//												 'last_logged_in' => $data['last_logged_in']
//                                              );
//                  $result=$this->db->insert($this->table,$customers);
//
//                  if($result)return true;
//                  else return false;
//      }
//
//      function get_all()
//      {
//	     $result = $this->db->get($this->table);
//	     if( $result->num_rows > 0 )
//	     {
//			return $result->result_array();
//	     }
//	     else
//	     {
//	        return false;
//	     }
//      }
//
//      function get_one($email_add)
//      {
//      		$this->db->where('email_add',$email_add);
//			$result = $this->db->get($this->table);
//			if($result)
//				return $result->row_array();
//			else
//				return false;
//			//$finalResult = array('firstname' => $result['firstname'], 'mi' => $result['mi'], 'lastname' => $result['lastname'], 'email_add' => $result['email_add'], 'password' => "", 'place' => $result['place']);
//			//return $finalResult;
//      }
//
//      function get_one_by_id($cust_id)
//      {
//      		$this->db->where('id',$cust_id);
//			$result = $this->db->get($this->table);
//			return $result->row_array();
//      }
//	  
//	  function update($data)
//	  {
//		$this->db->where('id', $data['id']);
//		 $result =  $this->db->update($this->table,$data);
//		 return $result;
//	  }
}
?>