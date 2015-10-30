<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reservation_model extends CI_Model
{

      private $table;
      

      function __construct()
      {
                  parent::__construct();
                  $this->table='reservation';
      }
      
      function get_reservation($reservation_id)
      {
          $this->db->where('id',$reservation_id);
          $result = $this->db->get($this->table);
          if($result)
          {
              return $result->row_array();
          }
          else
          {
              return false;
          }
      }
      
      function insert($reservation_info)
      {
          $reservation = $reservation_info;
          $result = $this->db->insert($this->table,$reservation);
          if($result)
          {
              return true;
          }
          else
          {
              return false;
          }
      }
      
      function update($reservation_info)
      {
          $this->db->where('id', $reservation_info['id']);
          $result =  $this->db->update($this->table,$reservation_info);
          if($result)
              return $result;
          else
              return false;
      }
      
      function get_reserved_by_doctor_date($doctor_id,$date)
      {
          //$this->automatic_update();
          $this->db->where('doctor_id =',$doctor_id);
          $this->db->where('status =','active');
          $this->db->where('date =',$date);
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_reserved($patient_id)
      {
          //$this->automatic_update();
          $this->db->where('patient_id =',$patient_id);
          $this->db->where('status =','active');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->row_array();
          else
            return false;
      }
      
      function re_schedule($reservation_info)
      {
          //$this->automatic_update();
          $this->db->where('patient_id =',$reservation_info['patient_id']);
          $this->db->where('status =','active');
          $result = $this->db->update($this->table,$patient_info);
          if($result->num_rows > 0 )
              return true;
          else
              return false;
      }
      
      function check_date_and_time($reservation_info)
      {
//          $date1 = now();//'2009-12-20 20:12:10';
//          $date2 = '2009-12-24 12:12:10';
//
//          $ts1 = strtotime($date1);
//          $ts2 = strtotime($date2);
//
//          $seconds_diff = $ts2 - $ts1;
//
//          echo floor($seconds_diff/3600/24);
          
      }
      
      function get_reservation_from_doctor($doctor_id)
      {
          $this->automatic_update();
          $this->db->where('doctor_id =',$doctor_id);
          $this->db->where('status =','active');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if( $result->num_rows > 0 )
            return $result->result_array();
          else
            return false;
      }
      
      
      function automatic_update()
      {
          $candidate = array();
          $k=0;
          $this->db->where('status =','active');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          
          $reserved = $result->result_array();
          
          //print_r($reserved);
          if($reserved)
          {
              
            for($i=0;;$i++)
            {

                $time_date_now = now();
                
              $temp = $reserved[$i]['date'].' '.$reserved[$i]['time'];
              $time_date_reservation = strtotime($temp);
              
              //echo date("Y/m/d H:i:s", strtotime($temp));
              //echo date("Y-m-d h:m:i")."</br>";
              //echo $temp;
              $seconds_diff = $time_date_reservation - $time_date_now;

              $seconds_diff = $time_date_reservation - $time_date_now;

              $difference = floor($seconds_diff/3600/24);
              
              //echo $difference." </br>";
              
              if($difference == 0 || $difference < 0)
              {
                  //echo floor($seconds_diff/3600);
                  $difference_in_sec = floor($seconds_diff);
                  //echo $difference_in_sec;
                  if($difference_in_sec <= 0)
                  {
                      $reservation_info = array(
                     'id' => $reserved[$i]['id'],
                     'patient_id' => $reserved[$i]['patient_id'],
                     'doctor_id' => $reserved[$i]['doctor_id'],
                     'time' => $reserved[$i]['time'],
                     'date' => $reserved[$i]['date'],
                     'status' => "INACTIVE"
                 );
                 $this->update($reservation_info);
                  }
                  //echo "<br/>zeros : ".$difference.print_r($reserved[$i]);
                  
              }
              
             if($difference<0)
              {
                 $reservation_info = array(
                     'id' => $reserved[$i]['id'],
                     'patient_id' => $reserved[$i]['patient_id'],
                     'doctor_id' => $reserved[$i]['doctor_id'],
                     'time' => $reserved[$i]['time'],
                     'date' => $reserved[$i]['date'],
                     'status' => "INACTIVE"
                 );
                
                 $this->update($reservation_info);
              }
              
              
//              if($difference > 0)
//              {
//                  echo "<br/>nOKs : ".$difference.print_r($reserved[$i]);
//              }
              if(!isset($reserved[$i+1]))
              {
                  break;
              }
            }
           
          }
          //return $candidate;
      }
      
      function get_candidates()
      {
          $candidate = array();
          $k=0;
          $this->db->where('status =','active');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          
          $reserved = $result->result_array();
          
          //print_r($reserved);
          if($reserved)
          {
              
            for($i=0;$i<count($reserved);$i++)
            {
                
                $time_date_now = now();
                
              $temp = $reserved[$i]['date'].' '.$reserved[$i]['time'];
              $time_date_reservation = strtotime($temp);
              
              //echo date("Y/m/d H:i:s", strtotime($temp));
              //echo date("Y-m-d h:m:i")."</br>";
              //echo $temp;
              $seconds_diff = $time_date_reservation - $time_date_now;

              $seconds_diff = $time_date_reservation - $time_date_now;

              $difference = floor($seconds_diff/3600/24);
              
              //echo $difference." </br>";
              
              if($difference < 86400 || $difference < 0)
              {
                  $candidate[$k] = $reserved[$i];
                  $k++;
              }
              if(!isset($reserved[$i+1]))
              {
                  break;
              }
            }
           
          }
          return $candidate;
      }
      
      function get_all_active_arranged_by_desc()
      {
          
          $this->db->order_by('id','desc');
          $this->db->where('status','ACTIVE');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_all_active_from_doctor_arranged_by_desc($doctor_id)
      {
          
          $this->db->order_by('id','desc');
          $this->db->where('doctor_id',$doctor_id);
          $this->db->where('status','ACTIVE');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_all_inactive_arranged_by_desc()
      {
          
          $this->db->order_by('date','desc');
          $this->db->where('status','INACTIVE');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_all_inactive_from_doctor_arranged_by_desc($doctor_id)
      {
          
          $this->db->order_by('id','desc');
          $this->db->where('doctor_id',$doctor_id);
          $this->db->where('status','INACTIVE');
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_reserved_by_date($date)
      {
          //$this->automatic_update();
          //$this->db->where('doctor_id =',$doctor_id);
          $this->db->where('status =','active');
          $this->db->where('date =',$date);
          $result = $this->db->get($this->table);
          //$result = $result->row_array();
          //if($result['date'])
          if($result)
            return $result->result_array();
          else
            return false;
      }
      
      function get_reserved_by_date_and_time($date,$time_start,$time_end)
      {
          $this->db->where('status','ACTIVE');
          $this->db->where('date',$date);
          
          $result = $this->db->get($this->table);
      
          if($result)
          {
              $i=0;
              $final_reservation = array();
              $reservation_infos = $result->result_array();
            //return $result->result_array();
              foreach($reservation_infos as $reservation_info)
              {
                  
                  $time = $reservation_info['time'];
                  $time_hr = abs($time[0].$time[1]);
                  if($time_hr >= $time_start && $time_hr <= $time_end)
                  {
                      $final_reservation[$i] = $reservation_info;
                      $i++;
                  }
              }
              return $final_reservation;
          }
          else
            return false;
      }
      
      function get_inactive_reservation_by_month_year($year_month)
      {
          $this->db->like('date',$year_month);
          $this->db->where('status','INACTIVE');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
          {
              return $result->result_array();
          }
          else
          {
              return false;
          }
      }
      
      function get_active_reservation_by_month_year($year_month)
      {
          $this->db->like('date',$year_month);
          $this->db->where('status','ACTIVE');
          $result = $this->db->get($this->table);
          if($result->num_rows > 0)
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
