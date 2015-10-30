<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if( !defined('BASEPATH') ) exit ('No direct script access allowed');

class admin extends CI_Controller{
    
        private $all_photos;
    //private $all_services;
        private $service_with_photos;
    
      function __construct()
      {
            parent::__construct();

            $this->load->helper('date');
            $this->load->model('admin_model');
            $this->load->model('patient_model');
            $this->load->model('doctor_model');
            $this->load->model('expertise_model');
            $this->load->model('service_model');
            $this->load->model('photo_model');

            $this->load->model('reservation_model');
            $this->load->model('record_model');
            
            
            $this->load->model('tooth_adult_model');
            $this->load->model('tooth_child_model');
            
            $this->load->model('transaction_model');
            
            $this->load->model('prescription_model');
            $this->load->model('system_model');
            
            $this->load->model('customer_care_model');
            
            $this->load->model('notification_model');
            
            $this->load->model('secretary_model');
            $this->load->helper('url');
            $this->load->helper(array('form', 'url'));

            $this->load->model('faq_model');
            //automatic update
            //$this->reservation_model->automatic_update();
            
            $photos = $this->photo_model->get_all_photo_from_service();
            $services = $this->service_model->get_all_active_or_inactive();
            for($i=0;;$i++)
            {

                $str = str_ireplace(" ", "-", $services[$i]['name']);
                //echo $str;
                $services[$i]['name_replaced'] = $str;
                $services[$i]['photo'] = $this->photo_model->get_all_photo_from_service_id($services[$i]['id']);
                if(!isset($services[$i+1]))
                {
                    break;
                }

            }
            
        $this->service_with_photos = $services;
        $this->all_photos = $photos;

      }
      
