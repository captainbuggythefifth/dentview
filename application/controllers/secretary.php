<?php

if( !defined('BASEPATH') ) exit ('No direct script access allowed');

class secretary extends CI_Controller{
    
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
      
      function home()
      {
          $this->load->view('admin_header');
          $this->load->view('secretary_home_view');
      }
      function log_in_validate()
      {
        
         // echo "alalalalalah!";
          $secretary = $this->secretary_model->get_secretary_by_email($this->input->post('email_add'));
          if($secretary)
          {
              $confirm = $this->secretary_model->confirm_email_and_password($secretary['email_add'],$this->input->post('password'));
              if($confirm)
              {
                  $this->session->set_userdata('secretary_info',$secretary);
                  echo "Successfully logged in";
                  
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
      function secret($function = null)
      {
          if($function == "patient")
          {
                if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
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
              $this->load->view('secretary_home_view');
              $this->load->view('admin_manage_patient',$complete_info);
              $this->load->view('forms');
          }
          }
          if($function == "admin")
          {
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
                }
                else
                {
              $admins = $this->admin_model->get_all();
              $admin = array('admins' => $admins);
              $this->load->view('admin_header');
              $this->load->view('secretary_home_view');
              $this->load->view('admin_view_all',$admin);
                }
              //$this->load->view('forms');
          }
          if($function == 'doctor')
          {
          
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
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
                  $this->load->view('secretary_home_view');
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
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
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
                  $this->load->view('secretary_home_view');
                  $this->load->view('admin_manage_service',$service);
              
          }
          }
          elseif($function == "reservation")
          {
            if(!isset($this->session->userdata['secretary_info']['id']))
            {
              redirect(base_url().'secretary');
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
                  $reservation_active = $this->reservation_model->get_all_active_from_doctor_arranged_by_desc($this->session->userdata['secretary_info']['under_of']);
                  
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
                  $reservation_inactive = $this->reservation_model->get_all_inactive_from_doctor_arranged_by_desc($this->session->userdata['secretary_info']['under_of']);
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
                  $this->load->view('secretary_home_view');
                  $this->load->view('admin_manage_reservation',$reservation);
              }
          }
          if($function == "prescription")
          {
              
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
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
                      if($pres['doctor_id'] == $this->session->userdata['secretary_info']['under_of'])
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
              $this->load->view('secretary_home_view');
              $this->load->view('admin_manage_prescription',$data);
          }
          }
          if($function == "candidates")
          {
              
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
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
                      if($cand['doctor_id'] == $this->session->userdata['secretary_info']['under_of'])
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
                    $this->load->view('secretary_home_view');
                  $this->load->view('admin_manage_candidate',$data);
              }
              else
              {
                  $data['candidates'] = false;
                  $this->load->view('admin_header');
                    $this->load->view('secretary_home_view');
                  $this->load->view('admin_manage_candidate',$data);
              }
          }
          }
          if($function == "system_time")
          {
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
                }
                else
                {
                        $today = date('m/d/Y');
                        $system_infos = $this->system_model->get_date_active_or_inactive($today);

                        $data['system_info'] = $system_infos;
                        $this->load->view('admin_header');
                        $this->load->view('secretary_home_view');
                        $this->load->view('admin_manage_system',$data);
                 }
          }
          
          if($function == "customer_care")
          {
              if(!isset($this->session->userdata['secretary_info']['id']))
                {
                  redirect(base_url().'secretary');
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
                    $this->load->view('secretary_home_view');
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
              $this->load->view('secretary_home_view');
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
              $this->load->view('secretary_home_view');
              $this->load->view('admin_manage_secretary',$data);
          }
          
          if($function == "profile_edit")
          {
              $this->load->view('admin_header');
              $this->load->view('secretary_home_view');
              $this->load->view('secretary_manage_profile');
          }
          elseif($function == null)
          {
                $this->load->view('admin_header');
                $this->load->view('secretary_home_view');
          }

      }
      
      function log_out()
      {
          if(isset($this->session->userdata['secretary_info']['id']))
          {
             $this->session->unset_userdata("secretary_info");
             redirect(base_url().'secretary');
          }
          //
      }
      
      function secretary_edit()
      {
          $secretary_info = array(
              'id' => $this->session->userdata['secretary_info']['id'],
              'first_name' => $this->input->post('first_name'),
              'last_name' => $this->input->post('last_name'),
              'email_add' => $this->input->post('email_add'),
              'under_of' => $this->session->userdata['secretary_info']['under_of'],
              'password' => $this->encrypt->sha1($this->input->post('password')),
          );
          
          if($secretary_info['password'] == "")
          {
              $secretary_info['password'] = $this->session->userdata['secretary_info']['password'];
          }
          
          
          $confirm = $this->secretary_model->update($secretary_info);
          if($confirm)
          {
              $secretary_info = $this->secretary_model->get_secretary_by_id($this->session->userdata['secretary_info']['id']);
              $this->session->set_userdata('secretary_info',$secretary_info);
              echo "Successfully edited your profile";
          }
          else
          {
              echo "Was not able to edit your profile";
          }
      }
      
      function system_save()
      {
          
            
            $date = $this->input->post('date');
            $time_in = $this->input->post('time_in');
            $time_out = $this->input->post('time_out');
            $doctor_id = $this->session->userdata['secretary_info']['under_of'];
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
    }
?>
