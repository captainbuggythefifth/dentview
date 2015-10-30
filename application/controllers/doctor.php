<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if( !defined('BASEPATH') ) exit ('No direct script access allowed');

class doctor extends CI_Controller{
    

      function __construct()
      {
            parent::__construct();

            $this->load->helper('date');
            $this->load->library('encrypt');
            //$this->load->helper('captcha');
            $this->load->model('admin_model');
            $this->load->model('patient_model');
            $this->load->model('doctor_model');

            $this->load->model('service_model');
            $this->load->model('photo_model');

            $this->load->model('reservation_model');
            $this->load->model('expertise_model');

            //checks the password
//            $this->admin_model->password_check();
//            $this->patient_model->password_check();
//            $this->doctor_model->password_check();
            $this->load->model("prescription_model");
            $this->load->model('notification_model');
            $this->load->model('system_model');
            $this->load->helper('url');

            array('error' => ' ' );
            $this->load->helper(array('form', 'url'));

            //automatic update
            //$this->reservation_model->automatic_update();
      }
      
      function doctor_previlege($function = null)
      {
          if($function == "patient")
          {
                if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
              $active_patients = $this->patient_model->get_all();
              $inactive_patients = $this->patient_model->get_all_deactivated();
              $complete_info_from_active_patient = array();
              $complete_info_from_inactive_patient = array();
              if(is_array($inactive_patients) && count($inactive_patients)>0)
              {
                  for($i = 0;;$i++)
                  {
                      
                      $complete_info_from_inactive_patient[$i]['patient_info'] = $inactive_patients[$i];
                      $photo_info = $this->photo_model->get_photo('patient',$inactive_patients[$i]['id']);
                      if($photo_info)
                      {
                          $complete_info_from_inactive_patient[$i]['photo_info'] = $photo_info;
                      }
                      else
                      {
                          $complete_info_from_inactive_patient[$i]['photo_info'] = array();
                      }
                      //print_r($photo_info);
                      if(!isset($inactive_patients[$i+1]))
                      {
                          break;
                      }
                  }
              }
              elseif($inactive_patients == false)
              {
                  
                  $inactive_patients = array();
              }
              elseif($active_patients == false)
              {
                 
                  $active_patients = array();
              }
              if(count($active_patients)>0)
              {
                  for($i = 0;;$i++)
                  {
                      $complete_info_from_active_patient[$i]['patient_info'] = $active_patients[$i];
                      $photo_info = $this->photo_model->get_photo('patient',$active_patients[$i]['id']);
                      if($photo_info)
                      {
                          $complete_info_from_active_patient[$i]['photo_info'] = $photo_info;
                      }
                      else
                      {
                          //$complete_info_from_active_patient[$i]['photo_info'] = array();
                          $photo_info = array(
                              'from' => 'patient',
                              'from_id' => $active_patients[$i]['id'],
                              'name' => $active_patients[$i]['first_name']." ".$active_patients[$i]['last_name'],
                              'description' => $active_patients[$i]['first_name']."_".$active_patients[$i]['last_name'],
                              'source' => base_url().'images/patient/silhouette.jpg'
                          );
                          $confirm = $this->photo_model->insert($photo_info);
                          if($confirm)
                          {
                              $photo_info = $this->photo_model->get_photo('patient',$active_patients[$i]['id']);
                          }
                          else
                          {
                              echo "wrong!";
                          }
                      }
                      //print_r($photo_info);
                      if(!isset($active_patients[$i+1]))
                      {
                          break;
                      }
                  }
              }
              $complete_info['complete_info_from_active_patient'] = $complete_info_from_active_patient;
              $complete_info['complete_info_from_inactive_patient'] = $complete_info_from_inactive_patient;
              //print_r($complete_info);
              $this->load->view('admin_header');
              $this->load->view('doctor_home_view');
              $this->load->view('admin_manage_patient',$complete_info);
              $this->load->view('forms');
          }
          }
          if($function == "admin")
          {
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
              $admins = $this->admin_model->get_all();
              $admin = array('admins' => $admins);
              $this->load->view('admin_header');
              $this->load->view('doctor_home_view');
              $this->load->view('admin_view_all',$admin);
                }
              //$this->load->view('forms');
          }
          if($function == 'doctor')
          {
          
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
              $all_service_info = $this->service_model->get_all();
              $doctor = $this->doctor_model->get_all();
              if(count($doctor)>0 && is_array($doctor))
              {
                  for($i=0;;$i++)
                  {
                      $complete_info_from_doctor[$i]['doctor_info'] = $doctor[$i];
                      $photo_info = $this->photo_model->get_photo('doctor',$doctor[$i]['id']);
                      if(is_array($photo_info))
                      {
                          $complete_info_from_doctor[$i]['photo_info'] = $photo_info;
                      }
                      else
                      {
                          $photo_info = array(
                              'from' => 'doctor',
                              'from_id' => $doctor[$i]['id'],
                              'name' => $doctor[$i]['first_name']."_".$doctor[$i]['last_name'],
                              'description' => $doctor[$i]['first_name']."_".$doctor[$i]['last_name'],
                              'source' => base_url().'images/doctor/silhouette.jpg'
                          );
                          $confirm = $this->photo_model->insert($photo_info);
                          if($confirm)
                          {
                              $photo_info_from_none = $this->photo_model->get_photo('doctor',$doctor[$i]['id']);
                              $complete_info_from_doctor[$i]['photo_info'] = $photo_info_from_none;
                          }
                          else
                          {
                              $complete_info_from_doctor[$i]['photo_info'] = false;
                          }
                      }
                      if(!isset($doctor[$i+1]))
                      {
                          break;
                      }
                  }
                  
                  for($i=0;$i<count($doctor);$i++)
                  {   
                      $complete_info_from_doctor[$i]['services'] = "";
                      $expertise_info = $this->expertise_model->get_all_from_doctor($doctor[$i]['id']);
                      if(count($expertise_info)>0 && is_array($expertise_info))
                      {
                          for($j=0;$j<count($expertise_info);$j++)
                          {
                              $complete_info_from_doctor[$i]['expertise_info'][$j] = $this->service_model->get_service($expertise_info[$j]['service_id']);
                              if($complete_info_from_doctor[$i]['services'] == '')
                              {
                                  $complete_info_from_doctor[$i]['services'] = $complete_info_from_doctor[$i]['expertise_info'][$j]['id'];
                              }
                              else
                              {
                                    $complete_info_from_doctor[$i]['services'] = $complete_info_from_doctor[$i]['services'].','.$complete_info_from_doctor[$i]['expertise_info'][$j]['id'];
                              }
                              
                          }
                          $result = $this->service_model->get_all_not($complete_info_from_doctor[$i]['services']);
                          if($result)
                          {
                              $complete_info_from_doctor[$i]['not_in_service_info'] = $result;
                          }
                          else
                          {
                              $complete_info_from_doctor[$i]['not_in_service_info'] = false;
                          }
                      }
                      else
                      {
                          if(is_array($all_service_info) && count($all_service_info)>0)
                          {
                              $str = "";
                              foreach($all_service_info as $service)
                              {
                                  $str = $str.",".$service['id'];
                              }
                              $result = $this->service_model->get_all_not($complete_info_from_doctor[$i]['services']);
                              if($result)
                              {
                                  $complete_info_from_doctor[$i]['not_in_service_info'] = $result;
                              }
                              else
                              {
                                  $complete_info_from_doctor[$i]['not_in_service_info'] = false;
                              }
                          }
                      }
                  }
                  $doctors['complete_info_from_doctor'] = $complete_info_from_doctor;
                  $doctors['all_service_info'] = $all_service_info;
                  $this->load->view('admin_header');
                  $this->load->view('doctor_home_view');
                  $this->load->view('admin_manage_doctor',$doctors);
              }
              else
              {
                  echo "No doctor available";
              }
          }
          }
          elseif($function == "service")
          {
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
              $service_info = $this->service_model->get_all_active_or_inactive();
              $data = array(
                  'all_photos' => $this->all_photos,
                  'services_with_photos' => $this->service_with_photos,
                    'title' => "Services - DentView Dental Clinic"
                  );
              //print_r($service_info);
              //$service['service_info'] = $service_info;
                //$this->load->view('header',$data);
        
                    $active = array();
                    $inactive = array();
                    $i = 0;
                    foreach($service_info as $service)
                    {
                        
                        if($service['status'] == "ACTIVE")
                        {
                           $active[$i] = $service; 
                        }
                        else
                        {
                            $inactive[$i] = $service; 
                        }
                        $i++;
                    }
                    $service = array(
                        'active' => $active,
                        'inactive' => $inactive
                    );
                    //print_r($inactive);
                  //$data['service_info'] = $service_info;
                  $this->load->view('admin_header',$data);
                  $this->load->view('doctor_home_view');
                  $this->load->view('admin_manage_service',$service);
              
          }
          }
          elseif($function == "reservation")
          {
            if(!isset($this->session->userdata['doctor_info']['id']))
            {
              redirect(base_url().'doctor');
            }
            else
            {
                $patient_active = $this->patient_model->get_all();
                if(is_array($patient_active) && count($patient_active) > 0)
                {
                    for($i=0;$i<count($patient_active);$i++)
                    {
                        $patient_active[$i]['photo_info'] = $this->photo_model->get_photo('patient',$patient_active[$i]['id']);
                    }
                }
                  $reservation_info = $this->reservation_model->get_all_active_arranged_by_desc();
//                  $reservation_active = array();
//                  $reservation_inactive = array();
//                  $ctr_active = 0;
//                  $ctr_inactive = 0;
//                  //print_r($reservation_info);
                  $reservation_active = $this->reservation_model->get_all_active_from_doctor_arranged_by_desc($this->session->userdata['doctor_info']['id']);
                  
                      //print_r($reservation_active);
                  
//                  foreach($reservation_info as $reserve)
//                  {
//                      if($reserve['status'] == 'ACTIVE')
//                      {
//                          $reservation_active[$ctr_active] = $reserve;
//                          $ctr_active++;
//                      }
//                      else
//                      {
//                          $reservation_inactive[$ctr_inactive] = $reserve;
//                          $ctr_inactive++;
//                      }
//
//                  }
                  $reservation_inactive = $this->reservation_model->get_all_inactive_from_doctor_arranged_by_desc($this->session->userdata['doctor_info']['id']);
                  $datestring = "%m %Y";
                  $time = strtotime($reservation_inactive[0]['date']);

                  $first = mdate($datestring, $time);
                  $i = 0;
                  foreach($reservation_inactive as $r)
                  {
                      $datestring = "%m %Y";
                      $time = strtotime($r['date']);

                        $month = mdate($datestring, $time);
                        if($month != $first)
                        {
                            break;
                        }
                        else
                        {
                            $new_reservation_inactive[$i] = $r;
                        }
                      $i++;
                  }
                  $reservation_inactive = $new_reservation_inactive;
                  if(count($reservation_active) > 0)
                  {
                      for($i=0;;$i++)
                      {
                          $reservation_active[$i]['doctor_info'] = $this->doctor_model->get_doctor_by_id($reservation_active[$i]['doctor_id']);
                          $reservation_active[$i]['patient_info'] = $this->patient_model->get_patient_by_id($reservation_active[$i]['patient_id']);
                          if(!isset($reservation_active[$i+1]))
                              break;
                      }
                  }
                  if(count($reservation_inactive) > 0)
                  {
                      
                      for($i=0;;$i++)
                      {
                          
                          $reservation_inactive[$i]['doctor_info'] = $this->doctor_model->get_doctor_by_id($reservation_inactive[$i]['doctor_id']);
                          $reservation_inactive[$i]['patient_info'] = $this->patient_model->get_patient_by_id($reservation_inactive[$i]['patient_id']);
                          if(!isset($reservation_inactive[$i+1]))
                              break;
                      }
                  }
                  //print_r($reservation_inactive[0]['patient_info']);
                  if(is_array($reservation_info) && count($reservation_info) > 0)
                  {
                      $reservation['reservation_active_info'] = $reservation_active;
                      $reservation['reservation_inactive_info'] = $reservation_inactive;
                  }
                  else
                  {
                      $reservation['reservation_active_info'] = false;
                      $reservation['reservation_inactive_info'] = false;
                  }
                  $reservation['doctors'] = $this->doctor_model->get_all();
                  $reservation['patient_active'] = $patient_active;
                  $this->load->view('admin_header');
                  $this->load->view('doctor_home_view');
                  $this->load->view('admin_manage_reservation',$reservation);
              }
          }
          if($function == "prescription")
          {
              
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
              $patients = $this->patient_model->get_all_active_or_inactive();
              if(!is_array($patients) || count($patients) < 1)
              {
                  $patients = false;
              }
              $doctors = $this->doctor_model->get_all();
              if(!is_array($doctors) || count($doctors) < 1)
              {
                  $doctors = false;
              }
              
              $all_prescriptions = $this->prescription_model->get_all();
              if(!is_array($all_prescriptions) || count($all_prescriptions) < 1)
              {
                  $all_prescriptions = false;
              }
              if(is_array($all_prescriptions) && count($all_prescriptions) > 0)
              {
                  $prescriptions = array();
                  $i = 0;
                  foreach($all_prescriptions as $pres)
                  {
                      if($pres['doctor_id'] == $this->session->userdata['doctor_info']['id'])
                      {
                      $prescriptions[$i] = $pres;
                      }
                      $i++;
                  }
                  if(is_array($prescriptions) || count($prescriptions) > 0)
                      {
                          $new_prescription = array();
                          for($i = 0; $i < count($prescriptions); $i++)
                          {
                              $patient_info = $this->patient_model->get_patient_by_id($prescriptions[$i]['patient_id']);
                              if(is_array($patient_info) && count($patient_info))
                              {
                                  $prescriptions[$i]['patient_info'] = $patient_info;
                              }
                              else
                              {
                                  $prescriptions[$i]['patient_info'] = false;
                              }

                              $doctor_info = $this->doctor_model->get_doctor_by_id($prescriptions[$i]['doctor_id']);
                              if(is_array($doctor_info) && count($doctor_info))
                              {
                                  $prescriptions[$i]['doctor_info'] = $doctor_info;
                              }
                              else
                              {
                                  $prescriptions[$i]['doctor_info'] = false;
                              }

                      }
                }
              }
              $data['patients'] = $patients;
              $data['doctors'] = $doctors;
              $data['prescriptions'] = $prescriptions;
              $this->load->view('admin_header');
              $this->load->view('doctor_home_view');
              $this->load->view('admin_manage_prescription',$data);
          }
          }
          if($function == "candidates")
          {
              
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
                    
              $all_candidates = $this->reservation_model->get_candidates();
              if(is_array($all_candidates) && count($all_candidates) > 0)
              {
                  $candidates = array();
                  $i = 0;
                  foreach($all_candidates as $cand)
                  {
                      if($cand['doctor_id'] == $this->session->userdata['doctor_info']['id'])
                      {
                        $candidates[$i] = $cand;
                      }
                      $i++;
                  }
              }
              else
              {
                  $all_candidates = false;
              }
              if(isset($candidates) && is_array($candidates) && count($candidates) > 0)
              {
                  
                  
                  for($i=0;$i<count($candidates);$i++)
                  {
                      $candidates[$i]['patient_info'] = $this->patient_model->get_patient_by_id($candidates[$i]['patient_id']);
                  }
                  $data['candidates'] = $candidates;
                  
                    $this->load->view('admin_header');
                    $this->load->view('doctor_home_view');
                  $this->load->view('admin_manage_candidate',$data);
              }
              else
              {
                  $data['candidates'] = false;
                  $this->load->view('admin_header');
                    $this->load->view('doctor_home_view');
                  $this->load->view('admin_manage_candidate',$data);
              }
          }
          }
          if($function == "system_time")
          {
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
                        $today = date('m/d/Y');
                        $system_infos = $this->system_model->get_date_active_or_inactive($today);

                        $data['system_info'] = $system_infos;
                        $this->load->view('admin_header');
                        $this->load->view('doctor_home_view');
                        $this->load->view('admin_manage_system',$data);
                 }
          }
          
          if($function == "customer_care")
          {
              if(!isset($this->session->userdata['doctor_info']['id']))
                {
                  redirect(base_url().'doctor');
                }
                else
                {
                    $customer_care_active_info = $this->customer_care_model->get_all_active();
                    for($i = 0; $i < count($customer_care_active_info); $i++)
                    {
                        $patient_info = $this->patient_model->get_patient_by_id($customer_care_active_info[$i]['patient_id']);
                        if(is_array($patient_info) && count($patient_info) > 0)
                        {
                            $customer_care_active_info[$i]['patient_info'] = $patient_info;
                        }
                        else
                        {
                            $customer_care_active_info[$i]['patient_info'] = false;
                        }
                    }
                    
                    $customer_care_inactive_info = $this->customer_care_model->get_all_inactive();
                    
                    for($i = 0; $i < count($customer_care_inactive_info); $i++)
                    {
                        $patient_info = $this->patient_model->get_patient_by_id($customer_care_inactive_info[$i]['patient_id']);
                        if(is_array($patient_info) && count($patient_info) > 0)
                        {
                            $customer_care_inactive_info[$i]['patient_info'] = $patient_info;
                        }
                        else
                        {
                            $customer_care_inactive_info[$i]['patient_info'] = false;
                        }
                    }
                    
                    
                    $data['customer_care_active_info'] = $customer_care_active_info;
                    $data['customer_care_inactive_info'] = $customer_care_inactive_info;
                    $this->load->view('admin_header');
                    $this->load->view('doctor_home_view');
                    $this->load->view('admin_manage_customer_care',$data);
                }
                
          }
          
          if($function == "faq")
          {
              $faq_active_info = $this->faq_model->get_all_active();
              $faq_inactive_info = $this->faq_model->get_all_inactive();
              
              $data = array(
                  'faq_active_info' => $faq_active_info,
                  "faq_inactive_info" => $faq_inactive_info
              );
              $this->load->view('admin_header');
              $this->load->view('doctor_home_view');
              $this->load->view('admin_manage_faq',$data);
          }
          
          if($function == "secretary")
          {
              $doctor_info = $this->doctor_model->get_all();
              if(is_array($doctor_info) && count($doctor_info) > 0)
              {
                  $data['doctor_info'] = $doctor_info;
              }
              else
              {
                  $data['doctor_info'] = false;
              }
              $secretary_active_info = $this->secretary_model->get_all_active();
              if(is_array($secretary_active_info) && count($secretary_active_info) > 0)
              {
                  $i=0;
                  foreach($secretary_active_info as $secretary_active)
                  {
                      $secretary_active_info[$i]['doctor_info'] = $this->doctor_model->get_doctor_by_id($secretary_active['under_of']);
                      $i++;
                  }
                  $data['secretary_active_info'] = $secretary_active_info;
              }
              else
              {
                  $data['secretary_active_info'] = false;
              }
              
              
              $this->load->view('admin_header');
              $this->load->view('doctor_home_view');
              $this->load->view('admin_manage_secretary',$data);
          }
          
          if($function == "profile_edit")
          {
              $this->load->view('admin_header');
              $this->load->view('doctor_home_view');
              $this->load->view('secretary_manage_profile');
          }
          elseif($function == null)
          {
                $this->load->view('admin_header');
                $this->load->view('doctor_home_view');
          }
      }
      
      function profile()
      {
          if($this->session->userdata['doctor_info']['id'])
          {
            $notification_about_reservation_info = $this->notification_model->get_notification_for_doctor_about('Reservation',$this->session->userdata['doctor_info']['id']);
            if(is_array($notification_about_reservation_info) && count($notification_about_reservation_info) > 0)
            {
                $i = 0;
                foreach($notification_about_reservation_info as $notification)
                {
                    $notification_about_reservation_info[$i]['patient_info'] = $this->patient_model->get_patient_by_id($notification['from_id']);
                    $i++;
                }
            }
            else
            {
                $notification_about_reservation_info = false;
            }
            $notification_about_personal_message_info = $this->notification_model->get_notification_for_doctor_about('Personal Message',$this->session->userdata['doctor_info']['id']);
            if(is_array($notification_about_personal_message_info) && count($notification_about_personal_message_info) > 0)
            {
                $i = 0;
                foreach($notification_about_personal_message_info as $notification)
                {
                    $notification_about_personal_message_info[$i]['patient_info'] = $this->patient_model->get_patient_by_id($notification['from_id']);
                    $i++;
                }
            }
            else
            {
                $notification_about_personal_message_info = false;
            }
            
            $expertise_info = $this->expertise_model->get_all_from_doctor($this->session->userdata['doctor_info']['id']);
            if($expertise_info == false)
            {
                $expertise_with_service = array();
            }
            else //(count($expertise_info) > 0)
            {
                $i = 0;
                foreach($expertise_info as $expert)
                {
                    $expertise_with_service[$i] = $this->service_model->get_service($expert['service_id']);
                    $i++;
                }
            }
            $reservation_info = $this->reservation_model->get_reservation_from_doctor($this->session->userdata['doctor_info']['id']);
            $photo_info = $this->photo_model->get_photo('doctor',$this->session->userdata['doctor_info']['id']);
            $doctor_info = $this->session->userdata['doctor_info'];
            $doctor_info['photo_info'] = $photo_info;
            $doctor_info['reservation_info'] = $reservation_info;
            $doctor_info['expertise_with_service'] = $expertise_with_service;
            
            
            $data['notification_about_reservation_info'] = $notification_about_reservation_info;
            $data['notification_about_personal_message_info'] = $notification_about_personal_message_info;
            $this->session->set_userdata('doctor_info',$doctor_info);
            
            $title['title'] = "Doctor Profile - DentView Dental Clinic";
            //print_r($this->session->userdata['doctor_info']);
            $this->load->view('header',$title);
            $this->load->view('doctor_profile',$data);
          //$this->load->view('admin_footer');
          }
          else
          {
              
              redirect(base_url());
          }
      }
      
      function reservation_of_date()
      {
          $whole_day = false;
        $time_start = 10;
        $time_end = 20;
          $day = $this->input->post('day');
            
            
         
        $timestamp = now();
        $timezone = 'UP8';
        $daylight_saving = true;


        //$timer = unix_to_human(gmt_to_local($timestamp, $timezone, $daylight_saving));
        $timer = unix_to_human(now());
        if(date('Ymd') == date('Ymd', strtotime($this->input->post('date'))))
        {
            $system_info = $this->system_model->get_date(date('m/d/Y', strtotime($this->input->post('date'))));
            if(is_array($system_info) && count($system_info) > 0)
            {
                //$time_start = $system_info['time_in'];
                 if(is_numeric($system_info['time_in'][1]))
                 {
                     $time_start = $system_info['time_in'][0].$system_info['time_in'][1];
                 }
                 else
                 {
                     $time_start = $system_info['time_in'][0];
                 }

                 if(is_numeric($system_info['time_out'][1]))
                 {
                     $time_end = $system_info['time_out'][0].$system_info['time_out'][1];
                 }
                 else
                 {
                     $time_end = $system_info['time_out'][0];
                 }
            }
            else
            {
                $time_start = 10;
                $time_end = 20;
            }
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));  
            $time_hr = floor($local_time);
            if($time_hr > $time_start)
            {
                if($time_hr < 20)
                {
                    $time_start = $time_hr;
                }
            }
            

            if($time_start < 7)
            {
                $time_start = 10;
            }
            
            if($day == 0 && $time_start <= 13)
            {
                $time_start = 13;
            }
            //$time_start = ($timer[11].$timer[12]);
            //echo $time_start;
            //$time_start = time();
            //echo $time_start;
            //echo unix_to_human(now());
            if($time_start > 20)
            {
                echo "You are not allowed to make reservations as of now. Adjust to tomorrow instead.";
            }
            else
            {
                
                $date = date_create($this->input->post('date'));
                $date_formatted = date_format($date, "Y-m-d");
                $date_not_available = $this->reservation_model->get_reserved_by_doctor_date($this->session->userdata['doctor_info']['id'],$date_formatted);
                if(is_array($date_not_available))
                {
                    for($i = 0; $i < count($date_not_available); $i++)
                    {
                        //$patient_infos[] = $this->patient_model->get_patient_by_id($reservation['patient_id']);
                        $date_not_available[$i]['patient_info'] = $this->patient_model->get_patient_by_id($date_not_available[$i]['patient_id']);
                    }
                    $time_info = array('time_info' => $date_not_available,'time_start' => $time_start,'time_end' => $time_end, 'whole_day' => $whole_day);
                    $this->load->view('time',$time_info);
                    //print_r($date_not_available);
                }
                else
                    echo $date_not_available;
        
            }
        }
        elseif(date('Ymd') > date('Ymd', strtotime($this->input->post('date'))))
        {
            echo "You are not allowed to reserve of dates of yesterdays.";
        }
        else
        {
            $system_info = $this->system_model->get_date(date('m/d/Y', strtotime($this->input->post('date'))));
            if(is_array($system_info) && count($system_info) > 0)
            {
                //$time_start = $system_info['time_in'];
                 if(is_numeric($system_info['time_in'][1]))
                 {
                     $time_start = $system_info['time_in'][0].$system_info['time_in'][1];
                 }
                 else
                 {
                     $time_start = $system_info['time_in'][0];
                 }

                 if(is_numeric($system_info['time_out'][1]))
                 {
                     $time_end = $system_info['time_out'][0].$system_info['time_out'][1];
                 }
                 else
                 {
                     $time_end = $system_info['time_out'][0];
                 }
            }
            else
            {
                $time_start = 10;
                $time_end = 20;
            }
            
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));  
            $time_hr = floor($local_time);
            
            
            
            if($day == 0 && $time_start <= 13)
            {
                $time_start = 13;
            }
            
            
            if($time_start < 7)
            {
                $time_start = 10;
            }
            //$time_start = 10;
            $date = date_create($this->input->post('date'));
            $date_formatted = date_format($date, "Y-m-d");
            $date_not_available = $this->reservation_model->get_reserved_by_doctor_date($this->session->userdata['doctor_info']['id'],$date_formatted);
            if(is_array($date_not_available))
            {
                //print_r($date_not_available);
                //$patient_infos = array();
                for($i = 0; $i < count($date_not_available); $i++)
                {
                    //$patient_infos[] = $this->patient_model->get_patient_by_id($reservation['patient_id']);
                    $date_not_available[$i]['patient_info'] = $this->patient_model->get_patient_by_id($date_not_available[$i]['patient_id']);
                }
                $time_info = array('time_info' => $date_not_available,'time_start' => $time_start, 'time_end' => $time_end, 'whole_day' => $whole_day);
                $this->load->view('time',$time_info);
                //print_r($date_not_available);
            }
            else
                echo $date_not_available;
        
            
        }
      }
      
      
      function reshedule()
      {
          $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
            
//          function doctor_reschedule()
          
            $reservation_before = $this->reservation_model->get_reservation($this->input->post('reservation_id'));
            $date = date_create($this->input->post('date'));

            $date_formatted = date_format($date, "Y-m-d");

            $hour = $this->input->post('hour');
            $service_ids = $this->input->post('service_id');
            //if($hour)
            $specified_service = $this->input->post('specified_service');
            if($hour == "")
            {
                $hour = 1;
            }
            if($service_ids == "")
            {
                $service_ids = "NONE";
            }
            if($specified_service == "")
            {
                $specified_service = "NONE";
            }
            $time = date("H:i:s", strtotime($this->input->post('time')));

            $reservation_info = array(
                        'id' => $this->input->post('reservation_id'),
                        'patient_id' => $reservation_before['patient_id'],
                        'doctor_id' => $this->input->post('doctor_id'),
                        'time' => $time,
                        'hour' => $reservation_before['hour'],
                        'service_ids' => $reservation_before['service_ids'],
                        'specified_service' => $reservation_before['specified_service'],
                        'date' => $date_formatted,
                        'status' => 'ACTIVE'

                        );

            
                
                if($reservation_info['doctor_id'] == $reservation_before['doctor_id'])
                {
                    $patient_info = $this->patient_model->get_patient_by_id($reservation_info['patient_id']);
                    $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                    $doctor_before = $this->doctor_model->get_doctor_by_id($reservation_before['doctor_id']);
                    if(is_array($patient_info) && count($patient_info) > 0)
                    {
                        $time = abs($reservation_info['time'][0].$reservation_info['time'][1]);

                        if($time<=11)
                        {
                            $real_time =  $time.":00 AM";
                        }
                        elseif($time == 12)
                        {
                            $real_time = $time.":00 PM";
                        }
                        else
                        {
                            $real_time = ($time-12).":00 PM";
                        }

                     $time_before = abs($reservation_info['time'][0].$reservation_info['time'][1]);
                     if($time<=11)
                        {
                            $real_time_before =  $time.":00 AM";
                        }
                        elseif($time == 12)
                        {
                            $real_time_before = $time.":00 PM";
                        }
                        else
                        {
                            $real_time_before = ($time-12).":00 PM";
                        }

                        // for patient
                            $date_before = date("F d Y",  strtotime($reservation_before['date']));
                            $date_info = date("F d Y",  strtotime($reservation_info['date']));
                 
                             $notification_info = array(
                                  'from' => 'doctor',
                                  'to' => 'patient',
                                  'from_id' => $reservation_info['doctor_id'],
                                  'to_id' => $reservation_info['patient_id'],
                                  'about' => 'Reservation',
                                  'msg' => 'Dr. '.$this->session->userdata['doctor_info']['first_name']." ".$this->session->userdata['doctor_info']['last_name'].' has reschedule your reservation. You are now scheduled to '.$real_time.','.$date_before.'.',
                                  'time' => $local_time,
                                  'date' => $local_date,
                                  'status' => "ACTIVE",

                              );
                             $this->notification_model->insert($notification_info);
                         
                    }
                    else
                    {
                        echo 'Could not retrieve patient info';
                    }
                }
                $result = $this->reservation_model->update($reservation_info);
                echo "Successfully rescheduled!";
                if($reservation_info['doctor_id'] != $reservation_before['doctor_id'])
                {
                   
                    $patient_info = $this->patient_model->get_patient_by_id($reservation_info['patient_id']);
                    $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                    $doctor_before = $this->doctor_model->get_doctor_by_id($reservation_before['doctor_id']);
                    if(is_array($patient_info) && count($patient_info) > 0)
                    {
                        $time = abs($reservation_info['time'][0].$reservation_info['time'][1]);

                        if($time<=11)
                        {
                            $real_time =  $time.":00 AM";
                        }
                        elseif($time == 12)
                        {
                            $real_time = $time.":00 PM";
                        }
                        else
                        {
                            $real_time = ($time-12).":00 PM";
                        }

                     $time_before = abs($reservation_info['time'][0].$reservation_info['time'][1]);
                     if($time<=11)
                        {
                            $real_time_before =  $time.":00 AM";
                        }
                        elseif($time == 12)
                        {
                            $real_time_before = $time.":00 PM";
                        }
                        else
                        {
                            $real_time_before = ($time-12).":00 PM";
                        }

                        //For transfered doctor
                        $date_before = date("F d Y",  strtotime($reservation_before['date']));
                         $date_info = date("F d Y",  strtotime($reservation_info['date']));
                 
                         $notification_info = array(
                              'from' => 'doctor',
                              'to' => 'doctor',
                              'from_id' => $reservation_before['doctor_id'],
                              'to_id' => $reservation_info['doctor_id'],
                              'about' => 'Reservation',
                              'msg' => 'Dr. '.$this->session->userdata['doctor_info']['first_name']." ".$this->session->userdata['doctor_info']['last_name'].' has rescheduled you to manage Patient '.$patient_info['first_name'].' '.$patient_info['last_name'].' on time '.$real_time.','.$date_info.'.',
                              'time' => $local_time,
                              'date' => $local_date,
                              'status' => "ACTIVE",

                          );
                         $this->notification_model->insert($notification_info);

                         // for patient
                         if($reservation_before['time'] == $reservation_info['time'])
                         {
                             $notification_info = array(
                                  'from' => 'doctor',
                                  'to' => 'patient',
                                  'from_id' => $reservation_info['doctor_id'],
                                  'to_id' => $reservation_info['patient_id'],
                                  'about' => 'Reservation',
                                  'msg' => 'Dr. '.$this->session->userdata['doctor_info']['first_name']." ".$this->session->userdata['doctor_info']['last_name'].' has assigned '.$doctor_info['first_name'].' '.$doctor_info['last_name'].' to take care of you.',
                                  'time' => $local_time,
                                  'date' => $local_date,
                                  'status' => "ACTIVE",

                              );
                             $this->notification_model->insert($notification_info);
                         }
                         else
                         {
                             $date_before = date("F d Y",  strtotime($reservation_before['date']));
                            $date_info = date("F d Y",  strtotime($reservation_info['date']));
                 
                             $notification_info = array(
                                  'from' => 'doctor',
                                  'to' => 'patient',
                                  'from_id' => $reservation_info['doctor_id'],
                                  'to_id' => $reservation_info['patient_id'],
                                  'about' => 'Reservation',
                                  'msg' => 'Dr. '.$this->session->userdata['doctor_info']['first_name']." ".$this->session->userdata['doctor_info']['last_name'].' has assigned '.$doctor_info['first_name'].' '.$doctor_info['last_name'].' to take care of you. You now have the schedule of '.$real_time.','.$date_info.'.',
                                  'time' => $local_time,
                                  'date' => $local_date,
                                  'status' => "ACTIVE",

                              );
                             $this->notification_model->insert($notification_info);
                         }
                    }
                    else
                    {
                        echo 'Could not retrieve patient info';
                    }
                    
                    
                    $result = $this->reservation_model->update($reservation_info);
                    echo "Successfully rescheduled!";
                }
            }
       
      function profile_edit()
    {
        $this->load->library('form_validation');
        //echo "alalah!";
        $this->form_validation->set_rules('first_name','First Name', 'trim|required');
        $this->form_validation->set_rules('mi','Middle Initial', 'trim|required');
        $this->form_validation->set_rules('last_name','Last Name', 'trim|required');
        $this->form_validation->set_rules('email_add','Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('password','Password', 'trim|required');
        $this->form_validation->set_rules('address','Address', 'trim|required');
        if($this->form_validation->run() == FALSE)
        {
            //redirect(base_url().'patient-sign-up');
            $title['title'] = "My Profile - DentView Dental Clinic";
            $this->load->view('header',$title);
            $this->load->view('doctor_profile');
            //$this->load->view('footer');
        }
        else
        {
            
            $first_name = $this->input->post('first_name');
            $mi = $this->input->post('mi');
            $last_name = $this->input->post('last_name');
            $email_add = $this->input->post('email_add');
            $password = $this->input->post('password');
            $address = $this->input->post('address');
            //$last_logged_in = date('Y-m-d');
            $doctor_info = array(
                'id' => $this->session->userdata['doctor_info']['id'],
                'first_name' => $first_name,
                'mi' => $mi,
                'last_name' => $last_name,
                'email_add' => $email_add,
                'password' => $password,
                'address' => $address,
               // 'last_logged_in' => $last_logged_in
                            );

            $result = $this->doctor_model->update($doctor_info);
            $this->doctor_model->password_check();
            $doctor = $this->doctor_model->get_doctor_by_id($this->session->userdata['doctor_info']['id']);
            if($result)
            {
                $reservation_info = $this->reservation_model->get_reservation_from_doctor($this->session->userdata['doctor_info']['id']);
                $result_from_photo = $this->photo_model->get_photo('doctor',$this->session->userdata['doctor_info']['id']);
                if($result_from_photo)
                {
                    $patient_info2 = array(
                        'id' => $this->session->userdata['doctor_info']['id'],
                        'first_name' => $doctor['first_name'],
                        'mi' => $doctor['mi'],
                        'last_name' => $doctor['last_name'],
                        'email_add' => $doctor['email_add'],
                        'password' => $doctor['password'],
                        'address' => $doctor['address'],
                        'photo_info' => $result_from_photo,
                        'reservation_info' => $reservation_info
                    );
                    $this->session->set_userdata('doctor_info',$patient_info2);
                    $msg = "Updating your profile is succcessful!";
                }
                else
                {
                    echo "Wrong with retrieving photo.";
                }
            }
            else
            {
                $msg = "There was a failure in editing your data. Please do try again.";
            }
            
            
            $data = array('msg' => $msg,
                'is_edited' => true);
            $title['title'] = "My Profile - DentView Dental Clinic";
            $this->load->view('header',$title);
            $this->load->view('doctor_profile',$data);
            
        }
    }
      
    function upload()
    {
        if(!isset($this->session->userdata['doctor_info']['id']))
        {
            redirect(base_url().'administer');
        }
        
        else
        {
            
                $config['upload_path'] = './uploads/patient';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
                $config['overwrite'] = true;

		$this->load->library('upload', $config);
                //$data = array('uploading_data' => );
		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
                        $path = $data['upload_data']['full_path'];
                        $name = $data['upload_data']['file_name'];
                        $photo_data = $data;
                        $this->resize_picture($path, $name);
                        $photo_from_patient = $this->photo_model->get_photo('doctor',$this->session->userdata['doctor_info']['id']);
                        if(!$photo_from_patient)
                        {
                            $photo_info = array(
                            'from' => 'doctor',
                            'from_id' => $this->session->userdata['doctor_info']['id'],
                            'name' => $this->session->userdata['doctor_info']['first_name'].' '.$this->session->userdata['doctor_info']['last_name'],
                            'description' => '',
                            'source' => base_url().'images/patient/'.$data['upload_data']['file_name'],
                            'status' => 'ACTIVE'
                            );
                        
                            $this->photo_model->insert($photo_info);
                        }
                        else
                        {
                            $photo_info = array(
                            'id' => $photo_from_patient['id'],
                            'from' => 'doctor',
                            'from_id' => $this->session->userdata['doctor_info']['id'],
                            'name' => $this->session->userdata['doctor_info']['first_name'].' '.$this->session->userdata['doctor_info']['last_name'],
                            'description' => '',
                            'source' => base_url().'images/patient/'.$data['upload_data']['file_name'],
                            'status' => 'ACTIVE'
                            );
                            
                            $this->photo_model->update($photo_info);
                            //print_r($photo_info);
                            //echo '<br/>';
                            $reservation_info = $this->reservation_model->get_reservation_from_doctor($this->session->userdata['doctor_info']['id']);
                            $result_from_photo = $this->photo_model->get_photo('doctor',$this->session->userdata['doctor_info']['id']);
                            if($result_from_photo)
                            {
                                $patient_info2 = array(
                                    'id' => $this->session->userdata['doctor_info']['id'],
                                    'first_name' => $this->session->userdata['doctor_info']['first_name'],
                                    'mi' => $this->session->userdata['doctor_info']['mi'],
                                    'last_name' => $this->session->userdata['doctor_info']['last_name'],
                                    'email_add' => $this->session->userdata['doctor_info']['email_add'],
                                    'password' => $this->session->userdata['doctor_info']['password'],
                                    'address' => $this->session->userdata['doctor_info']['address'],
                                    'photo_info' => $result_from_photo,
                                    'reservation_info' => $reservation_info
                                );
                                $this->session->set_userdata('doctor_info',$patient_info2);
                                $msg = "Updating your profile photo is succcessful!";
                            }
                            else
                            {
                                echo "Wrong with retrieving photo.";
                            }
                        }
                        $msg = "Updating your profile photo is succcessful!";
			$data = array('msg' => $msg, 'is_edited' => true);
            $title['title'] = "My Profile - DentView Dental Clinic";
            $this->load->view('header',$title);
            $this->load->view('doctor_profile',$data);
            //$this->load->view('footer');
                }
        }
    }
    
    function resize_picture($path,$name)
    {
            
            $config['image_library']='gd2';
            $config['source_image']=$path;
            $config['width']=200;
            $config['height']=200;
            $config['new_image']='./images/patient/'.$name;
            $this->load->library('image_lib',$config);
            $result=$this->image_lib->resize();
            if(!$result)
                echo $this->image_lib->display_errors();
            //print_r($result);
    }
    
    function services_loader()
    {
        $service_ids = $this->input->post('str');
        $services = $this->service_model->get_all_not($service_ids);
        if(count($services) > 0 && is_array($services))
        {
            ?>

            <fieldset> <legend> Services </legend>
            <?php
            foreach ($services as $service)
                {
                ?>
                <a href="<?php base_url()?>doctor/add_expertise/<?php echo $service['id']?>">Add <?php echo $service['name']?></a>
                <?php
                }
                ?>

                </fieldset>
            <?php
        }
        else
        {
            echo "<p>There are no more services for you to add.</p>";
        }
    }
    
    function log_in()
    {
        $this->load->view('admin_header');
        $this->load->view('doctor_home_view');
    }
    
    function time()
    {
        $this->load->view('time');
    }
    function log_in_validate()
    {
        $email_add = $this->input->post('email_add');
        $doctor_info = $this->doctor_model->get_doctor_by_email($email_add);
        
        if(is_array($doctor_info) && count($doctor_info)>0)
        {
            $confirm = $this->doctor_model->confirm_email_and_password($doctor_info['email_add'],$this->input->post('password'));
            if($confirm)
            {
                $this->session->set_userdata('doctor_info',$doctor_info);
                echo "Successfully logged in";
            }
            else
            {
                echo "Password did not match";
            }
            //redirect(base_url().'doctor/profile');
        }
        else
        {
            $this->load->view('header');
            $this->load->view('doctor_home_view');
        }
    }
    function add_expertise($service_id)
    {
        $expertise_info = array(
            'doctor_id' => $this->session->userdata['doctor_info']['id'],
            'service_id' => $service_id,
            'status' => "ACTIVE"
        );
        $result = $this->expertise_model->insert($expertise_info);
        if(!$result)
        {
            echo "Wrong on adding!";
        }
        else
        {
            echo "Added!";
        }
    }
    function doctor_expertise()
    {
        //echo "asllfhd";
        $doctor_id = $this->input->post('doctor_id');
        $doctor_info = $this->doctor_model->get_doctor_by_id($doctor_id);
        if(is_array($doctor_info) && count($doctor_info)>0)
        {
            $i = 0;
            $expertise_info = $this->expertise_model->get_all_from_doctor($doctor_info['id']);
            if(is_array($expertise_info) && count($expertise_info)>0)
            {
                $i = 0;
                ?>
                <div class="specialist">
                <ul>
                <?php
                foreach($expertise_info as $expertise)
                {
                    $service_info = $this->service_model->get_service($expertise['service_id']);
                    if(is_array($service_info) && count($service_info) > 0)
                    {
                   ?>
                     <li><input type="checkbox" id="<?php echo $service_info['id']?>"
                         <?php if(isset($this->session->userdata['patient_info']['reservation_info']['id']))
                         {
                                 $str = $this->session->userdata['patient_info']['reservation_info']['service_ids'];
                                 if($str != "NONE")
                                 {
                                     $bungks = explode(",", $str);
                                     foreach($bungks as $b)
                                     {
                                         if($b[0] == $service_info['id'])
                                             echo "checked";
                                     }
                                 }
                         }
                         $i++;
                             ?>
                            /><?php echo $service_info['name']; if($i%3==0) echo "</br>"?>
                    <?php
                    }
                }
                ?></li></ul></div>
                
                    <?php
            }
            ?>
                     <?php
        }
    }
    
    function log_out()
    {
        
            $this->session->unset_userdata('doctor_info');
            echo "Successfully logged out";
        
    }
    
    function notification_send_personal_message()
    {
        $patient_info = $this->patient_model->get_patient_by_id($this->input->post('to_id'));
        if(is_array($patient_info) && count($patient_info) > 0)
        {
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
            
            $notification_info = array(
                  'from' => 'doctor',
                  'to' => 'patient',
                  'from_id' => $this->input->post('from_id'),
                  'to_id' => $this->input->post('to_id'),
                  'about' => 'Personal Message',
                  'msg' => $this->input->post('msg'),
                  'time' => $local_time,
                  'date' => $local_date,
                  'status' => "ACTIVE"
              );
            $confirm = $this->notification_model->insert($notification_info);
            if($confirm)
            {
                echo "Message sent";
            }
            else
            {
                echo "Was not able to send the message";
            }

        }
        else
        {
            echo "Was not able to retrieve info from patient";
        }
       
    }
    
    function notification_update()
    {
        
        $notification_id = $this->input->post('notification_id');
        $notification_info = $this->notification_model->get_notification_by_id($notification_id);
        if(is_array($notification_info) && count($notification_info) > 0)
        {
            $reservation_info = $this->reservation_model->get_reserved($notification_info['from_id']);
            if(is_array($reservation_info) && count($reservation_info) > 0)
            {
                echo date('d/m/Y',strtotime($reservation_info['date']));
            }
            else
            {
                echo "wala";
            }
            $notification_info['status'] = "INACTIVE";
            $this->notification_model->update($notification_info);
        }
        else
        {
            echo "Could not retrieve the notification info";
        }
    }
 }
?>