      function log_in_validate()
      {
        
          $admin = $this->admin_model->get_admin_by_email($this->input->post('email_add'));
          if($admin)
          {
              $confirm = $this->admin_model->confirm_email_and_password($admin['email_add'],$this->input->post('password'));
              if($confirm)
              {
                  $this->session->set_userdata('admin_info',$admin);
                  
                  $doctor = $this->doctor_model->get_doctor_by_email($this->input->post('email_add'));
                  if(is_array($doctor) && count($doctor) > 0)
                  {
                      
                      //$confirm_doctor = $this->doctor_model->confirm_email_and_password($doctor['email_add'],$this->input->post('password'));
                      if($doctor['password'] == $this->encrypt->sha1($this->input->post('password')))
                      $this->session->set_userdata('doctor_info',$doctor);
                  }
                  
                  
              }
              else
              {
                  echo 1;
              }
          }
          else
          {
              echo 0;
          }
        
      }
      function log_out()
      {
          if(isset($this->session->userdata['admin_info']))
                $this->session->unset_userdata('admin_info');
          if(isset($this->session->userdata['doctor_info']))
                $this->session->unset_userdata('doctor_info');
          
          redirect(base_url().'administer');
      }
      function administer($function = null,$id = null)
      {
          if(isset($this->session->userdata['doctor_info']['id']))
          {
              $doctor = $this->session->userdata['doctor_info'];
              $notification_info = $this->notification_model->get_notification_for_doctor_about("Reservation",$doctor['id']);
              $doctor['notification_info'] = $notification_info;
              $this->session->set_userdata('doctor_info',$doctor);
          }
          
          if($function == "patient")
          {
                if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
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
              $this->load->view('admin_output_loader');
              $this->load->view('admin_manage_patient',$complete_info);
              $this->load->view('forms');
          }
          }
          if($function == "admin")
          {
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
                }
                else
                {
              $admins = $this->admin_model->get_all();
              $admin = array('admins' => $admins);
              $this->load->view('admin_header');
              $this->load->view('admin_output_loader');
              $this->load->view('admin_view_all',$admin);
                }
              //$this->load->view('forms');
          }
          if($function == 'doctor')
          {
          
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
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
                  $this->load->view('admin_output_loader');
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
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
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
                  $this->load->view('admin_output_loader');
                  $this->load->view('admin_manage_service',$service);
              
          }
          }
          elseif($function == "reservation")
          {
            if(!isset($this->session->userdata['admin_info']['id']))
            {
              redirect(base_url().'administer');
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
                  $reservation_active = $this->reservation_model->get_all_active_arranged_by_desc();
                  
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
                  $reservation_inactive = $this->reservation_model->get_all_inactive_arranged_by_desc();
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
                  $this->load->view('admin_output_loader');
                  $this->load->view('admin_manage_reservation',$reservation);
              }
          }
          if($function == "prescription")
          {
              
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
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
              
              $prescriptions = $this->prescription_model->get_all();
              if(!is_array($prescriptions) || count($prescriptions) < 1)
              {
                  $prescriptions = false;
              }
              elseif(is_array($prescriptions) || count($prescriptions) > 0)
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
              $data['patients'] = $patients;
              $data['doctors'] = $doctors;
              $data['prescriptions'] = $prescriptions;
              $this->load->view('admin_header');
              $this->load->view('admin_output_loader');
              $this->load->view('admin_manage_prescription',$data);
          }
          }
          if($function == "candidates")
          {
              
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
                }
                else
                {
                    
              $candidates = $this->reservation_model->get_candidates();
              if(is_array($candidates) && count($candidates) > 0)
              {
                  
                  for($i=0;$i<count($candidates);$i++)
                  {
                      $candidates[$i]['patient_info'] = $this->patient_model->get_patient_by_id($candidates[$i]['patient_id']);
                  }
                  $data['candidates'] = $candidates;
                  
                    $this->load->view('admin_header');
                    $this->load->view('admin_output_loader');
                  $this->load->view('admin_manage_candidate',$data);
              }
              else
              {
                  $data['candidates'] = false;
                  $this->load->view('admin_header');
                    $this->load->view('admin_output_loader');
                  $this->load->view('admin_manage_candidate',$data);
              }
          }
          }
          if($function == "system_time")
          {
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
                }
                else
                {
                $today = date('m/d/Y');
                $system_infos = $this->system_model->get_date_active_or_inactive($today);
                
                $data['system_info'] = $system_infos;
                $this->load->view('admin_header');
                $this->load->view('admin_output_loader');
                $this->load->view('admin_manage_system',$data);
          }
          }
          
          if($function == "customer_care")
          {
              if(!isset($this->session->userdata['admin_info']['id']))
                {
                  redirect(base_url().'administer');
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
                    $this->load->view('admin_output_loader');
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
              $this->load->view('admin_output_loader');
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
              $this->load->view('admin_output_loader');
              $this->load->view('admin_manage_secretary',$data);
          }
          elseif($function == null)
          {
                $this->load->view('admin_header');
                $this->load->view('admin_output_loader');
          }
          
      }
      
      function doctor_add_service($doctor_id,$service_id)
      {
          
          $doctor_info = $this->doctor_model->get_doctor_by_id($doctor_id);
          $service_info = $this->service_model->get_service_active_or_inactive($service_id);
          if(is_array($doctor_info)&&count($doctor_info)>0&&is_array($service_info)&&count($service_info)>0)
          {
              $expertise_info = array(
                  'doctor_id' => $doctor_info['id'],
                  'service_id' => $service_info['id']
              );
              
              $confirm = $this->expertise_model->insert($expertise_info);
              if($confirm)
              {
                  echo "Successfully added";
              }
              else
              {
                  echo "Something went wrong";
              }
          }
          else
          {
              redirect(base_url().'administer');
          }
      }
      
      function view_patients()
      {
//          if(!isset($this->session->userdata['admin_info']['id']))
//          {
//              redirect(base_url().'administer');
//          }
          $patients = $this->patient_model->get_all();
          $patient = array('patients' => $patients);
          
          $this->load->view('admin_header');
          $this->load->view('admin_output_loader');
          $this->load->view('admin_view_patients',$patient);
          $this->load->view('forms');
      }
      function patient_for_edit_and_activate()
      {
//          if(!isset($this->session->userdata['admin_info']['id']))
//          {
//              redirect(base_url().'administer');
//          }
          $patient_id = $this->input->post('patient_id');
              $patient = $this->patient_model->get_patient_by_id($patient_id);
            
              echo "
                        <div class='bg_table' style='height:320px'>
                        <input type='hidden'  name='id' value='".$patient['id']."' id='patient_id'>
                        <h3 style='color:#069; margin-left:10px;'>Patient info</h3>
                        <div class='p_adjust'></div>
                        First Name:<span class='p_fname'><input type='text' name='first_name' id='patient_first_name' class='patient_info' value='".$patient['first_name']."'></span></br>
                        Middle Initial:<span class='p_mi'><input type='text' name='mi' id='patient_mi' class='patient_info' value='".$patient['mi']."'></span></br>
                        Last Name:<span class=' p_lname'><input type='text' name='last_name' id='patient_last_name' class='patient_info' value='".$patient['last_name']."'></span></br>
                        Mobile Number:<span class=' p_mobile'><input type='text' name='mobile_number' class='patient_info' id='patient_mobile_number' value='".$patient['mobile_number']."'></span></br>
                        Last Logged in:<span class=' p_llogin'><input type='text' name='last_logged_in' id='patient_last_logged_in' class='patient_info' value='".$patient['last_logged_in']."'></span></br>
                        Address:<span class=' p_address'><input type='text' name='address' class='patient_info' id='patient_address' value='".$patient['address']."'></span></br>
                        Email Address:<span class='p_emladd'><input type='text' class='p_emladd' name='email_add' id='patient_email_add' value='".$patient['email_add']."'></span>
                        <input type='hidden' value='".$patient['password']."' name='password' id='patient_password'>    
                            <input type='button' value='Edit' class='logbtn p_btn' id='edit_patient'>
                            </div>
                        <div id='display_message' style='display:none'>
                        </div>

                        <script>
                            $('#edit_patient').click(function(){
                                var form_data = {
                                    id : $('#patient_id').val(),
                                    first_name : $('#patient_first_name').val(),
                                    mi : $('#patient_mi').val(),
                                    last_name : $('#patient_last_name').val(),
                                    last_logged_in : $('#patient_last_logged_in').val(),
                                    mobile_number : $('#patient_mobile_number').val(),
                                    address : $('#patient_address').val(),
                                    email_add : $('#patient_email_add').val(),
                                    password : $('#patient_password').val()
                                }
                                $.ajax({
                                    url:'".base_url()."administer-patient-edit',
                                    type:'POST',
                                    data:form_data,
                                    success:function(msg){
                                        noty({type:'notification',text:msg});
                                        window.location = document.location;
                                    }
                                })
                            })
                        </script>
                        
                        <script>
                            $('#patient_email_add').change(function(){
                                var x=$(this).val();
                                var atpos=x.indexOf('@');
                                var dotpos=x.lastIndexOf('.');
                                if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
                                {
                                  //$('#image_for_email').hmtl('OK');
                                  document.getElementById('edit_patient').disabled = true;
                                  alert('This '+ x +' email address is not valid. The edit button is disabled. It will only enable if you write a valid email address.');
                                  $('#patient_email_add').val(''+x);
                                }
                                else
                                {
                                    document.getElementById('edit_patient').disabled = false;
                                }
                            })
                        </script>
                        
                        
                      ";
             
      }
      function patient_for_edit()
      {
//          if(!isset($this->session->userdata['admin_info']['id']))
//          {
//              redirect(base_url().'administer');
//          }
          //<form method='POST' action='".base_url()."admin/patient_edit'>
          
              //$patient_id = $this->input->post('patient_id');
              //$photo;
              $patient_id = $this->input->post('patient_id');
              $patient = $this->patient_model->get_patient_by_id($patient_id);
//              $p['patient'] = $patient;
//              $this->load->view('header');
//              $this->load->view('admin_edit_patient',$p);
//              
              //echo $patient_id;
              //$patient_status = $patient['status'];
              
                  echo "
                      <div class='bg_table' style='height:320px'>
                            <input type='hidden'  name='id' value='".$patient['id']."' id='patient_id'>
                        <h3 style='color:#069; margin-left:10px;'>Patient info</h3>
                        <div class='p_adjust'></div>
                        First Name:<span class='p_fname'><input type='text' name='first_name' id='patient_first_name' class='patient_info' value='".$patient['first_name']."'></span></br>
                        Middle Initial:<span class='p_mi'><input type='text' name='mi' id='patient_mi' class='patient_info' value='".$patient['mi']."'></span></br>
                        Last Name:<span class=' p_lname'><input type='text' name='last_name' id='patient_last_name' class='patient_info' value='".$patient['last_name']."'></span></br>
                        Mobile Number:<span class=' p_mobile'><input type='text' name='mobile_number' class='patient_info' id='patient_mobile_number' value='".$patient['mobile_number']."'></span></br>
                        Last Logged in:<span class=' p_llogin'><input type='text' name='last_logged_in' id='patient_last_logged_in' class='patient_info' value='".$patient['last_logged_in']."'></span></br>
                        Address:<span class=' p_address'><input type='text' name='address' class='patient_info' id='patient_address' value='".$patient['address']."'></span></br>
                        Email Address:<span class='p_emladd'><input type='text' class='p_emladd' name='email_add' id='patient_email_add' value='".$patient['email_add']."'></span>
                        <input type='hidden' value='".$patient['password']."' name='password' id='patient_password'>
                            <input type='button' value='Edit' class='logbtn p_btn' id='edit_patient'/>
                           </div> 
                        <div id='display_message' style='display:none'>
                        </div>

                        <script>
                            $('#edit_patient').click(function(){
                                //alert($('#patient_mobile_number').val());
                                var form_data = {
                                    id : $('#patient_id').val(),
                                    first_name : $('#patient_first_name').val(),
                                    mi : $('#patient_mi').val(),
                                    last_name : $('#patient_last_name').val(),
                                    last_logged_in : $('#patient_last_logged_in').val(),
                                    mobile_number : $('#patient_mobile_number').val(),
                                    address : $('#patient_address').val(),
                                    email_add : $('#patient_email_add').val(),
                                    password : $('#patient_password').val()
                                }
                                $.ajax({
                                    url:'".base_url()."administer-patient-edit',
                                    type:'POST',
                                    data:form_data,
                                    success:function(msg){
                                        noty({type:'notification',text:msg});
                                        
                                    }
                                })
                            })
                        </script>
                        
                        <script>
                            $('#patient_email_add').change(function(){
                                var x=$(this).val();
                                var atpos=x.indexOf('@');
                                var dotpos=x.lastIndexOf('.');
                                if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
                                {
                                  //$('#image_for_email').hmtl('OK');
                                  document.getElementById('edit_patient').disabled = true;
                                  alert('This '+ x +' email address is not valid. The edit button is disabled. It will only enable if you write a valid email address.');
                                  $('#patient_email_add').val(''+x);
                                }
                                else
                                {
                                    document.getElementById('edit_patient').disabled = false;
                                }
                            })
                        </script>
                        
                        
                      ";
              
            
          
      }
      function doctor_deactivate_service($doctor_id = null,$service_id = null)
      {
          if($doctor_id == null || $service_id == null)
          {
              echo "<script>
                        $(document).ready(function(){
                            alert('empty!');
                        });
                  </script>";
          }
          else
          {
              $confirm = $this->expertise_model->deactivate($doctor_id,$service_id);
              if($confirm)
              {
                  echo "Successfully added deactivated a service";
              }
              else
              {
                  echo "Something went wrong with deactivating service";
              }
          }
      }
      
      function patient_deactivate()
      {
//          if(!isset($this->session->userdata['admin_info']['id']))
//          {
//              redirect(base_url().'administer');
//          }
          $patient_id = $this->input->post('patient_id');
          $confirm = $this->patient_model->deactivate($patient_id);
          if($confirm)
              echo "Successfully deactivated";
          else
              echo "Something went wrong";
          //echo "alallaalh!";
      }
      
      function patient_activate()
      {
          
//          if(!isset($this->session->userdata['admin_info']['id']))
//          {
//              redirect(base_url().'administer');
//          }
          $patient_id = $this->input->post('patient_id');
          $confirm = $this->patient_model->activate($patient_id);
          if($confirm)
              echo "Successfully activated";
          else
              echo "Something went wrong";
      }
      function patient_edit()
      {
//          if(!isset($this->session->userdata['admin_info']['id']))
//          {
//              redirect(base_url().'administer');
//          }
          $patient_info['id'] = $this->input->post('id');
          $patient_info['first_name'] = $this->input->post('first_name');
          $patient_info['mi'] = $this->input->post('mi');
          $patient_info['last_name'] = $this->input->post('last_name');
          $patient_info['email_add'] = $this->input->post('email_add');
          $patient_info['mobile_number'] = $this->input->post('mobile_number');
          $patient_info['address'] = $this->input->post('address');
          $patient_info['last_logged_in'] = $this->input->post('last_logged_in');
          $patient_info['password'] = $this->input->post('password');
          
          //echo "POST: ".$this->input->post('mobile_number');
          
          
          $confirm = $this->patient_model->update($patient_info);
          if($confirm)
          {
              echo "Successfully edited";
          }
          else
          {
              echo "Something went wrong";
          }
          
      }
      
      function doctor_edit()
      {
          if(!isset($this->session->userdata['admin_info']['id']))
          {
              redirect(base_url().'administer');
          }
          else
          {
          $doctor_info['id'] = $this->input->post('id');
          $doctor_info['first_name'] = $this->input->post('first_name');
          $doctor_info['mi'] = $this->input->post('mi');
          $doctor_info['last_name'] = $this->input->post('last_name');
          $doctor_info['address'] = $this->input->post('address');
          $doctor_info['email_add'] = $this->input->post('email_add');
          $doctor_info['password'] = $this->encrypt->sha1($this->input->post('password'));
          $doctor_info['license'] = $this->input->post('license');
          $confirm = $this->doctor_model->update($doctor_info);
          if($confirm)
          {
              echo "Edited";
          }
          else
          {
              echo "Something went wrong!";
          }
          }
      }
      function add_doctor()
      {
          if(!isset($this->session->userdata['admin_info']['id']))
          {
              redirect(base_url().'administer');
              
          }
          else
          {
              $doctor_info['email_add'] = $this->input->post('email_add');
              $doctor_info['password'] = $this->input->post('password');
              $doctor_info['first_name'] = $this->input->post('first_name');
              $doctor_info['mi'] = $this->input->post('mi');
              $doctor_info['last_name'] = $this->input->post('last_name');
              $doctor_info['address'] = $this->input->post('address');
                       
              $confirm = $this->doctor_model->insert($doctor_info);
              if($confirm)
              {
                  $admin_info = array(
                      'first_name' => $doctor_info['first_name'],
                      'last_name' => $doctor_info['last_name'],
                      'email_add' => $doctor_info['email_add'],
                      'password' => $doctor_info['password'],
                      'approved_by' => $this->session->userdata['admin_info']['first_name']." ".$this->session->userdata['admin_info']['last_name'],
                      'status' => 'ACTIVE'
                  );
                  $confirm = $this->admin_model->insert($admin_info);
                  if($confirm)
                    echo "Successfully added a doctor and an admin account";
                  else
                      echo "Was unable to save the doctor as admin";
              }
              else
              {
                  echo "Something went wrong during adding a doctor";
              }
          }
      }
      
      function sign_up_validate()
      {
          if(!isset($this->session->userdata['admin_info']['id']))
          {
              redirect(base_url().'administer');
          }
          $is_from_ajax = $this->input->post('is_from_ajax');
          if($is_from_ajax == 1)
          {
              $admin = $this->admin_model->get_admin_by_email($this->input->post('email_add'));
              if($admin)
                  echo true;
              else
                  echo false;
          }
          else
          {
              $admin_info['email_add'] = $this->input->post('email_add');
              $admin_info['password'] = $this->input->post('password');
              $admin_info['first_name'] = $this->input->post('first_name');
              $admin_info['last_name'] = $this->input->post('last_name');
              $admin_info['approved_by'] = $this->input->post('approved_by');
              
              $confirm = $this->admin_model->insert($admin_info);
              if($confirm)
              {
                  echo "Successfully edited";
              }
              else
              {
                  echo "Something went wrong during the registration";
              }
          }
      }
      
      function upload($from = null, $from_id = null)
      {
          if(isset($this->session->userdata['doctor_info']['id']))
          {
              $doctor = $this->session->userdata['doctor_info'];
              $notification_info = $this->notification_model->get_notification_for_doctor_about("Reservation",$doctor['id']);
              $doctor['notification_info'] = $notification_info;
              $this->session->set_userdata('doctor_info',$doctor);
          }
          
          if(isset($this->session->userdata['admin_info']['id']))
          {
          if($from == null && $from_id == null)
              redirect(base_url().'admin/upload/service/1');
          else
          {
//            $photos = $this->get_all_photos($from,$from_id);
//          if(!$photos)
//              $photos = array('photos'=>false);
//          $data = $this->service_model->get_all();
//          $data = array('data' => $data,'photos' => $photos);
//          //print_r($photos);
//          $this->load->view('upload_form',$data);
            $photos = $this->photo_model->get_all_photo_from_service();
            $services = $this->service_model->get_all_active_or_inactive();
            for($i=0;;$i++)
            {

                $str = str_ireplace(" ", "-", $services[$i]['name']);
                //echo $str;
                $services[$i]['name_replaced'] = $str;
                $services[$i]['photo'] = $this->photo_model->get_all_photo_from_service_id_active_or_inactive($services[$i]['id']);
                if(!isset($services[$i+1]))
                {
                    break;
                }

            }
            $this->service_with_photos = $services;
            $this->all_photos = $photos;
            
              $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                'title' => "Services - DentView Dental Clinic" );
                $this->load->view('admin_header',$data);
                
              
              $this->load->view('admin_output_loader');
        //$this->load->view('services');
                //$this->load->view('footer');
              $this->load->view('upload_form',$data);
          }
          }
          
      }
      
      
      
      function do_upload()
	{
                
                
		$config['upload_path'] = './uploads/service';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '200';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
                
                $config['file_name'] = $this->input->post('name');
                $confirm_service_id = $this->service_model->check_id($this->input->post('service_id'));
                
                if(!$confirm_service_id)
                {
                    redirect(base_url().'administer-upload-service/'.$this->input->post('service_id'));
                }
                else
                    $this->load->library('upload', $config);
                
                
		if ( ! $this->upload->do_upload())
		{
                    
                        $photos = $this->photo_model->get_all_photo_from_service();
                    $services = $this->service_model->get_all_active_or_inactive();
                    for($i=0;;$i++)
                    {

                        $str = str_ireplace(" ", "-", $services[$i]['name']);
                        //echo $str;
                        $services[$i]['name_replaced'] = $str;
                        $services[$i]['photo'] = $this->photo_model->get_all_photo_from_service_id_active_or_inactive($services[$i]['id']);
                        if(!isset($services[$i+1]))
                        {
                            break;
                        }

                    }
                    $this->service_with_photos = $services;
                    $this->all_photos = $photos;

                      $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                        'title' => "Services - DentView Dental Clinic" );

                      //$data = $this->service_model->get_all();
                        //        $photos = $this->get_all_photos('service',1);
          
			$error = array('error' => $this->upload->display_errors(),
                            'data' => $data,'photos' => $photos);


                        $this->load->view('admin_header',$data);


                      $this->load->view('admin_output_loader');
                        
			$this->load->view('upload_form', $error);
		}
		else
		{
                        $data = array('upload_data' => $this->upload->data());
                        $name=$data['upload_data']['file_name'];
                        $path=$data['upload_data']['full_path'];
                        $this->resize_picture($path,$name);
			$data = array('upload_data' => $this->upload->data());
                        
                        $photo_info = array(
                            'from' => 'service',
                            'from_id' => $this->input->post('service_id'),
                            'name' => $name,
                            'source' => 'images/service/'.$name,
                            'description' => $this->input->post('description'),
                            'status' => 'ACTIVE'
                        );
                        
                        $result = $this->photo_model->insert($photo_info);
                        if($result)
                        {
                            ?>
                            <script>
                                alert("Your file was successfully uploaded!");
                            </script>
                            <?php
                            redirect(base_url()."admin/upload/service/".$this->input->post('service_id'));
                            //$this->load->view('upload_success', $data);
                        }
                        else 
                        {
                             //$data = $this->service_model->get_all();
                             $photos = $this->photo_model->get_all_photo_from_service();
                            $services = $this->service_model->get_all_active_or_inactive();
                            for($i=0;;$i++)
                            {

                                $str = str_ireplace(" ", "-", $services[$i]['name']);
                                //echo $str;
                                $services[$i]['name_replaced'] = $str;
                                $services[$i]['photo'] = $this->photo_model->get_all_photo_from_service_id_active_or_inactive($services[$i]['id']);
                                if(!isset($services[$i+1]))
                                {
                                    break;
                                }

                            }
                            $this->service_with_photos = $services;
                            $this->all_photos = $photos;

                              $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                                'title' => "Services - DentView Dental Clinic" );

                              //$data = $this->service_model->get_all();
                                //        $photos = $this->get_all_photos('service',1);

                                $error = array('error' => "There was something wrong with the save of the Photo Model",
                                    'data' => $data);


                                $this->load->view('admin_header',$data);


                              $this->load->view('admin_output_loader');

          
			
                        $this->load->view('upload_form', $error);
                        }
		}
                
        }
        
        function doctor_do_upload()
        {
            $doctor = $this->doctor_model->get_doctor_by_id($this->input->post('doctor_id'));
            if($doctor)
            {
                
                $config['upload_path'] = './uploads/doctor';
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
                        $this->doctor_resize_picture($path, $name);
                        $photo_from_patient = $this->photo_model->get_photo('doctor',$doctor['id']);
                        if(!$photo_from_patient)
                        {
                            $photo_info = array(
                            'from' => 'doctor',
                            'from_id' => $doctor['id'],
                            'name' => $doctor['doctor_info']['first_name'].'_'.$doctor['last_name'],
                            'description' => '',
                            'source' => 'images/doctor/'.$data['upload_data']['file_name'],
                            'status' => 'ACTIVE'
                            );
                        
                            $this->photo_model->insert($photo_info);
                        }
                        else
                        {
                            $photo_info = array(
                            'id' => $photo_from_patient['id'],
                            'from' => 'doctor',
                            'from_id' => $doctor['id'],
                            'name' => $doctor['first_name'].'_'.$doctor['last_name'],
                            'description' => '',
                            'source' => 'images/doctor/'.$data['upload_data']['file_name'],
                            'status' => 'ACTIVE'
                            );
                            
                            $this->photo_model->update($photo_info);
                            //print_r($photo_info);
                            //echo '<br/>';
                            
                        }
                        $msg = "Updating your profile photo is succcessful!";
			$data = array('msg' => $msg, 'is_edited' => true);
                        $title['title'] = "My Profile - DentView Dental Clinic";
                        redirect(base_url().'administer/doctor');
                    }
                }
                else
                {
                    "Could not fetch data";
                }
        }
	
        function resize_picture($path,$name)
        {
            
            $config['image_library']='gd2';
            $config['source_image']=$path;
            $config['width']=432;
            $config['height']=600;
            $config['new_image']='./images/service/'.$name;
            $this->load->library('image_lib',$config);
            $result=$this->image_lib->resize();
            if(!$result)
                echo $this->image_lib->display_errors();
            print_r($result);
	}
        
        function doctor_resize_picture($path,$name)
        {
            
            $config['image_library']='gd2';
            $config['source_image']=$path;
            $config['width']=432;
            $config['height']=600;
            $config['new_image']='./images/doctor/'.$name;
            $this->load->library('image_lib',$config);
            $result=$this->image_lib->resize();
            if(!$result)
                echo $this->image_lib->display_errors();
            print_r($result);
	}
        
        function service_add()
        {
            $service_info['name'] = trim($this->input->post('name'));
            $service_info['description'] = trim($this->input->post('description'));
            
            $confirm = $this->service_model->insert($service_info);
            if($confirm)
            {
                echo "Successfully added a new service";
            }
            else
            {
                echo "Something went wrong during the add";
            }
        }
        function service_edit()
        {
            $service_info = $this->service_model->get_service_active_or_inactive($this->input->post('service_id'));
            if(count($service_info) > 0 && is_array($service_info))
            {
                ?>
                    <input type="hidden" id="service_id" value="<?php echo $service_info['id']?>">
                    <div class="bg_table" style="height: 220px; padding:10px;">
                    <div class="p_adjust"></div>
                    <h3 style="color:#069;">Edit</h3>
                    Name : <span style="margin-left:50px; padding-left:2px;"><input type="text" id="service_name" value="<?php echo $service_info['name']?>"></span> </br>
                    Description : <span style="margin-left:17px; padding-left:2px;"><input type="text" id="service_description" value="<?php echo $service_info['description']?>"></span></br>
                    <input class="admn_btn" type="button" id="service_edit_button" value="Save">
                    </div>
                    <script>
                        $('#service_edit_button').click(function(){
                            var form_data = {
                                id : $('#service_id').val(),
                                name : $('#service_name').val(),
                                description : $('#service_description').val()
                            }
                            $.ajax({
                                url : "<?php echo base_url()?>admin/service_edit_save",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:"notification",text:msg});
                                }
                            })
                        })
                    </script>
                <?php
            }
            else
            {
                echo "ID of service does not exist";
            }
        }
        function service_edit_save()
        {
            $service_info = $this->service_model->get_service($this->input->post('id'));
            if(is_array($service_info) && count($service_info)>0)
            {
                $service_info['name'] = $this->input->post('name');
                $service_info['description'] = $this->input->post('description');
                
                $confirm = $this->service_model->update($service_info);
                if($confirm)
                {
                    echo "Successfully edited";
                }
                else
                {
                    echo "Something went wrong with the update";
                }
            }
            else
            {
                echo "Could not retrieve service data";
            }
        }
        function get_all_photos($from, $from_id)
        {
            $photos = $this->photo_model->get_photo($from,$from_id);
            
            //print_r($photos);
            //echo $link;
            if($photos)
            {
                return $photos;
            }
            else 
            {
                return false;
            }
        }
        
        function log_on_($chosen = null)
        {
            if($chosen == null)
            {
                redirect(base_url().'administer');
            }
            if($chosen == 'admin')
            {
                $this->session->unset_userdata('doctor_info');
                redirect(base_url().'administer');
            }
            else
            {
                $this->session->unset_userdata('admin_info');
                redirect(base_url().'doctor-profile');
            }
            
            //redirect(base_url().'administer');
        }
        
        function service_activate()
        {
            $service_id = $this->input->post('service_id');
            $service_info = $this->service_model->get_service_active_or_inactive($service_id);
            if($service_info && count($service_info) > 0)
            {
                if($service_info['status'] == "ACTIVE")
                {
                    echo "Service is already active";
                }
                else
                {
                    $service_info['status'] = "ACTIVE";
                    $confirm = $this->service_model->update($service_info);
                    if($confirm)
                    {
                        echo "Successfully activated";
                    }
                    else
                    {
                        echo "Something went wrong with the activation";
                    }
                }
            }
            else
            {
                echo "ID does not exist";
            }
        }
        
        function service_deactivate()
        {
            $service_id = $this->input->post('service_id');
            $service_info = $this->service_model->get_service_active_or_inactive($service_id);
            if($service_info && count($service_info) > 0)
            {
                if($service_info['status'] == "INACTIVE")
                {
                    echo "Service is already inactive";
                }
                else
                {
                    $service_info['status'] = "INACTIVE";
                    $confirm = $this->service_model->update($service_info);
                    if($confirm)
                    {
                        echo "Successfully deactivated";
                    }
                    else
                    {
                        echo "Something went wrong with the deactivation";
                    }
                }
            }
            else
            {
                echo "ID does not exist";
            }
        }
        
        function reschedule()
        {
            $whole_day = false;
            $time_start = 10;
            $time_end = 20;
            $day = $this->input->post('day');
            $reservation_id = $this->input->post('reservation_id');
            $reservation_info = $this->reservation_model->get_reservation($reservation_id);
            if(is_array($reservation_info) && count($reservation_info) > 0)
            {
                $timestamp = now();
                $timezone = 'UP8';
                $daylight_saving = false;


                $timer = unix_to_human(now());
                if(date('Ymd') == date('Ymd', strtotime($this->input->post('date'))))
                {
                    $system_info = $this->system_model->get_date(date('m/d/Y', strtotime($this->input->post('date'))));
                    if(is_array($system_info) && count($system_info) > 0)
                    {
                        //$time_start = $system_info['time_in'];
                         if($system_info['whole_day'] == 1 || $system_info['whole_day'] == true)
                         {
                             $whole_day = true;
                         }
                         else
                         {
                             $whole_day = false;
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
                    
                    //$time_start = ($timer[11].$timer[12])+9;
                    //echo $time_start;
                    //echo $time_start;
                    
                    if($time_start > 20)
                    {
                        ?>
                        
                        You are not allowed to make reservations as of now. Adjust to tomorrow instead.
                    <?php
                        
                    }
                    else
                    {
                        if($time_start < 7)
                        {
                            $time_start = 10;
                        }
                        
                        if($day == 0 && $time_start <= 13)
                        {
                            $time_start = 13;
                        }
                       
                        $date = date_create($this->input->post('date'));
                        $date_formatted = date_format($date, "Y-m-d");
                        $date_not_available = $this->reservation_model->get_reserved_by_doctor_date($reservation_info['doctor_id'],$date_formatted);
                        if(is_array($date_not_available))
                        {
                            for($i = 0; $i < count($date_not_available); $i++)
                            {
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

//                    
                    $system_info = $this->system_model->get_date(date('m/d/Y', strtotime($this->input->post('date'))));
                    if(is_array($system_info) && count($system_info) > 0)
                    {
                        if($system_info['whole_day'] == 1 || $system_info['whole_day'] == true)
                         {
                             $whole_day = true;
                         }
                         else
                         {
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

                    $date = date_create($this->input->post('date'));
                    $date_formatted = date_format($date, "Y-m-d");
                    $date_not_available = $this->reservation_model->get_reserved_by_doctor_date($reservation_info['doctor_id'],$date_formatted);
                    if(is_array($date_not_available))
                    {
                        for($i = 0; $i < count($date_not_available); $i++)
                        {
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
            else
            {
                echo "Could not retrieve reservation data";
            }
            
            
        }
        function reschedule_validate()
        {
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
            
                $reservation_id = $this->input->post('reservation_id');
                $reservation_info = $this->reservation_model->get_reservation($reservation_id);
                $reservation_before = $this->reservation_model->get_reservation($reservation_id);
                if(count($reservation_info) > 0 && is_array($reservation_info))
                {
                    $reservation_info['time'] = date("H:i:s", strtotime($this->input->post('time')));;
                    $date = date_create($this->input->post('date'));
                    $time_for_doctor = $this->input->post('time');
                    $reservation_info['date'] = date_format($date, "Y-m-d");
                    $reservation_info['status'] = "ACTIVE";
                    
                    
                    $confirm = $this->reservation_model->update($reservation_info);
                    if($confirm)
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
                                $date_info = date("F d Y",  strtotime($reservation_info['date']));
                             $time_before = abs($reservation_before['time'][0].$reservation_before['time'][1]);
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

                                 
                                     $notification_info = array(
                                          'from' => 'doctor',
                                          'to' => 'patient',
                                          'from_id' => $reservation_info['doctor_id'],
                                          'to_id' => $reservation_info['patient_id'],
                                          'about' => 'Reservation',
                                          'msg' => 'Dr. '.$doctor_info['first_name']." ".$doctor_info['last_name'].' has rescheduled your reservation. You are now scheduled to '.$real_time.','.$date_info.'.',
                                          'time' => $local_time,
                                          'date' => $local_date,
                                          'status' => "ACTIVE",

                                      );
                                     $this->notification_model->insert($notification_info);
                                    // $result = $this->reservation_model->update($reservation_info);
                                    echo "Successfully rescheduled!";
                            }
                            else
                            {
                                echo 'Could not retrieve patient info';
                            }    
                        }
                        else
                        {
                            echo "Was not able to update.";
                        }
                        
                    }
                    else
                    {
                        echo "Was not able to get the data";
                    }
                
                
        }
        
        function photo_edit()
        {
            $photo_id = $this->input->post('photo_id');
            $photo_info = $this->photo_model->get_photo_by_id($photo_id);
            if(is_array($photo_info) && count($photo_info) > 0)
            {
                ?>
                <img src="<?php echo $photo_info['source']?>"></br>
                Name : <input type="text" id="photo_name" value="<?php echo $photo_info['name']?>"> </br>
                Description : <input type="text" id="photo_description" value="<?php echo $photo_info['description']?>"> </br>
                <input type="button" value="Save" id="button_photo_edit_save">
                
                <script>
                    $('#button_photo_edit_save').click(function(){
                        var form_data = {
                            photo_id : $('#input_selected_photo').val(),
                            photo_name : $('#photo_name').val(),
                            photo_description : $('#photo_description').val()
                        }
                        //alert(form_data['photo_id']);
                        $.ajax({
                            url : "<?php echo base_url()?>admin/photo_edit_validate",
                            type : "POST",
                            data : form_data,
                            success : function(msg){
                                $('#success').html(msg)
                                //alert(msg);
                            }
                        })
                    })
                </script>
                
                
                <?php
                
            }
            else
            {
                echo "Something went wrong in retrieving the photo";
            }
        }
        
        function photo_edit_validate()
        {
            //echo "alallalal";
            $photo_id = $this->input->post('photo_id');
            $photo_info = $this->photo_model->get_photo_by_id($photo_id);
            if(is_array($photo_info) && count($photo_info) > 0)
            {
                //$photo_info['status'] = "INACTIVE";
                $photo_info['name'] = $this->input->post('photo_name');
                $photo_info['description'] = $this->input->post('photo_description');
                $confirm = $this->photo_model->update($photo_info);
                if($confirm)
                {
                    echo "Successfully edited this photo";
                }
                else
                {
                    echo "Something went wrong during the update";
                }
            }
            else
            {
                echo "ID does not exist";
            }
        }
        
        function photo_edit_status()
        {
            $photo_id = $this->input->post('photo_id');
            $photo_info = $this->photo_model->get_photo_by_id($photo_id);
            if(is_array($photo_info) && count($photo_info) > 0)
            {
                if($photo_info['status'] == "ACTIVE")
                {
                    $photo_info['status'] = "INACTIVE";
                }
                else
                {
                    $photo_info['status'] = "ACTIVE";
                }
                
                $confirm = $this->photo_model->update($photo_info);
                if($confirm)
                {
                    echo "Successfully edited this photo";
                }
                else
                {
                    echo "Something went wrong during the update";
                }
            }
            else
            {
                echo "ID does not exist";
            }
            
        }
        
        function record_view_patient()
        {
            $this->load->model('record_model');
            $patient_info = $this->patient_model->get_patient_by_id($this->input->post('patient_id'));
            if(is_array($patient_info) && count($patient_info) > 0)
            {
                $patient_record_info = $this->record_model->get_record_by_patient_id($patient_info['id']);
                if(is_array($patient_record_info) && count($patient_record_info))
                {
                    $record['patient_record_info'] = $patient_record_info;
                    $record['patient_info'] = $patient_info;
                    $this->load->view('admin_manage_record',$record);
                }
                else
                {
                    ?>
                    <div id="bckgd">
                    	<div id="patient_record_does_not_exist">
                    		<div class="record_header"></div>
                    			<div class="record_table">
                        <h2>Record of <?php echo $patient_info['first_name']." ".$patient_info['last_name'];?> does not exist.</h2></br>
                        <a href="#" class="h_btn" id="add_patient_record">Add Record</a>
                    		</div>
                    	</div>
                	
                    <div id="div_add_patient_record" style="display: none">
                    <div id="bckgd">
                    <div id="view_h_header"></div>
                    <div id="view_history_table">
                    <div class="p_adjust"></div>
                        <input type="hidden" name="<?php echo $patient_info['id']?>" id="patient_id" value="<?php echo $patient_info['id']?>">
                        Date : <span class="h_date"><input type="text" id="date" ></span></br>
                        Occlusion : <span class="h_occu"><input type="text" id="occlusion"  value=""></span></br>
                        Periodical Condition : <span class="h_pc"><input type="text" id="periodical_condition"  value=""></span></br>
                        Oral Hygiene : <span class="h_oral"><input type="text" id="oral_hygiene" value="" ></span></br>
                        Denture Upper Since : <span class="h_dhs"><input type="text" id="denture_upper_since" value="" ></span></br>
                        Denture Lower Since : <span class="h_dls"><input type="text" id="denture_lower_since" value="" ></span></br>
                        Abnormalities : <span class="h_abnor"><input type="text" id="abnormalities" value="" ></span></br>
                        General Condition : <span class="h_gencon"><input type="text" id="general_condition" value="" ></span></br>
                        Physician : <span class="h_phys"><input type="text" id="physician" value="" ></span></br>
                        Nature Of Treatment : <span class="h_nature"><input type="text" id="nature_of_treatment" value="" ></span></br>
                        Allergies : <span class="h_allergies"><input type="text" id="allergies" value="" ></span></br>
                        Previous History of Bleeding : <span class="h_phb"><input type="text" id="previous_history_of_bleeding" value="" ></span></br>
                        Chronic Ailments : <span class="h_chronic"><input type="text" id="chronic_ailments" value="" ></span></br>
                        Blood Pressure : <span class="h_blood"><input type="text" id="blood_pressure" value="" ></span></br>
                        Drugs Being Taken : <span class="h_drug"><input type="text" id="drugs_being_taken" value="" ></span></br>
                        
                        <input type="button" id="button_add_record" value="Add" class="h_btn_add">
                   	 </div>
                    </div>
                    </div>
                    <script>
                        $('#add_patient_record').click(function(){
                            $('#patient_record_does_not_exist').hide('slow');
                            $('#div_add_patient_record').show('slow');
                        })
                    </script>
                    
                    <script>
                        $('#button_add_record').click(function(){
                            var form_data = {
                                patient_id : $('#patient_id').val(),
                                date : $('#date').val(),
                                occlusion : $('#occlusion').val(),
                                periodical_condition : $('#periodical_condition').val(),
                                oral_hygiene : $('#oral_hygiene').val(),
                                denture_upper_since : $('#denture_upper_since').val(),
                                denture_lower_since : $('#denture_lower_since').val(),
                                abnormalities : $('#abnormalities').val(),
                                general_condition : $('#general_condition').val(),
                                physician : $('#physician').val(),
                                nature_of_treatment : $('#nature_of_treatment').val(),
                                allergies : $('#allergies').val(),
                                previous_history_of_bleeding : $('#previous_history_of_bleeding').val(),
                                chronic_ailments : $('#chronic_ailments').val(),
                                blood_pressure : $('#blood_pressure').val(),
                                drugs_being_taken : $('#drugs_being_taken').val()
                            }
                            //alert(form_data['occlusion']);
                            $.ajax({
                                url : "<?php echo base_url()?>admin/record_add",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:"notification",text:msg});
                                }
                            })
                        })
                    </script>
                    
                    <script>
                        $(function() {
                        $( "#date" ).datepicker({});
                      });
                    </script>

                    
                <?php
                }
            }
        }
        
        function record_add()
        {
            $patient_id = $this->input->post('patient_id');
            $patient_info = $this->patient_model->get_patient_by_id($patient_id);
            if(is_array($patient_info) && count($patient_info) > 0)
            {
                $date = $this->input->post('date');
                $occlusion = $this->input->post('occlusion');
                $periodical_condition = $this->input->post('periodical_condition');
                $oral_hygiene = $this->input->post('oral_hygiene');
                $denture_upper_since = $this->input->post('denture_upper_since');
                $denture_lower_since = $this->input->post('denture_lower_since');
                $abnormalities = $this->input->post('abnormalities');
                $general_condition = $this->input->post('general_condition');
                $physician = $this->input->post('physician');
                $nature_of_treatment = $this->input->post('nature_of_treatment');
                $allergies = $this->input->post('allergies');
                $previous_history_of_bleeding = $this->input->post('previous_history_of_bleeding');
                $chronic_ailments = $this->input->post('chronic_ailments');
                $blood_pressure = $this->input->post('blood_pressure');
                $drugs_being_taken = $this->input->post('drugs_being_taken');

                $record_info = array(
                    'patient_id' => $patient_id,
                    'date' => $date,
                    'occlusion' => $occlusion,
                    'periodical_condition' => $periodical_condition,
                    'oral_hygiene' => $oral_hygiene,
                    'denture_upper_since' => $denture_upper_since,
                    'denture_lower_since' => $denture_lower_since,
                    'abnormalities' => $abnormalities,
                    'general_condition' => $general_condition,
                    'physician' => $physician,
                    'nature_of_treatment' => $nature_of_treatment,
                    'allergies' => $allergies,
                    'previous_history_of_bleeding' => $previous_history_of_bleeding,
                    'chronic_ailments' => $chronic_ailments,
                    'blood_pressure' => $blood_pressure,
                    'drugs_being_taken' => $drugs_being_taken,
                    'status' => "ACTIVE"
                );


                //print_r($record_info);

                $confirm = $this->record_model->insert($record_info);
                if($confirm)
                {
                   echo "Successfully added a new record"; 
                }
                else
                {
                    echo "Something went wrong during the saving of the new record";
                }
            }
            else
            {
                echo "Patient does not exist";
            }
        }
        
        function tooth_view()
        {
            $this->load->model('tooth_adult_model');
            $this->load->model('tooth_child_model');
            $patient_id = $this->input->post('patient_id');
            $patient_info = $this->patient_model->get_patient_by_id($patient_id);
            if(is_array($patient_info) && count($patient_info) > 0)
            {
                if($patient_info['age'] > 12)
                {
                    $tooth_adult_info = $this->tooth_adult_model->get_tooth_adult_by_patient_id($patient_info['id']);
                    if(is_array($tooth_adult_info) && count($tooth_adult_info) > 0)
                    {
                        $record['tooth_adult_info'] = $tooth_adult_info;
                        $record['patient_id'] = $patient_info['id'];
                        $this->load->view('admin_manage_tooth',$record);
                    }
                    else
                    {
                        echo "Patient does not have  old tooth record";
                        $this->load->view('admin_manage_tooth');
                    }
                }
                else
                {
                    $tooth_child_info = $this->tooth_child_model->get_tooth_child_by_patient_id($patient_info['id']);
                    if(is_array($tooth_child_info) && count($tooth_child_info) > 0)
                    {
                        $record['tooth_child_info'] = $tooth_child_info;
                        $record['patient_id'] = $patient_info['id'];
                        $this->load->view('admin_manage_tooth',$record);
                    }
                    else
                    {
                        echo "Patient does not have child tooth record";
                        $this->load->view('admin_manage_tooth');
                    }
                }
                    
            }
            else
            {
                echo "Patient does not exist";
            }
        }
        
        function tooth_adult_save()
        {
            $patient_id = $this->input->post('patient_id');
            $date = $this->input->post('date');
            $number['18'] = $this->input->post('18');
            $number['17'] = $this->input->post('17');
            $number['16'] = $this->input->post('16');
            $number['15'] = $this->input->post('15');
            $number['14'] = $this->input->post('14');
            $number['13'] = $this->input->post('13');
            $number['12'] = $this->input->post('12');
            $number['11'] = $this->input->post('11');
            $number['21'] = $this->input->post('21');
            $number['22'] = $this->input->post('22');
            $number['23'] = $this->input->post('23');
            $number['24'] = $this->input->post('24');
            $number['25'] = $this->input->post('25');
            $number['26'] = $this->input->post('26');
            $number['27'] = $this->input->post('27');
            $number['28'] = $this->input->post('28');
            $number['48'] = $this->input->post('48');
            $number['47'] = $this->input->post('47');
            $number['46'] = $this->input->post('46');
            $number['45'] = $this->input->post('45');
            $number['44'] = $this->input->post('44');
            $number['43'] = $this->input->post('43');
            $number['42'] = $this->input->post('42');
            $number['41'] = $this->input->post('41');
            $number['31'] = $this->input->post('31');
            $number['32'] = $this->input->post('32');
            $number['33'] = $this->input->post('33');
            $number['34'] = $this->input->post('34');
            $number['35'] = $this->input->post('35');
            $number['36'] = $this->input->post('36');
            $number['37'] = $this->input->post('37');
            $number['38'] = $this->input->post('38');
            
            $tooth_adult_info = array(
                "patient_id" => $patient_id,
                "date" => $date,
                '18' => $number['18'],
                '17' => $number['17'],
                '16' => $number['16'],
                '15' => $number['15'],
                '14' => $number['14'],
                '13' => $number['13'],
                '12' => $number['12'],
                '11' => $number['11'],
                '21' => $number['21'],
                '22' => $number['22'],
                '23' => $number['23'],
                '24' => $number['24'],
                '25' => $number['25'],
                '26' => $number['26'],
                '27' => $number['27'],
                '28' => $number['28'],
                '48' => $number['48'],
                '47' => $number['47'],
                '46' => $number['46'],
                '45' => $number['45'],
                '44' => $number['44'],
                '43' => $number['43'],
                '42' => $number['42'],
                '41' => $number['41'],
                '31' => $number['31'],
                '32' => $number['32'],
                '33' => $number['33'],
                '34' => $number['34'],
                '35' => $number['35'],
                '36' => $number['36'],
                '37' => $number['37'],
                '38' => $number['38'],
                'status' => "ACTIVE"
            );
            
            $confirm = $this->tooth_adult_model->update($tooth_adult_info);
            if($confirm)
            {
                echo "Successfully updated";
            }
            else
            {
                
                echo "Something went wrong during the update";
            }
        }
        
        
        function tooth_child_save()
        {
            $patient_id = $this->input->post('patient_id');
            $date = $this->input->post('date');
            $number['55'] = $this->input->post('55');
            $number['54'] = $this->input->post('54');
            $number['53'] = $this->input->post('53');
            $number['52'] = $this->input->post('52');
            $number['51'] = $this->input->post('51');
            $number['61'] = $this->input->post('61');
            $number['62'] = $this->input->post('62');
            $number['63'] = $this->input->post('63');
            $number['64'] = $this->input->post('64');
            $number['65'] = $this->input->post('65');
            $number['85'] = $this->input->post('85');
            $number['84'] = $this->input->post('84');
            $number['83'] = $this->input->post('83');
            $number['82'] = $this->input->post('82');
            $number['81'] = $this->input->post('81');
            $number['71'] = $this->input->post('71');
            $number['72'] = $this->input->post('72');
            $number['73'] = $this->input->post('73');
            $number['74'] = $this->input->post('74');
            $number['75'] = $this->input->post('75');
            
            $tooth_child_info = array(
                "patient_id" => $patient_id,
                "date" => $date,
                '55' => $number['55'],
                '54' => $number['54'],
                '53' => $number['53'],
                '52' => $number['52'],
                '51' => $number['51'],
                '61' => $number['61'],
                '62' => $number['62'],
                '63' => $number['63'],
                '64' => $number['64'],
                '65' => $number['65'],
                '85' => $number['85'],
                '84' => $number['84'],
                '83' => $number['83'],
                '82' => $number['82'],
                '81' => $number['81'],
                '71' => $number['71'],
                '72' => $number['72'],
                '73' => $number['73'],
                '74' => $number['74'],
                '75' => $number['75'],
                'status' => "ACTIVE"
            );
            
            $confirm = $this->tooth_child_model->update($tooth_child_info);
            if($confirm)
            {
                echo "Successfully updated";
                
            }
            else
            {
                echo "Something went wrong during the update";
            }
        }
        function transaction_view()
        {
            $patient_id = $this->input->post('patient_id');
            $patient_info = $this->patient_model->get_patient_by_id($patient_id);
            if(is_array($patient_info) && count($patient_info > 0))
            {
                $transaction_info = $this->transaction_model->get_transaction_by_patient_id($patient_info['id']);
                if(is_array($transaction_info) && count($transaction_info) > 0)
                {
                    $data['patient_transaction_info'] = $transaction_info;
                    $data['patient_info'] = $patient_info;
                    $this->load->view('admin_manage_transaction',$data);
                }
                else
                {
                    ?>
                    <script>
                        $(function() {
                        $("#date").datepicker({});
                        })
                    </script>
                    <div id="bckgd">
					<div id="trans_header"></div>
                    <div class="trans_table">
                    <h3>Patient does not have a record of transaction. </h3>
                    <input type="hidden" id="patient_id" value="<?php echo $patient_info['id']?>"> </br>
                    Date : <span class="t_date"><input type="text" id="date"></span> </br>
                    Treatment Rendered : <span class="t_treat"><input type="text" id="treatment_rendered"></span> </br>
                    Fee : <span class="t_fee"><input type="text" id="fee"></span></br>
                    Paid : <span class="t_paid"><input type="text" id="paid"></span></br>
                    Balance : <span class="t_balance"><input type="text" id="balance"></span> </br>
                    <input type="button" value="Save" id="button_save_transaction" class="h_btn_add">
                    </div>
                    </div>
                    <script>
                        $('#button_save_transaction').click(function(){
                            var form_data = {
                                patient_id : $('#patient_id').val(),
                                date : $('#date').val(),
                                treatment_rendered : $('#treatment_rendered').val(),
                                fee : $('#fee').val(),
                                paid : $('#paid').val(),
                                balance : $('#balance').val()
                            }
                            
                            $.ajax({
                                url : "<?php echo base_url()?>admin/transaction_add",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:"notification",text:msg});
                                }
                            })
                        })
                    </script>
                    <?php
                }
            }
            else
            {
                echo "Patient does not exist";
            }
        }
    function transaction_add()
    {
        $patient_id = $this->input->post('patient_id');
        $date  = $this->input->post('date');
        $treatment_rendered = $this->input->post("treatment_rendered");
        $fee = $this->input->post('fee');
        $paid = $this->input->post('paid');
        $balance = $this->input->post('balance');
        
        $transaction_info = array(
            'patient_id' => $patient_id,
            'date' => $date,
            'treatment_rendered' => $treatment_rendered,
            'fee' => $fee,
            'paid' => $paid,
            'balance' => $balance,
            'status' => "ACTIVE"
        );
        
        $confirm = $this->transaction_model->insert($transaction_info);
        if($confirm)
        {
            echo "Successfully added a transaction";
        }
        else
        {
            echo "Something went wrong during the save of transaction";
        }
     }
     
     function patient_send_mail()
     {
         $email_add = $this->input->post('email_add');
         $subject = $this->input->post('subject');
         $message = $this->input->post('message');
         
         $this->load->library('email');
                //for configuration of email head to ci_day3/application/config/email.php
                //echo $doctor_info['email_add'];
        $this->email->from('DentViewDentalClinic@gmail.com', 'Administrator');
        $this->email->to($email_add);
        $this->email->subject($subject);
        $this->email->message($message);

       // $path = $this->config->item('server_root');
       // $file = $path.'/ci_day3/attachments/yourInfo.txt';

        //$this->email->attach($file);
        if($this->email->send())
        {
            echo "Email sent to patient";
        }
        else
        {
            echo "Something went wrong during the reservation.</br>It might be caused by the slow internet connection.</br>Please do check if the reservation has been successfully made.";
        }
     }
     
     function reservation_deactivate()
     {
         $reservation_id = $this->input->post('reservation_id');
         $reservation_info = $this->reservation_model->get_reservation($reservation_id);
         if(is_array($reservation_info) && count($reservation_info)> 0)
         {
             $reservation_info['status'] = "INACTIVE";
             $confirm = $this->reservation_model->update($reservation_info);
             if($confirm)
             {
                 echo "Successfully deactivated";
             }
             else
             {
                 echo "Something went wrong during the deactivation";
             }
         }
         else
         {
             echo 'Reservation does not exist';
         }
     }
     
     function record_edit()
     {
         $record_id = $this->input->post('record_id');
         $record_info = $this->record_model->get_record($record_id);
         if(is_array($record_info) && count($record_info) > 0)
         {
             ?>
                    <div id="div_edit_patient_record">
                        <input type="hidden" name="<?php echo $record_info['id']?>" id="edit_record_id" value="<?php echo $record_info['id']?>">
                        <input type="hidden" name="<?php echo $record_info['patient_id']?>" id="edit_patient_id" value="<?php echo $record_info['patient_id']?>">
                        Date : <input type="text" id="edit_date_record" value="<?php echo $record_info['date']?>"></br>
                        Occlusion : <input type="text" id="edit_occlusion" value="<?php echo $record_info['occlusion']?>"></br>
                        Periodical Condition : <input type="text" id="edit_periodical_condition" value="<?php echo $record_info['periodical_condition']?>"></br>
                        Oral Hygiene : <input type="text" id="edit_oral_hygiene" value="<?php echo $record_info['oral_hygiene']?>"></br>
                        Denture Upper Since : <input type="text" id="edit_denture_upper_since" value="<?php echo $record_info['denture_upper_since']?>"></br>
                        Denture Lower Since : <input type="text" id="edit_denture_lower_since" value="<?php echo $record_info['denture_lower_since']?>"></br>
                        Abnormalities : <input type="text" id="edit_abnormalities" value="<?php echo $record_info['abnormalities']?>"></br>
                        General Condition : <input type="text" id="edit_general_condition" value="<?php echo $record_info['general_condition']?>"></br>
                        Physician : <input type="text" id="edit_physician" value="<?php echo $record_info['physician']?>"></br>
                        Nature Of Treatment : <input type="text" id="edit_nature_of_treatment" value="<?php echo $record_info['nature_of_treatment']?>"></br>
                        Allergies : <input type="text" id="edit_allergies" value="<?php echo $record_info['allergies']?>"></br>
                        Previous History of Bleeding : <input type="text" id="edit_previous_history_of_bleeding" value="<?php echo $record_info['previous_history_of_bleeding']?>"></br>
                        Chronic Ailments : <input type="text" id="edit_chronic_ailments" value="<?php echo $record_info['chronic_ailments']?>"></br>
                        Blood Pressure : <input type="text" id="edit_blood_pressure" value="<?php echo $record_info['blood_pressure']?>"></br>
                        Drugs Being Taken : <input type="text" id="edit_drugs_being_taken" value="<?php echo $record_info['drugs_being_taken']?>"></br>
                        
                        <input type="button" id="button_edit_record" value="Save">
                        
                        
                        <script>
                            $(function() {
                            $( "#date_record" ).datepicker({});
                          });
                        </script>
                        
                        <script>
                        $('#button_edit_record').click(function(){
                            var form_data = {
                                record_id : $('#edit_record_id').val(),
                                patient_id : $('#edit_patient_id').val(),
                                date : $('#edit_date_record').val(),
                                occlusion : $('#edit_occlusion').val(),
                                periodical_condition : $('#edit_periodical_condition').val(),
                                oral_hygiene : $('#edit_oral_hygiene').val(),
                                denture_upper_since : $('#edit_denture_upper_since').val(),
                                denture_lower_since : $('#edit_denture_lower_since').val(),
                                abnormalities : $('#edit_abnormalities').val(),
                                general_condition : $('#edit_general_condition').val(),
                                physician : $('#edit_physician').val(),
                                nature_of_treatment : $('#edit_nature_of_treatment').val(),
                                allergies : $('#edit_allergies').val(),
                                previous_history_of_bleeding : $('#edit_previous_history_of_bleeding').val(),
                                chronic_ailments : $('#edit_chronic_ailments').val(),
                                blood_pressure : $('#edit_blood_pressure').val(),
                                drugs_being_taken : $('#edit_drugs_being_taken').val()
                            }
                            //alert(form_data['occlusion']);
                            $.ajax({
                                url : "<?php echo base_url()?>admin/record_edit_validate",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:"notification",text:msg});
                                }
                            })
                        })
                    </script>
                    </div>
            <?php
         }
         else
         {
             echo "Record id does not exist";
         }
     }
     
     function record_edit_validate()
     {
         $patient_id = $this->input->post('patient_id');
         $record_id = $this->input->post('record_id');
        $date = $this->input->post('date');
        $occlusion = $this->input->post('occlusion');
        $periodical_condition = $this->input->post('periodical_condition');
        $oral_hygiene = $this->input->post('oral_hygiene');
        $denture_upper_since = $this->input->post('denture_upper_since');
        $denture_lower_since = $this->input->post('denture_lower_since');
        $abnormalities = $this->input->post('abnormalities');
        $general_condition = $this->input->post('general_condition');
        $physician = $this->input->post('physician');
        $nature_of_treatment = $this->input->post('nature_of_treatment');
        $allergies = $this->input->post('allergies');
        $previous_history_of_bleeding = $this->input->post('previous_history_of_bleeding');
        $chronic_ailments = $this->input->post('chronic_ailments');
        $blood_pressure = $this->input->post('blood_pressure');
        $drugs_being_taken = $this->input->post('drugs_being_taken');

        $record_info = array(
            'id' => $record_id,
            'patient_id' => $patient_id,
            'date' => $date,
            'occlusion' => $occlusion,
            'periodical_condition' => $periodical_condition,
            'oral_hygiene' => $oral_hygiene,
            'denture_upper_since' => $denture_upper_since,
            'denture_lower_since' => $denture_lower_since,
            'abnormalities' => $abnormalities,
            'general_condition' => $general_condition,
            'physician' => $physician,
            'nature_of_treatment' => $nature_of_treatment,
            'allergies' => $allergies,
            'previous_history_of_bleeding' => $previous_history_of_bleeding,
            'chronic_ailments' => $chronic_ailments,
            'blood_pressure' => $blood_pressure,
            'drugs_being_taken' => $drugs_being_taken,
            'status' => "ACTIVE"
        );

        $confirm = $this->record_model->update($record_info);
        if($confirm)
        {
            echo "Successfully edited";
        }
        else
        {
            echo "Something went wrong during the edit";
        }

     }
     
     function search_history()
     {
         $patient_id = $this->input->post('patient_id');
         $patient_info = $this->patient_model->get_patient_by_id($patient_id);
         if(is_array($patient_info) && count($patient_info) > 0)
         {
             $record_infos = $this->record_model->get_record_by_patient_id_and_date($patient_info['id'],$this->input->post('date'));
             if(is_array($record_infos) && count($record_infos) > 0)
             {
                 foreach($record_infos as $record)
                    {
                    ?>
                    <fieldset> <legend>Date : <?php echo $record['date']?></legend>
                        <p align="right" class="see_more" name="<?php echo $record['id']?>">See more</p>
                        Occlusion : <?php echo $record['occlusion']?> </br>
                        Periodical Condition : <?php echo $record['periodical_condition']?> </br>
                        Oral Hygiene : <?php echo $record['oral_hygiene']?> </br>
                        Denture Upper Since : <?php echo $record['denture_upper_since']?> </br>
                        <div class="see" name="<?php echo $record['id']?>" style="display:none">
                            Denture Lower Since : <?php echo $record['denture_lower_since']?> </br>
                            Abnormalities : <?php echo $record['abnormalities']?> </br>
                            General Condition : <?php echo $record['general_condition']?> </br>
                            Physician : <?php echo $record['physician']?> </br>
                            Nature of Treatment : <?php echo $record['nature_of_treatment']?> </br>
                            Allergies : <?php echo $record['allergies']?> </br>
                            Previous history of Bleeding : <?php echo $record['previous_history_of_bleeding']?> </br>
                            Chronic Ailments : <?php echo $record['chronic_ailments']?> </br>
                            Blood Pressure : <?php echo $record['blood_pressure']?> </br>
                            Drugs being Taken : <?php echo $record['drugs_being_taken']?> </br>
                        </div>
                    </fieldset>
            <?php
                }
                ?>
                    <a href="#" id="print_2" name="<?php echo $record_infos[0]['id']?>">Print</a></br>
                    
                    <div id="frame" style=" display: none"></div>

                    <script>
                        $('#print_2').click(function(){
                            var record_id = this.name
                            var url = "<?php echo base_url()?>admin/record_print/"+record_id;
                             //var url = this.href;
                             $('#frame').html("<iframe src='"+url+"'></iframe>");
                             window.frames[0].print();
                        })
                    </script>
                
                    <script>
                        $('.see_more').toggle(
                            function(){$('.see').show('slow')},
                            function(){$('.see').hide('slow')}
                        )
                    </script>
                 <?php
             }
             else
             {
                 echo "There are no records of this patient during ".$this->input->post('date');
             }
         }
         else
         {
             echo "Patient does not exist";
         }
     }
     
     function preview()
     {
         $patient_id = $this->input->post('patient_id');
         $patient_info = $this->patient_model->get_patient_by_id($patient_id);
         if(is_array($patient_info))
         {
            $photo_info = $this->photo_model->get_photo('patient',$patient_info['id']);
            ?>
                    
                    <img src="<?php echo base_url().$photo_info['source']?>" style="width:50; height:50; float: left; border: 1px solid #ccc; margin-right: 10px"></br>
                <div>Email : <?php echo $patient_info['email_add']?></br>
                Mobile Number : <?php echo $patient_info['mobile_number']?></br></div>
                    
            <?php
         }
     }
     
     function reserve()
     {
         $whole_day = false;
        $time_start = 10;
        $time_end = 20;
         $date = date_create($this->input->post('date'));
        //$date_for_doctor = unix_to_human($date);
        //$date_for_doctor = unix_to_human(human_to_unix($date));

        $day = $this->input->post('day');
        //echo timezone_location_get($object)
        $timestamp = now();
        $timezone = 'UP8';
        $daylight_saving = true;


        $timer = unix_to_human(gmt_to_local($timestamp, $timezone, $daylight_saving));
        //$time_na_gyud = explode($timer,";");
        //$time_na_gyud = preg_split("/[\s,]+/;", $timer);
        //$str = explode(";", $timer);
        //print_r($str);
        if(date('Ymd') == date('Ymd', strtotime($this->input->post('date'))))
        {
            //echo $timer;
            
            $system_infos = $this->system_model->get_date(date('m/d/Y', strtotime($this->input->post('date'))));
            if(is_array($system_infos) && count($system_infos) > 0)
            {
                foreach($system_infos as $system_info)
                {
                 if($system_info['whole_day'] == 1 || $system_info['whole_day'] == true)
                 {
                     $whole_day = true;
                     break;
                 }
                 else
                 {
                     if($this->input->post('doctor_id') == $system_info['doctor_id'])
                     {
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
                 }
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
                    
                    //print_r($date_not_available);
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
            $system_infos = $this->system_model->get_date(date('m/d/Y', strtotime($this->input->post('date'))));
            if(is_array($system_infos) && count($system_infos) > 0)
            {
                foreach($system_infos as $system_info)
                {
                 if($system_info['whole_day'] == 1 || $system_info['whole_day'] == true)
                 {
                     $whole_day = true;
                     break;
                 }
                 else
                 {
                     if($this->input->post('doctor_id') == $system_info['doctor_id'])
                     {
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
                 }
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
            
            
            
            $time_for_doctor = $this->input->post('time');

            $date_formatted = date_format($date, "Y-m-d");

            $time = date("H:i:s", strtotime($this->input->post('time')));
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
            
                $reservation_info = array(
                    'patient_id' => $this->input->post('patient_id'),
                    'doctor_id' => $this->input->post('doctor_id'),
                    'time' => $time,
                    'hour' => $hour,
                    'service_ids' => $service_ids,
                    'specified_service' => $specified_service,
                    'date' => $date_formatted,
                    'status' => "ACTIVE"

                );
            

            $time_reserved = $this->input->post('time');
            if($time_reserved == null)
            {
                $doctor_id = $this->input->post('doctor_id');
                $date = $date_formatted;
                $date_not_available = $this->reservation_model->get_reserved_by_doctor_date($doctor_id,$date);
                //print_r($date_not_available);
                if(is_array($date_not_available))
                {
                    for($i = 0; $i < count($date_not_available); $i++)
                    {
                        //$patient_infos[] = $this->patient_model->get_patient_by_id($reservation['patient_id']);
                        $date_not_available[$i]['patient_info'] = $this->patient_model->get_patient_by_id($date_not_available[$i]['patient_id']);
                    }
                    $time_info = array('time_info' => $date_not_available,'time_start' => $time_start, 'time_end' => $time_end, 'whole_day' => $whole_day);
                    $this->load->view('time',$time_info);
                }
                else
                    echo $date_not_available;
            }
            else
            {
                //$date_before = date("F d Y",  strtotime($reservation_before['date']));
                 $date_info = date("F d Y",  strtotime($reservation_info['date']));
                 
                $result = $this->reservation_model->insert($reservation_info);
                if($result)
                {
                    //$date_before = date("F d Y",  strtotime($reservation_before['date']));
                         $date_info = date("F d Y",  strtotime($reservation_info['date']));
                         $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['id']);
                         $notification_info = array(
                              'from' => 'admin',
                              'to' => 'patient',
                              'from_id' => $reservation_info['doctor_id'],
                              'to_id' => $reservation_info['patient_id'],
                              'about' => 'Reservation',
                              'msg' => 'Dr. '.$doctor_info['first_name']." ".$doctor_info['last_name'].' is your Dentist in your schedule on '.$this->input->post('time').', '.$date_info.'.',
                              'time' => $local_time,
                              'date' => $local_date,
                              'status' => "ACTIVE",

                          );
                         $this->notification_model->insert($notification_info);
                         $patient_info = $this->patient_model->get_patient_by_id($reservation_info['patient_id']);
                        echo $patient_info['first_name'].' '.$patient_info['last_name']." is now reserved!";

                }
                else 
                {
                    echo "Something went wrong with the reservation.";
                }
            }
        }
     }
     function patient_preview()
     {
         $patient_id = $this->input->post('patient_id');
         $patient_info = $this->patient_model->get_patient_by_id($patient_id);
         if(is_array($patient_info) && count($patient_info) > 0)
         {
             $photo_info = $this->photo_model->get_photo('patient',$patient_info['id']);
             ?>
                <div style="float:left; margin-right:10px; padding-left:5px;"><img src="<?php echo base_url().$photo_info['source']?>" style="width: 70; height: 70; border:1px solid #ccc;"></div>
               <div style="text-align:left;"> Email : <?php echo $patient_info['email_add']?> </br>
                Mobile Number : <?php echo $patient_info['mobile_number']?></br>
                Address : <?php echo $patient_info['address']?></br>
                Age : <?php echo $patient_info['age']?></div>
             <?php
         }
     }
     
     function prescription_finalize()
     {
         $patient_info = $this->patient_model->get_patient_by_id($this->input->post('patient_id'));
         if(is_array($patient_info) && count($patient_info) > 0)
         {
             $doctor_info = $this->doctor_model->get_doctor_by_id($this->input->post('doctor_id'));
             if(is_array($doctor_info) && count($doctor_info) > 0)
             {
                 $date = $this->input->post('date');
                 if($date == "")
                 {
                     $date = date("m/d/Y");
                 }
                 $remarks = $this->input->post('remarks');
                 $medicine = $this->input->post('medicine');
                 ?>
                <div id="patient">
                 <center><img src="<?php echo base_url()?>css/admin_css/logo.png" style=" background-color: #3CC;" title="DentView Dental Clinic" width="320" height="64" border="0" alt="DentView Dental Clinic"/></center>
                 <hr>
                 
                 <div style="height: 100px; width: 220px; position: relative">
                 <p align = "left">
                     Location : 
                     Lower Ground Floor</br>
                     APM Shopping Mall</br>
                     North Reclamation Area, Cebu City
                 </p>
                 </div>
                 
                 <div style="height: 100px; width: 265px; position: absolute;  margin-left: 230px;margin-top: -102px; ">
                 <p align = "right">
                     Website : <?php echo base_url()?></br>
                     Email Add : dentviewdentalclinic@gmail.com</br>
                     Telephone no. : 413 - 2020
                 </p>
                 </div>
                 <hr>
                 </br>
                 <input type="hidden" id="prescription_date" value="<?php echo $date;?>">
                 <p align="right"> Date : <?php echo $date;?></p></br>
                 
                 <input type="hidden" id="patient_name" value="<?php echo $patient_info['first_name']." ".$patient_info['last_name']?>">
                 <input type="hidden" id="prescription_patient_id" value="<?php echo $patient_info['id']?>">
                 Name : <?php echo $patient_info['first_name']." ".$patient_info['last_name']?></br>
                 Age : <?php echo $patient_info['age']?></br>
                 Gender : <?php echo $patient_info['gender']?></br>
                 Address : <?php echo $patient_info['address']?> </br></br></br>
                 
                 <input type="hidden" id="prescription_medicine" value="<?php echo $medicine; ?>">
                 Medicine : <?php echo $medicine; ?></br>
                 <input type="hidden" id="prescription_remarks" value="<?php echo $remarks; ?>">
                 Remarks : <?php echo $remarks; ?></br>
                 
                 
                 <p align="right">
                     <input type="hidden" id="prescription_doctor_id" value="<?php echo $doctor_info['id']; ?>">
                     <?php echo "Dr. ".$doctor_info['first_name']." ".$doctor_info['last_name']?></br>
                     <?php echo "Lic. No. ".$doctor_info['license']; ?></br>
                 </p>
                 
                 <a href="#" id="print">Print</a>
                 <input type="button" value="Save" id="save_prescription">
                </div>
                <div id="rame" style="display: none"></div>
                
                
                <script>
                    $('#save_prescription').click(function(){
                        var form_data = {
                            patient_id : $('#prescription_patient_id').val(),
                            doctor_id : $('#prescription_doctor_id').val(),
                            date : $('#prescription_date').val(),
                            medicine : $('#prescription_medicine').val(),
                            remarks : $('#prescription_remarks').val()
                        }
                        //alert("<?php echo base_url()?>admin/prescription_save");
                        $.ajax({ 
                            url : "<?php echo base_url()?>admin/prescription_save",
                            type : "POST",
                            data : form_data,
                            success : function(msg){
                                noty({type:"notification",text:msg});
                                //document.location = document.location;
                            }
                        })
                    })
                </script>
                 <script>
                     $('#print').click(function(){
                         var patient_id = $('#prescription_patient_id').val();
                         var doctor_id = $('#prescription_doctor_id').val();
                         var date = $('#prescription_date').val();
                         var medicine = $('#prescription_medicine').val();
                         var remarks = $('#prescription_remarks').val();
                         var url = "<?php echo base_url()?>admin/prescription_loader/"+patient_id+"/"+doctor_id+"/"+date+"/"+medicine+"/"+remarks;
                         //var url = this.href;
                         $('#rame').html("<iframe src='"+url+"'></iframe>");
                         window.frames[0].print();
                     })
                 </script>
                 
                
                 <?php
             }
             else
             {
                 echo "Could not retrieve the Doctors Information.";
             }
         }
         else
         {
             echo "Could not retrieve the Patients Information.";
         }
     }
     
     function prescription_loader($patient_id = null,$doctor_id = null, $month = null, $date = null, $year = null, $medicine = null, $remarks = null)
     {
         $patient_info = $this->patient_model->get_patient_by_id($patient_id);
         if(is_array($patient_info) && count($patient_info) > 0)
         {
             $doctor_info = $this->doctor_model->get_doctor_by_id($doctor_id);
             if(is_array($doctor_info) && count($doctor_info) > 0)
             {
                 $date = $month."/".$date."/".$year;
                 if($date == "")
                 {
                     $date = date("m/d/Y");
                 }
                 $remarks = str_replace("%20", " ", $remarks);
                 $medicine = str_replace("%20", " ", $medicine);
                 ?>
                <div id="patient">
                 <center><img src="<?php echo base_url()?>css/admin_css/logo.png" style=" background-color: #3CC;" title="DentView Dental Clinic" width="320" height="64" border="0" alt="DentView Dental Clinic"/></center>
                 <hr>
                 <div style="height: 100px; width: 220px; position: relative">
                 <p align = "left">
                     Location : 
                     Lower Ground Floor</br>
                     APM Shopping Mall</br>
                     North Reclamation Area, Cebu City
                 </p>
                 </div>
                 
                 <div style="height: 100px; width: 265px; position: absolute;  margin-left: 230px;margin-top: -102px; ">
                 <p align = "right">
                     Website : <?php echo base_url()?></br>
                     Email Add : dentviewdentalclinic@gmail.com</br>
                     Telephone no. : 413 - 2020
                 </p>
                 </div>
                 <hr>
                 <input type="hidden" id="prescription_date" value="<?php echo $date;?>">
                 <p align="right"> Date : <?php echo $date;?></p></br>
                 
                 <input type="hidden" id="patient_name" value="<?php echo $patient_info['first_name']." ".$patient_info['last_name']?>">
                 <input type="hidden" id="prescription_patient_id" value="<?php echo $patient_info['id']?>">
                 Name : <?php echo $patient_info['first_name']." ".$patient_info['last_name']?></br>
                 Age : <?php echo $patient_info['age']?></br>
                 Gender : <?php echo $patient_info['gender']?></br>
                 Address : <?php echo $patient_info['address']?> </br></br></br>
                 
                 <input type="hidden" id="prescription_medicine" value="<?php echo $medicine; ?>">
                 Medicine : <?php echo $medicine; ?></br>
                 <input type="hidden" id="prescription_remarks" value="<?php echo $remarks; ?>">
                 Remarks : <?php echo $remarks; ?></br>
                 
                 
                 <p align="right">
                     <input type="hidden" id="prescription_doctor_id" value="<?php echo $doctor_info['id']; ?>">
                     <?php echo "Dr. ".$doctor_info['first_name']." ".$doctor_info['last_name']?></br>
                     <?php echo "Lic. No. ".$doctor_info['license']; ?></br>
                 </p>
                 
              
                 
                </div>
         <?php
             }
             else
             {
                 echo "Could not retrieve doctor info";
             }
         }
        else
        {
            echo "Could not retrieve patient info";
        }
        
     }
     
     function admin_edit()
     {
         $admin_id = $this->input->post('id');
         $admin_info = $this->admin_model->get_admin_by_id($admin_id);
         if(is_array($admin_info) && count($admin_info) > 0)
         {
             ?>
             <div class="bg_table" style="height:245; padding:5px;">
             <h3 style="color:#066;">Admin Edit</h3>
             <input type="hidden" id="admin_id" value="<?php echo $admin_info['id']?>"></br>
             First Name : <span class="edit_fname"><input type="text" id="admin_first_name" value="<?php echo $admin_info['first_name']?>"></span></br>
             Last Name : <span class="edit_lname"><input type="text" id="admin_last_name" value="<?php echo $admin_info['last_name']?>"></span></br>
             Email Add : <span class="edit_emladd"><input type="text" id="admin_email_add" value="<?php echo $admin_info['email_add']?>"></span></br>
             Password : <span class="edit_pwd"><input type="text" id="admin_password" value="<?php echo $admin_info['password']?>"></span></br>
             <input type="button" value="Save" id="admin_button_save" class="h_btn_add">
             </div>    
             <script>
                 $('#admin_button_save').click(function(){
                     var form_data = {
                         id : $('#admin_id').val(),
                         first_name : $('#admin_first_name').val(),
                         last_name : $('#admin_last_name').val(),
                         email_add : $('#admin_email_add').val(),
                         password : $('#admin_password').val()
                     }
                     
                     $.ajax({
                         
                        url : "<?php echo base_url()?>admin/admin_edit_validate",
                        type : "POST",
                        data : form_data,
                        success : function(msg){
                            noty({type:"notification",text:msg});
                            //document.location = document.location;
                        }

                     })
                 })
             </script>
             <?php
         }
         else
         {
             echo "Could not retrieve admin ".$this->input->post('id');
         }
     }
     
     function admin_edit_validate()
     {
         $admin_id = $this->input->post('id');
         $admin_old_info = $this->admin_model->get_admin_by_id($admin_id);
         if(is_array($admin_old_info) && count($admin_old_info) > 0)
         {
             $admin_info = array(
                 'id' => $this->input->post('id'),
                 'first_name' => $this->input->post('first_name'),
                 'last_name' => $this->input->post('last_name'),
                 'email_add' => $this->input->post('email_add'),
                 'password' => $this->input->post('password')
             );
             if($admin_info['password'] == "")
             {
                 $admin_info['password'] = $admin_old_info['password'];
             }
             else
             {
                 $admin_info['password'] = $this->encrypt->sha1($admin_info['password']);
             }
             $confirm = $this->admin_model->update($admin_info);
             if($confirm)
             {
                 echo "Successfully edited";
             }
             else
             {
                 echo "Something went wrong during the update";
             }
         }
         else
         {
             echo "Could not retrieve the admin info";
         }
     }
     
     function admin_deactivate()
     {
         $admin_id = $this->input->post('id');
         $admin_info = $this->admin_model->get_admin_by_id($admin_id);
         if(is_array($admin_info) && count($admin_info) > 0)
         {
             $admin_info['status'] = "INACTIVE";
             $confirm = $this->admin_model->update($admin_info);
             if($confirm)
             {
                 echo "Successfully deactivated";
             }
             else
             {
                 echo "Something went wrong during the deactivation";
             }
         }
         else
         {
             echo "Could not retrieve the admin info";
         }
     }
     
     function admin_activate()
     {
         $admin_id = $this->input->post('id');
         $admin_info = $this->admin_model->get_admin_by_id($admin_id);
         if(is_array($admin_info) && count($admin_info) > 0)
         {
             $admin_info['status'] = "ACTIVE";
             $confirm = $this->admin_model->update($admin_info);
             if($confirm)
             {
                 echo "Successfully activated";
             }
             else
             {
                 echo "Something went wrong during the activation";
             }
         }
         else
         {
             echo "Could not retrieve the admin info";
         }
     }
     
     function prescription_save()
     {
         $patient_id = $this->input->post('patient_id');
         $doctor_id = $this->input->post('doctor_id');
         $date = $this->input->post('date');
         $remarks = $this->input->post('remarks');
         $medicine = $this->input->post('medicine');
         $prescription_info = array(
             'patient_id' => $patient_id,
             'doctor_id' => $doctor_id,
             'date' => $date,
             'medicine' => $medicine,
             'remarks' => $remarks,
             'status' => "ACTIVE"
         );
         //echo "diri";
         $confirm = $this->prescription_model->insert($prescription_info);
         
         if($confirm)
         {
             echo "Successfully saved";
         }
         else
         {
             echo "Something went wrong during the saving of the prescription";
         }
     }
     
     function prescription_edit()
     {
         $prescription_id = $this->input->post('prescription_id');
         $prescription_info = $this->prescription_model->get_prescription($prescription_id);
         if(is_array($prescription_info) && count($prescription_info)>0)
         {
             $patient_info = $this->patient_model->get_patient_by_id($prescription_info['patient_id']);
             if(!is_array($patient_info) && count($patient_info) < 1)
             {
                 $patient_info = false;
             }
             
             $doctor_info = $this->doctor_model->get_doctor_by_id($prescription_info['doctor_id']);
             if(!is_array($doctor_info) && count($doctor_info) < 1)
             {
                 $doctor_info = false;
             }
             
             $patients = $this->patient_model->get_all_active_or_inactive();
             if(!is_array($patients) && count($patients) < 1)
             {
                 $patients = false;
             }
             
             $doctors = $this->doctor_model->get_all_active_or_inactive();
             if(!is_array($doctors) && count($doctors) < 1)
             {
                 $doctors = false;
             }
             
             ?>
             <div style="border:1px solid #ccc; background:#F4F4F4; padding:10px;">
             <fieldset> <legend> Original </legend>
                 Date : <?php echo $prescription_info['date']?> </br>
                 Doctor : <?php echo $doctor_info['first_name']." ".$doctor_info['last_name']?> </br>
                 Patient : <?php echo $patient_info['first_name']." ".$patient_info['last_name']?> </br>
                 Medicine : <?php echo $prescription_info['medicine']?> </br>
                 Remarks : <?php echo $prescription_info['remarks']?> </br>
             </fieldset>
             
             <script>
                 $(function(){
                     $('#edit_date').datepicker({})
                 })
             </script>
             
             <fieldset> <legend> Edit </legend>
                 Date : <span style="margin-left:25px; padding-left:2px;"><input type="text" id="edit_date" align="right" value="<?php echo $prescription_info['date']?>"></span><br/>
                    <?php if(is_array($patients) && count($patients) > 0)
                    {

                ?>
                    Patient : <span style="margin-left:10px; padding-left:2px;"><select id="edit_patient_id">
                        <?php foreach($patients as $patient)
                            {
                                if($patient['id'] == $prescription_info['patient_id'])
                                {
                                    
                                ?>
                                    <option value="<?php echo $patient['id']?>" selected><?php echo $patient['first_name']." ".$patient['last_name']?></option>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <option value="<?php echo $patient['id']?>"><?php echo $patient['first_name']." ".$patient['last_name']?></option>
                            <?php
                                }
                            }

                    ?>
                            </select></span></br><?php
                    }
                    else
                    {
                        echo "There are no patients to be chosen";
                    }
                        ?>
                    <input type="hidden" id="prescription_id" value="<?php echo $prescription_info['id']?>">
                    
                    <div align="center" class="hide_record"><a href="#" id="edit_patient_preview">View Patient Info</a> <div id="edit_patient_info" style="display: none"></div></div></br>
                    Medicine : <textarea id="edit_medicine" cols="30" rows="5" value="<?php echo $prescription_info['medicine']?>"> </textarea></br>
                    Remarks : <textarea id="edit_remarks" cols="30" rows="5" value="<?php echo $prescription_info['remarks']?>"> </textarea> </br>
                    <?php if(is_array($doctors) && count($doctors) > 0)
                        {
                        ?>
                    Doctor : <span style="margin-left:10px; padding-left:2px;"><select id="edit_doctor_id">
                        <?php foreach($doctors as $doctor)
                        {
                            if($doctor['id'] == $prescription_info['doctor_id'])
                                {
                                    
                                ?>
                                <option value="<?php echo $doctor['id']?>" selected><?php echo $doctor['first_name']." ".$doctor['last_name']?></option>
                        <?php
                                }
                                else
                                {
                            ?>
                            <option value="<?php echo $doctor['id']?>"><?php echo $doctor['first_name']." ".$doctor['last_name']?></option>
                        <?php
                                }
                        }
                        ?>
                            </select></span></br>
                    <?php }
                    else
                    {
                        echo "There are no doctors to select";
                    }
                    ?>
                
                    <input type="button" id="edit_prescription_button" value="Save" class="pres_final_btn">
                
             </fieldset>
             </div>
             <script>
                $(window).load(function(){
                    var form_data = {
                        patient_id : $('#edit_patient_id').val()
                        //password : $('#password').val()
                    };

                    $.ajax({
                                url:"<?php echo base_url();?>admin/patient_preview",
                                type: 'POST',
                                data: form_data,
                                success: function(msg){
                                //$('#success').html(msg);
                                $('#edit_patient_info').html(msg);
                                //window.location = window.location;
                                //alert(msg);

                                }
                            })
                    return false;
                });

                $('#edit_patient_id').change(function(){
                    var form_data = {
                        patient_id : $(this).val()
                        //password : $('#password').val()
                    };

                    $.ajax({
                                url:"<?php echo base_url();?>admin/patient_preview",
                                type: 'POST',
                                data: form_data,
                                success: function(msg){
                                //$('#success').html(msg);
                                $('#edit_patient_info').html(msg);
                                //window.location = window.location;
                                //alert(msg);

                                }
                            })
                });
            </script>
            
            <script>
                $('#edit_patient_preview').toggle(
                            function(){ $(this).text('Hide Patient Info');$('#edit_patient_info').show('slow');
                            }
                            ,function(){ $(this).text('View Patient Info'); $('#edit_patient_info').hide('slow');
                            }
                        );
            </script>
            
            <script>
                $('#edit_prescription_button').click(function(){
                    var form_data = {
                        prescription_id : $('#prescription_id').val(),
                        patient_id : $('#edit_patient_id').val(),
                        doctor_id : $('#edit_doctor_id').val(),
                        date : $('#edit_date').val(),
                        medicine : $('#edit_medicine').val().trim(),
                        remarks : $('#edit_remarks').val().trim()
                        //password : $('#password').val()
                    };
                    if(form_data['date'] == "")
                    {
                        alert("Please fill out the date");
                        return false;
                    }
                    if(form_data['medicine'] == " " || form_data['medicine'] == "")
                    {
                        alert("Please fill out the medicine box");
                        return false;
                    }
                    if(form_data['remarks'] == " " || form_data['remarks'] == "")
                    {
                        alert("Please fill out the remarks");
                        return false;
                    }
                    if(form_data['remarks'] != " " && form_data['medicine'] != " ")
                    {
                        $.ajax({
                                url:"<?php echo base_url();?>admin/prescription_edit_validate",
                                type: 'POST',
                                data: form_data,
                                success: function(msg){
                                 noty({type:"notification",text:msg});   
                                }
                            })
                    }
                })
            </script>
            </div>
             <?php
         }
         else
         {
             echo "Something went wrong during the retrieving the data";
         }
     }
     
     function prescription_edit_validate()
     {
         $prescription_id = $this->input->post('prescription_id');
         $prescription_info = $this->prescription_model->get_prescription($prescription_id);
         if(is_array($prescription_info) && count($prescription_info)>0)
         {
             $new_prescription = array(
                 'id' => $prescription_info['id'],
                 'date' => $this->input->post('date'),
                 'patient_id' => $this->input->post('patient_id'),
                 'doctor_id' => $this->input->post('doctor_id'),
                 'medicine' => $this->input->post('medicine'),
                 'remarks' => $this->input->post('remarks')
             );
             
             $confirm = $this->prescription_model->update($new_prescription);
             if($confirm)
             {
                 echo "Successfully edited";
             }
             else
             {
                 echo "Something went wrong during the update";
             }
         }
         else
         {
             echo "Could not retrieve the prescription data";
         }
     }
     
     function record_print($record_id = null)
     {
         $record_info = $this->record_model->get_record($record_id);
         if(is_array($record_info) && count($record_info) > 0)
         {
             $record = $record_info;
             
         ?>
            Date : <?php echo $record['date']?> </br>
            Occlusion : <?php echo $record['occlusion']?> </br>
            Periodical Condition : <?php echo $record['periodical_condition']?> </br>
            Oral Hygiene : <?php echo $record['oral_hygiene']?> </br>
            Denture Upper Since : <?php echo $record['denture_upper_since']?> </br>
            Denture Lower Since : <?php echo $record['denture_lower_since']?> </br>
            Abnormalities : <?php echo $record['abnormalities']?> </br>
            General Condition : <?php echo $record['general_condition']?> </br>
            Physician : <?php echo $record['physician']?> </br>
            Nature of Treatment : <?php echo $record['nature_of_treatment']?> </br>
            Allergies : <?php echo $record['allergies']?> </br>
            Previous history of Bleeding : <?php echo $record['previous_history_of_bleeding']?> </br>
            Chronic Ailments : <?php echo $record['chronic_ailments']?> </br>
            Blood Pressure : <?php echo $record['blood_pressure']?> </br>
            Drugs being Taken : <?php echo $record['drugs_being_taken']?> </br>
                <?php    
         }
         else
         {
             echo "Could not retrieve record";
         }
     }
     
     
     function system_save()
     {
         
        $date = $this->input->post('date');
        $time_in = $this->input->post('time_in');
        $time_out = $this->input->post('time_out');
        if(isset($this->session->userdata['admin_info']['id']))
        {
            $doctor_id = 0;
        }
        if(isset($this->session->userdata['secretary_info']['id']))
        {
            $doctor_id = $this->session->userdata['secretary_info']['under_of'];
        }
        
        $whole_day = $this->input->post('whole_day');
        if($whole_day == "1")
        {
           $whole_day = true; 
        }
        else
        {
            $whole_day = false;
        }
        $system_info = array(
            'date' => $date,
            'time_in' => $time_in.":00:00",
            'time_out' => $time_out.":00:00",
            'doctor_id' => $doctor_id,
            'whole_day' => $whole_day
        );
        $confirm = $this->system_model->insert($system_info);
        if($confirm)
        {
            echo "Successfully saved";
        }
        else
        {
            echo "Something went wrong during the saving";
        }

     }
     
     function system_edit()
     {
         $system_id = $this->input->post('id');
         $system_info = $this->system_model->get_system_time($system_id);
         if(is_array($system_info) && count($system_info) > 0)
         {
             $time_in = "";
             $time_out = "";
             if(is_numeric($system_info['time_in'][1]))
             {
                 $time_in = $system_info['time_in'][0].$system_info['time_in'][1];
             }
             else
             {
                 $time_in = $system_info['time_in'][0];
             }
             
             if(is_numeric($system_info['time_out'][1]))
             {
                 $time_out = $system_info['time_out'][0].$system_info['time_out'][1];
             }
             else
             {
                 $time_out = $system_info['time_out'][0];
             }
             
             ?>
            <script>
                $(function(){
                    $('#date_edit').datepicker({});
                })
            </script>
            
                  <input type="hidden" id="system_id" value="<?php echo $system_info['id'] ?>">
                  
                  Date : <input type="text" id="date_edit" value="<?php echo $system_info['date']?>">
                    <select id="time_in_edit">
        <?php

                                        for($i=6;$i<24;$i++)
                                        {
                                        ?>

            <option value="<?php echo $i?>" <?php if($time_in == $i){ echo "selected"; } ?>>

                                        <?php


                                        if($i<=11)
                                        {
                                            echo $i.":00 AM"; 

                                        }
                                        elseif($i==12)
                                        {
                                            echo $i.':00 PM';
                                        }
                                        else 
                                        {
                                             echo ($i-12).':00 PM'; 
                                            $afternoon=true;      
                                        }

                                        ?> 
                </option>
                            <?php
                                    }
        ?>
            </select>

        <select id="time_out_edit">
        <?php

                                        for($i=8;$i<20;$i++)
                                        {
                                        ?>

            <option value="<?php echo $i?>" <?php if($time_out == $i){ echo "selected"; } ?>>

                                        <?php


                                        if($i<=11)
                                        {
                                            echo $i.":00 AM"; 

                                        }
                                        elseif($i==12)
                                        {
                                            echo $i.':00 PM';
                                        }
                                        else 
                                        {
                                             echo ($i-12).':00 PM'; 
                                            $afternoon=true;      
                                        }

                                        ?> 
                </option>
                            <?php
                                    }
        ?>
            </select>
        <input type="checkbox" id="whole_day_edit" name="vehicle" value="0">Whole Day<br>
        <input type="button" value="Save" id="button_time_save_edit">

        <script>
            $('#button_time_save_edit').click(function(){
                //alert($('#whole_day_edit').val());
                var form_data = {
                    id : $('#system_id').val(),
                    time_in : $('#time_in_edit').val(),
                    time_out : $('#time_out_edit').val(),
                    date : $('#date_edit').val(),
                    whole_day : $('#whole_day_edit').val()
                }

                $.ajax({
                    url : "<?php echo base_url()?>admin/system_edit_validate",
                    type : "POST",
                    data : form_data,
                    success : function(msg){     
                        noty({type:'notification',text:msg});
                    }
                })
            })
        </script>
        
        <script>
            $('input:checkbox').click(function(){
                //alert("asffhgjh");
                if(document.getElementById("time_in_edit").disabled == false)
                {
                    document.getElementById("time_in_edit").disabled = true;
                     document.getElementById("time_out_edit").disabled = true;
                     $(this).val("1");
                     //$('#time_in').val("");
                }
                else
                {
                    document.getElementById("time_in_edit").disabled = false;
                     document.getElementById("time_out_edit").disabled = false;
                     $(this).val("0");
                }
            })
        </script>
            <?php
         }
     }
     
     function system_edit_validate()
     {
         $system_id = $this->input->post('id');
         $system_info = $this->system_model->get_system_time($system_id);
         $whole_day = $this->input->post('whole_day');
         
        if(isset($this->session->userdata['secretary_info']['id']))
        {
            $doctor_id = $this->session->userdata['secretary_info']['under_of'];
        }
        if(isset($this->session->userdata['admin_info']['id']))
        {
            $doctor_id = 0;
        }
         if($whole_day == "1")
         {
            $whole_day = true; 
         }
         else
         {
             $whole_day = false;
         }
         if(is_array($system_info) && count($system_info) > 0)
         {
             $date = $this->input->post('date');
             if($date == "")
             {
                 $date = $system_info['date'];
             }
             else
             {
                $date = $this->input->post('date');
             }
             $new_system_info = array(
                 'id' => $system_info['id'],
                 'time_in' => $this->input->post('time_in').":00:00",
                 'time_out' => $this->input->post('time_out').":00:00",
                 'whole_day' => $whole_day,
                 'date' => $date,
                 'status' => "ACTIVE"
             );
             
             $confirm = $this->system_model->update($new_system_info);
             if($confirm)
             {
                 echo "Successfully edited";
             }
             else
             {
                 echo "Something went wrong during the editing";
             }
         }
         else
         {
             echo "Could not retrieve the system of time data";
         }
     }
     
     function tooth_child_edit()
     {
         $tooth_child_id = $this->input->post('id');
         $tooth_child_info = $this->tooth_child_model->get_tooth_child_by_id($tooth_child_id);
         if(is_array($tooth_child_info) && count($tooth_child_info) > 0)
         {
             $tooth_child_info_new = $this->input->post();
             if($tooth_child_info_new['date'] == "")
             {
                 $tooth_child_info_new['date'] = $tooth_child_info['date'];
             }
             $confirm = $this->tooth_child_model->update($tooth_child_info_new);
             if($confirm)
             {
                 echo "Successfully edited";
             }
             else
             {
                 echo "Something went wrong during the editing";
             }
         }
         else
         {
             echo "Could not retrieve the data";
         }
     }
     
     function customer_care_send()
     {
         $customer_care_info = $this->customer_care_model->get_customer_care_by_id($this->input->post('id'));
         if(is_array($customer_care_info) && count($customer_care_info) > 0)
         {
             $patient_info = $this->patient_model->get_patient_by_id($customer_care_info['patient_id']);
             if(is_array($patient_info) && count($patient_info) > 0)
             {
                 $customer_care_info['patient_info'] = $patient_info;
             ?>
                    <input type="hidden" id="customer_care_id" value="<?php echo $customer_care_info['id']?>">
                    
                    Patient : <?php echo $customer_care_info['patient_info']['first_name']." ".$customer_care_info['patient_info']['first_name']?> </br>
                    Query : <?php echo $customer_care_info['query']?> </br>
                    About : <?php echo $customer_care_info['about']?> </br>
                    Reply : <textarea cols="30" rows="5" id="reply"></textarea></br>
                    <input type="button" id="button_reply_customer_care" value="Reply">
                    
                    <script>
                        $('#button_reply_customer_care').click(function(){
                            var form_data = {
                                id : $('#customer_care_id').val(),
                                reply : $('#reply').val()
                            }
                            
                            $.ajax({
                                url : "<?php echo base_url()?>admin/customer_care_send_validate",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:"notification",text:msg});
                                    //window.opener.location.reload();
                                }
                            })
                            
                            $.ajax({
                                url : "<?php echo base_url()?>admin/customer_care_update",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    noty({type:"notification",text:msg});
                                    
                                }
                            })
                        })
                    </script>
             <?php
             }
             else
             {
                 echo "Was not able to retrieve patient info";
             }
         }
         else
         {
             echo "Was not able to retrieve necessary info";
         }
     }
     
     function customer_care_send_validate()
     {
         $customer_care_info = $this->customer_care_model->get_customer_care_by_id($this->input->post('id'));
         if(is_array($customer_care_info) && count($customer_care_info) > 0)
         {
             $patient_info = $this->patient_model->get_patient_by_id($customer_care_info['patient_id']);
             if(is_array($patient_info) && count($patient_info) > 0)
             {
                 $email_add = $patient_info['email_add'];
                 $subject = "Query to Dentview Dental Clinic";
                 $message = $this->input->post('reply');

                 $this->load->library('email');
                        //for configuration of email head to ci_day3/application/config/email.php
                        //echo $doctor_info['email_add'];
                $this->email->from('DentViewDentalClinic@gmail.com', 'Administrator');
                $this->email->to($email_add);
                $this->email->subject($subject);
                $this->email->message($message);

                if($this->email->send())
                {
                    echo "Email sent to patient";
                }
                else
                {
                    echo "Was not able to send the email. It might be caused by the slow internet connection";
                }
                 
             }
             else
             {
                 echo "Was not able to retrieve patient info";
             }
         }
         else
         {
             echo "Was not able to retrieve necessary info";
         }
     }
     
     function customer_care_update()
     {
         //echo "alalalal";
         $message = $this->input->post('reply');
         $customer_care_id = $this->input->post('id');
         $time = now();  
         $timezone = 'UM4';  
         $daylight_saving = TRUE; // or FALSE  
         $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));  
         $time = $local_time;
         echo $time;
         $date = date("Y-m-d");
         
         $customer_care_info = $this->customer_care_model->get_customer_care_by_id($customer_care_id);
         if(is_array($customer_care_info) && count($customer_care_info) > 0)
         {
             $customer_care_info_reply = array(
                 'id' => $customer_care_info['id'],
                 'patient_id' => $customer_care_info['patient_id'],
                 'date' => $customer_care_info['date'],
                 'time' => $customer_care_info['time'],
                 'about' => $customer_care_info['about'],
                 'query' => $customer_care_info['query'],
                 'date_reply' => $date,
                 'time_reply' => $time,
                 'reply' => $message,
                 'status' => "INACTIVE"
                 );
             $confirm = $this->customer_care_model->update($customer_care_info_reply);
       
         }
         
            if($confirm)
                echo "Successfully update";
            else
                echo "Something went wrong during the updating";
     }
     
     function system_date_check()
     {
         $time_start = $this->input->post('time_in');
         $time_end = $this->input->post('time_out');
         $date = date("Y-m-d",strtotime($this->input->post('date')));
         
         $today = date('m/d/Y',strtotime($date));
         if(isset($this->session->userdata['admin_info']['id']))
         {
            $system_infos = $this->system_model->get_date_active_or_inactive($today);
         }
         if(isset($this->session->userdata['secretary_info']['id']))
         {
             $system_infos = $this->system_model->get_date_active_or_inactive_by_doctor($today, $this->session->userdata['secretary_info']['under_of']);
         
             //print_r($system_infos);
         }
         
         
         //$data['system_info'] = $system_infos;
         if(is_array($system_infos) && count($system_infos) > 0)
        {
             foreach($system_infos as $system_info)
             {
             
                 if($system_info['whole_day'] == true)
                {
                    ?>
                    Cancellation is whole day now. 
                    <?php
                    break;
                }
                
                    if($system_info['whole_day'] == false)
                    {
                        ?>
                        <div id="" style=" border-color: #174867">
                        <?php
                        
                            $doctor_info = $this->doctor_model->get_doctor_by_id($system_info['doctor_id']);
                            if(is_array($doctor_info) && count($doctor_info) > 0)
                            {
                            ?>
                                Dr. <?php echo $doctor_info['first_name']." ".$doctor_info['last_name']?> has a schedule for today. <br/>
                                Time is from
                            <?php
                            }
                        
                    ?>
                    
                    
                     <?php 
                     if(is_numeric($system_info['time_in'][1]))
                     {
                         $i = $system_info['time_in'][0].$system_info['time_in'][1];
                     }
                     else
                     {
                         $i = $system_info['time_in'][0];
                     }

                         if($i<=11)
                        {
                            echo $i.":00 AM"; 

                        }
                        elseif($i==12)
                        {
                            echo $i.':00 PM';
                        }
                        else 
                        {
                             echo ($i-12).':00 PM'; 
                            $afternoon=true;      
                        }

                        echo " to ";

                        if(is_numeric($system_info['time_out'][1]))
                         {
                             $i = $system_info['time_out'][0].$system_info['time_out'][1];
                         }
                         else
                         {
                             $i = $system_info['time_out'][0];
                         }

                         //echo $i;

                         if($i<=11)
                        {
                            echo $i.":00 AM"; 

                        }
                        elseif($i==12)
                        {
                            echo $i.':00 PM';
                        }
                        else 
                        {
                             echo ($i-12).':00 PM'; 
                            $afternoon=true;      
                        }

                    ?> &nbsp; 
                    </div>
                        <?php
                }
                ?>
                    <a href="#div_time_change"  class="fancybox_change_time" name="<?php echo $system_info['id']?>">Change Time</a> </br>
                    <?php
            }
        }
         $whole_day = $this->input->post('whole_day');
         if($whole_day == "1")
         {
             $time_start = "6";
             $time_end = "20";
         }
         
         $reservation_infos = $this->reservation_model->get_reserved_by_date_and_time($date,$time_start,$time_end);
         
         foreach($reservation_infos as $reservation_info)
         {
    //print_r($reservation_info);
         
//         for($i = $time_start; $i <= $time_end; $i++)
//         {
             //$reservation_info = $this->reservation_model->get_reserved_by_date_and_time(date("Y-m-d",strtotime($this->input->post('date'))),$i.":00:00");
             if(is_array($reservation_info) && count($reservation_info) > 0)
             {
                 ?>
                   
                   
                   <div class="date">
                   These are the list of reservations that are in conflict with the cancellation of schedules. 
                   
                       <?php
                $patient_info = $this->patient_model->get_patient_by_id($reservation_info['patient_id']);
                 $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                 if(is_array($doctor_info) && is_array($patient_info) && count($patient_info) > 0 && count($doctor_info) > 0)
                 {
                 ?>
                    
                    <div style=" border: 1px solid #ccc; width: 205px; float: left; padding: 5px; background:#FBFBFB;  margin:20px;">
                    Patient Name : <?php echo $patient_info['first_name']." ".$patient_info['last_name']?> </br>
                    Doctor Assigned : <?php echo $doctor_info['first_name']." ".$doctor_info['last_name']?> </br>
                    Time : <?php 
                    $system_info['time_in'] = $reservation_info['time'];
                        if(is_numeric($system_info['time_in'][1]))
                         {
                             $i = $system_info['time_in'][0].$system_info['time_in'][1];
                         }
                         else
                         {
                             $i = $system_info['time_in'][0];
                        }

                             if($i<=11)
                            {
                                echo $i.":00 AM"; 

                            }
                            elseif($i==12)
                            {
                                echo $i.':00 PM';
                            }
                            else 
                            {
                                 echo ($i-12).':00 PM'; 
                                $afternoon=true;      
                            }
                            
                            if($reservation_info['hour'] > 1)
                            {
                                
                                echo " to ";
                                $system_info['time_out'] = $i + $reservation_info['hour'].":00:00";
                                
                                if(is_numeric($system_info['time_out'][1]))
                                 {
                                     $i = $system_info['time_out'][0].$system_info['time_out'][1];
                                 }
                                 else
                                 {
                                     $i = $system_info['time_out'][0];
                                 }

                                 //echo $i;

                                 if($i<=11)
                                {
                                    echo $i.":00 AM"; 

                                }
                                elseif($i==12)
                                {
                                    echo $i.':00 PM';
                                }
                                else 
                                {
                                     echo ($i-12).':00 PM'; 
                                    $afternoon=true;      
                                }
                            }
                            ?></br>
                    Email : <a href="#email_patient" class="fancybox_send_email" name="<?php echo $patient_info['email_add']?>"><?php echo $patient_info['email_add']?></a>
                    <a href="#div_reschedule" class="fancybox_resched ala" name="<?php echo $reservation_info['id']?>">Reschedule</a>
                    <a href="#div_cancel_reservation" class="fancybox_cancellation ala" name="<?php echo $reservation_info['id']?>">Cancel Reservation</a>
                    
                    </div>
                    </div>
                    
                    <?php
        
                        }
                        
             }
             
             
             
         
         else
         {
             echo "There are no datas to be gathered";
         }
         
         
     }
     if($reservation_infos != null)
     {
     ?>         </br>
     <div style="float:left">
                    <input type="hidden" id="date_cancel_all" value="<?php echo $date?>">
                    
              <a href="#div_cancel_validate" id="cancel_all" class="fancybox add_patient" >Cancel All</a>
              </div>
               <?php }
     ?>
              
              <div style="display:none; width: 200; height: 100;" id="div_cancel_validate">
                  <center>
                  Do you really wanna cancel all the reservations?</br>
                  <a href="#" id="confirmed">Yes</a>&nbsp;<a href="" onclick="$.fancybox.close();">No</a>
                  </center>
              </div>
              <script>
                  $('#confirmed').click(function(){
                      var form_data = {
                           date : $('#date_cancel_all').val()
                        }
                        $.ajax({
                            url : "<?php echo base_url()?>admin/reservation_cancel_all",
                            type : "POST",
                            data : form_data,
                            success : function(msg){
                                //$('#patient_transaction').html(msg);
                                noty({type:"notification",text:msg});
                            }
                        })
                    })
              </script>
             <?php
     }  
     function reservation_cancel()
     {
         $reservation_id = $this->input->post('reservation_id');
        $reservation_info = $this->reservation_model->get_reservation($reservation_id);
        if(is_array($reservation_info) && count($reservation_info) > 0)
        {
            $reservation_info['status'] = "INACTIVE";
            $confirm = $this->reservation_model->update($reservation_info);
            if($confirm)
            {
                echo "Successfully cancelled your reservation";
            }
            else
            {
                echo "Something went wrong during the cancellation of your reservation";
            }
        }
        else
        {
            echo "Something went wrong. Please do try again";
        }
     }
     
     function reservation_cancel_all()
     {
         $date = date("Y-m-d",strtotime($this->input->post('date')));
         
             $time_start = "6";
             $time_end = "20";
         
         $i = 0;
         $reservation_infos = $this->reservation_model->get_reserved_by_date_and_time($date,$time_start,$time_end);
         foreach($reservation_infos as $reservation_info)
         {
             if(is_array($reservation_info) && count($reservation_info) > 0)
             {
                 $reservation_info['status'] = "INACTIVE";
                 $confirm = $this->reservation_model->update($reservation_info);
                 if($confirm)
                 {
                     $i++;
                 }
                 
             }
         }
         
         if($i == count($reservation_infos))
         {
             echo "Successfully cancelled all";
         }
         else
         {
             echo "Was unable to cancel all the reservation";
         }
     }
     function reservation_inactive_look_month_year()
     {
         $year_month = date("Y-m",strtotime($this->input->post('year_month')));
         //echo "alllllllldlgllhllhdlhlfhl".$year_month;
         $reservation_info = $this->reservation_model->get_inactive_reservation_by_month_year($year_month);
         if(is_array($reservation_info) && count($reservation_info) > 0)
         {
             $reservation_inactive_info = $reservation_info;
             $datestring = "%m %Y";
             $time = $reservation_inactive_info[0]['date'][7].$reservation_inactive_info[0]['date'][8];
             
             $month = mdate($datestring, $time);
            $time_start = $month[0].$month[1];
            $time_str = strtotime($year_month);
            $month_now = date("F Y", $time_str);
        
             ?>
              <legend> Inactive Reservation for <?php echo $month_now?></legend>
        <?php
        $i=0;
        //$first = $reservation_inactive_info[0]['date'][8].$reservation_inactive_info[0]['date'][9];
        //$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
        
        //echo $first;
        foreach($reservation_inactive_info as $reservation_inactive)
        {
            $reservation_inactive['doctor_info'] = $this->doctor_model->get_doctor_by_id($reservation_inactive['doctor_id']);
            $reservation_inactive['patient_info'] = $this->patient_model->get_patient_by_id($reservation_inactive['patient_id']);
                          
            
            ?>
            <div id="admin_resrv" style=" border:1px solid #F90; background-color: <?php if($i%2 == 0) echo '#FF9'; else echo '#FF9';?>">
            <div class="admin_res_dctr">Doctor : <?php echo $reservation_inactive['doctor_info']['first_name']." ".$reservation_inactive['doctor_info']['last_name']?></div>
            <div class="admin_res_p">Patient : <?php echo $reservation_inactive['patient_info']['first_name']." ".$reservation_inactive['patient_info']['last_name']?></div> 
            <div class="admin_res_d">Date : <?php echo date_format(date_create($reservation_inactive['date']),"F d, Y");?></div>
            <div class="admin_res_t">Time : <?php 
                                                //$reservation_inactive['time'];
                                                $time = $reservation_inactive['time'][0].$reservation_inactive['time'][1];
                            if($time<=11)
                            {
                                echo $time.":00 AM";
                            }
                            elseif($time == 12)
                            {
                                echo $time.":00 PM";
                            }
                            else
                            {
                                echo ($time-12).":00 PM";
                            }
                                            ?></div>
            </div>
            <br/>
            </br>
        <?php
        }

         }
         else
         {
             echo false;
         }
     }
     
     function reservation_active_look_month_year()
     {
         $year_month = date("Y-m",  strtotime($this->input->post('year_month')));
         //echo "alllllllldlgllhllhdlhlfhl".$year_month;
         $datestring = "%m %Y";
         
            $time_str = strtotime($year_month);
            $month_now = date("F Y", $time_str);
             //$time = $reservation_active_info[0]['date'][7].$reservation_active_info[0]['date'][8];
             
         $reservation_info = $this->reservation_model->get_active_reservation_by_month_year($year_month);
         if(is_array($reservation_info) && count($reservation_info) > 0)
         {
             $reservation_active_info = $reservation_info;
             $datestring = "%m %Y";
             $time = $reservation_active_info[0]['date'][7].$reservation_active_info[0]['date'][8];
             
             $month = mdate($datestring, $time);
            $time_start = $month[0].$month[1];
            $time_str = strtotime($year_month);
            $month_now = date("F Y", $time_str);
        ?>
         <legend> Active Reservation for <?php echo $month_now?></legend>
        <?php
        $i=0;
        
        if(count($reservation_active_info) > 0)
        {
            foreach($reservation_active_info as $reservation_active)
            {
                $reservation_active['doctor_info'] = $this->doctor_model->get_doctor_by_id($reservation_active['doctor_id']);
            $reservation_active['patient_info'] = $this->patient_model->get_patient_by_id($reservation_active['patient_id']);
            
                ?>
                <div id="admin_resrv" style=" border:1px solid #0F0; background-color: <?php if($i%2 == 0) {echo '#CFC';} else {echo '#CFF';}?> " >
                <div class="admin_res_dctr">Doctor : <?php echo $reservation_active['doctor_info']['first_name']." ".$reservation_active['doctor_info']['last_name']?></div>
                <div class="admin_res_p">Patient : <?php echo $reservation_active['patient_info']['first_name']." ".$reservation_active['patient_info']['last_name']?></div>
                <div class="admin_res_d">Date : <?php echo date_format(date_create($reservation_active['date']),"F d, Y")?></div>
                <div class="admin_res_t">Time : <?php 
                $time = $reservation_active['time'][0].$reservation_active['time'][1];
                            if($time<=11)
                            {
                                echo $time.":00 AM";
                            }
                            elseif($time == 12)
                            {
                                echo $time.":00 PM";
                            }
                            else
                            {
                                echo ($time-12).":00 PM";
                            }
                                                    ?>
                </div>&nbsp; <a href="#div_reschedule" class="fancybox" id="<?php echo $reservation_active['id']?>">Reschedule</a>
                <input type="hidden" id="input_reservation_id" value="">
                </div>
                
                </br>
            <?php
                $i++;
            }
            
        
        }
        
    }
    else
    {
        ?>
                <legend> Active Reservation for <?php echo $month_now?></legend>
                <?php
    }
     }
     
     function faq_add()
     {
         $date = $this->input->post('date');
         $question  = $this->input->post('question');
         $answer = $this->input->post('answer');
         
         $faq_info = array(
             'date' => $date,
             'question' => $question,
             'answer' => $answer,
             'status' => "ACTIVE"
         );
         
         $confirm = $this->faq_model->insert($faq_info);
         if($confirm)
         {
             echo "Successfully added a faq";
         }
         else
         {
             echo "Something went wrong during the insertion of faq. Please try again";
         }
     }
     
     function faq_edit()
     {
         $faq_id = $this->input->post('faq_id');
         $faq_info = $this->faq_model->get_faq_by_id($faq_id);
         if(is_array($faq_info) && count($faq_info) > 0)
         {
             ?>
            <script>
                $(function() {
                $("#date_edit").datepicker({});
              });
            </script>
                <input type="hidden" id="faq_id" value="<?php echo $faq_info['id']?>">
            <div class="bg_table" style="height:290px;">
             Date : <input type="text" id="date_edit" value="<?php echo $faq_info['date']?>"></br>
            Question : <br /><textarea id="question_edit" cols="34" rows="5" value=""><?php echo $faq_info['question']?></textarea><br/>
            Answer : <br /><textarea id="answer_edit" cols="34" rows="5" value=""><?php echo $faq_info['answer']?></textarea><br/>
            <input type="button" id="button_edit_faq" value="Edit" class="doc_view_btn">
            </div>
            
            <script>
            $('#button_edit_faq').click(function(){
                var form_data = {
                    id : $('#faq_id').val(),
                    date : $('#date_edit').val(),
                    question : $('#question_edit').val(),
                    answer : $('#answer_edit').val()
                }
                if(form_data['date'] == "")
                {
                    alert("Please enter a date");
                }
                if(form_data['question'] == "")
                {
                    alert("Please enter a question");
                }
                if(form_data['answer'] == "")
                {
                    alert("Please enter an answer");
                }
                else
                    {
                $.ajax({
                    url : "<?php echo base_url()?>admin/faq_edit_validate",
                    type : "POST",
                    data : form_data,
                    success : function(msg){
                        noty({type:"notification",text:msg})
                        window.setTimeout(function(){window.location = window.location}, 2000);
                    }
                })
                }
            })
        </script>

             <?php
         }
         else
         {
             echo "Was not able to get faq info";
         }
     }
     
     function faq_edit_validate()
     {
         $id = $this->input->post('id');
         $date = $this->input->post('date');
         $question  = $this->input->post('question');
         $answer = $this->input->post('answer');
         
         $faq_info = array(
             'id' => $id,
             'date' => $date,
             'question' => $question,
             'answer' => $answer,
             'status' => "ACTIVE"
         );
         
         $confirm = $this->faq_model->update($faq_info);
         if($confirm)
         {
             echo "Successfully edit a faq";
         }
         else
         {
             echo "Something went wrong during the editing of faq. Please try again";
         }
     }
     
     function faq_deactivate()
     {
         $faq_id = $this->input->post('faq_id');
         $faq_info = $this->faq_model->get_faq_by_id($faq_id);
         if(is_array($faq_info) && count($faq_info) > 0)
         {
             $faq_info['status'] = "INACTIVE";
             $confirm = $this->faq_model->update($faq_info);
            if($confirm)
            {
                echo "Successfully edit a faq";
            }
            else
            {
                echo "Something went wrong during the editing of faq. Please try again";
            }
         }
         else
         {
             echo "Was not able to retrieve the faq data";
         }
     }
     
     function faq_activate()
     {
         $faq_id = $this->input->post('faq_id');
         $faq_info = $this->faq_model->get_faq_by_id($faq_id);
         if(is_array($faq_info) && count($faq_info) > 0)
         {
             $faq_info['status'] = "INACTIVE";
             $confirm = $this->faq_model->update($faq_info);
            if($confirm)
            {
                echo "Successfully edit a faq";
            }
            else
            {
                echo "Something went wrong during the editing of faq. Please try again";
            }
         }
         else
         {
             echo "Was not able to retrieve the faq data";
         }
     }
     
     function secretary_add()
     {
         $data = $this->input->post();
         
         $confirm = $this->secretary_model->insert($data);
         if($confirm)
         {
             echo "Successfully added ".$data['first_name']." ".$data['last_name']." as a secretary";
         }
         else
         {
             echo "Something went wrong during the adding of secretary";
         }
     }
     
     function patient_search()
     {
         //echo "alalalalah!";
         $last_name = $this->input->post('last_name');
         if($last_name == "all")
         {
             $result = $this->patient_model->get_all_active();
         }
         else
         {
            $result = $this->patient_model->get_active_patients_by_last_name($last_name);
         }
         if(is_array($result) && count($result) > 0)
         {
             foreach($result as $patient_info)
             {
                 $photo_info  =$this->photo_model->get_photo('patient',$patient_info['id']);
                 $patient['patient_info'] = $patient_info;
                 $patient['photo_info'] = $photo_info;
                 ?>
                 <ul style="padding-left :-px">
            
            <center><img style=" width: 100px; height: 100px; border: 1px solid #ccc; margin-top:8px;" src="<?php echo base_url().$patient['photo_info']['source']?>"/></center>
                <div class="admin_name">Name : <?php echo $patient['patient_info']['first_name']." ".$patient['patient_info']['last_name']?></div>
                <li><a class="fancybox" href="#patient_for_edit" id="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/info.png" title="View All Info"></a></li>
                <li><a href="#patient_record" class="fancybox_view_patient_record" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/history.png" title="View Patient History"></a></li>
                <li><a href="#patient_record" class="fancybox_view_patient_tooth_record" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/tooth.png" title="View Patient Tooth History"></a></li>
                <li><a href="#patient_transaction" class="fancybox_view_patient_transaction" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/icon/transactions.png" title="View Patient Transaction History"></a></li>
                <li><a class="edit_patient_deactivate" name="<?php echo $patient['patient_info']['id']?>"><img src="<?php echo base_url()?>/images/x.png" title="Deactivate"></a></li>
                
        </ul>
                 <?php
             }
         }
     }
 }
?>
