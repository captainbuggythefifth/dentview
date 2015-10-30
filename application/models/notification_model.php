<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notification_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
            parent::__construct();
            $this->table='notification';
           
      }
      
      
      function insert($notification_info)
      {
          //print_r($prescription_info);
          $result = $this->db->insert($this->table,$notification_info);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      
      }
      
      function get_notification_by_id($notification_id)
      {
          $this->db->where('id',$notification_id);
          //$this->db->order_by('date','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->row_array();
          else
            return false;
      }
      
      function update($notification_info)
      {
          $this->db->where('id',$notification_info['id']);
          
          $result =  $this->db->update($this->table,$notification_info);
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
      
      function get_notification_from_from_id_to_to_id($from,$from_id,$to,$to_id)
      {
          
          
          $this->db->where('from',$from);
          $this->db->where('from_id',$from_id);
          $this->db->where('to',$to);
          $this->db->where('to_id',$to_id);
          //$this->db->order_by('date','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function get_notification_from_from_id_to($from,$from_id,$to)
      {
          
          $this->db->where('from',$from);
          $this->db->where('from_id',$from_id);
          $this->db->where('to',$to);
          //$this->db->order_by('date','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
      }
      
      function get_notification_for_patient_about($about,$patient_id)
      {
          $this->db->where('about',$about);
          $this->db->where('to',"patient");
          $this->db->where('to_id',$patient_id);
          //$this->db->where('status',"ACTIVE");
          //$this->db->order_by('from_id','desc');
          $this->db->order_by('id','asc');
          
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;

      }
      
      function get_notification_for_doctor_about($about,$doctor_id)
      {
          $this->db->where('about',$about);
          $this->db->where('to',"doctor");
          $this->db->where('to_id',$doctor_id);
          //$this->db->where('status',"ACTIVE");
          //$this->db->order_by('date','asc');
          $this->db->order_by('id','asc');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
            return $result->result_array();
          else
            return false;
       }
      
}
?>