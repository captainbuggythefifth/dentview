<?php
/*
 *Filename:jobseekers.php
 *Projectname:Bizjobfinder.com
 *Date Created: April 02, 2012 @5:20pm
 *Created by: Mario T. Silvano a.k.a strikermode
*/
if( !defined('BASEPATH') ) exit ('No direct script access allowed');

class patient extends CI_Controller{

    private $all_photos;
    //private $all_services;
    private $service_with_photos;
    private $patient;
    function __construct()
    {
        parent::__construct();

        $this->load->helper('date');
        $this->load->library('encrypt');
        //$this->load->helper('captcha');
        $this->load->model('patient_model');

        $this->load->library('grocery_CRUD');
        $this->load->helper('url');

        $this->load->model('doctor_model');
        $this->load->model('reservation_model');
        $this->load->model('service_model');
        $this->load->model('photo_model');
        $this->load->model('expertise_model');
        
        $this->load->model('tooth_child_model');
        $this->load->model('tooth_adult_model');
        $this->load->model('record_model');
        
        $this->load->model('notification_model');
        $this->load->model('system_model');
        
        $this->load->model('customer_care_model');
        $photos = $this->photo_model->get_all_photo_from_service();
        $services = $this->service_model->get_all();
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
        //print_r($services);



        $this->service_with_photos = $services;
        $this->all_photos = $photos;


        //automatic update
        //$this->reservation_model->automatic_update();

    }
    function index()
    {
        $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                'title' => "Home - DentView Dental Clinic" );
        $this->load->view('header',$data);
        $this->load->view('dental');
        if(!isset($this->session->userdata['patient_info']['id']))
        {
            $this->load->view('forms');
        }
	$this->load->view('footer');
    }
    function services($link = null)
    {
        
        if($link == null || $link == "")
        {
                redirect(base_url()."patient-services/1");
        }
        $i = 0;
        $controlled_service = array();
        if(isset($this->service_with_photos))
        {
            if(count($this->service_with_photos) > 0)
            {
                foreach($this->service_with_photos as $service)
                {
                    $controlled_service[$i] = $service;
                    $i++;
                }
            }
        }
        
        //print_r($controlled_service);
        $j=0;
        $k=0;
        $new_service = array();
        for($i=0;$i<count($controlled_service);$i++)
        {
            if($j%9==0)
            {
                $j=0;
                $k++;
            }
            $new_service[$k][$j] = $controlled_service[$i];
            $j++;   
        }
        //print_r($new_service);
        
        $final_service = array();
        for($i=0;$i <= count($new_service); $i++)
        {
            
            
            if($link == $i)
            {
                $final_service = $new_service[$i];
                break;
            }
        }
        if($link > count($new_service))
        {
            redirect(base_url()."patient-services/1");
        }
        //print_r($new_service[0]);
        $data = array('all_photos' => $this->all_photos,'services_with_photos' => $final_service,
                'title' => "Services - DentView Dental Clinic",'pages' => count($new_service) );
	$this->load->view('header',$data);
        
        
        if(!isset($this->session->userdata['patient_info']['id']))
        {
            $this->load->view('forms');
        }
        $this->load->view('services');
	$this->load->view('footer');
    }
    
   
    function sign_up()
    {
        $title['title'] = "Sign Up - DentView Dental Clinic";
        $this->load->view('header',$title);
        $this->load->view('sign_up');
        $this->load->view('footer');
    }
    
    function sign_up_validate()
    {
        
        
        $is_from_ajax = $this->input->post('is_from_ajax');
        if($is_from_ajax == 1)
        {
            $email_add = $this->input->post('email_add');
            $patient = $this->patient_model->get_patient_by_email($this->input->post('email_add'));
            if(!$patient)
            {
                echo false;
            }
            else
            {
                echo true; 
            }
        }
        else
        {
            $first_name = $this->input->post('first_name');
                $mi = $this->input->post('mi');
                $last_name = $this->input->post('last_name');
                $email_add = $this->input->post('email_add');
                $password = $this->input->post('password');
                $address = $this->input->post('address');
                $age = $this->input->post('age');
                $gender = $this->input->post('gender');
                $occupation = $this->input->post('occupation');
                $marital_status = $this->input->post('marital_status');
                $mobile_number = $this->input->post('mobile_number');
                $last_logged_in = date('Y-m-d');
                $patient_info = array(
                    'first_name' => $first_name,
                    'mi' => $mi,
                    'last_name' => $last_name,
                    'email_add' => $email_add,
                    'mobile_number' => $mobile_number,
                    'password' => $password,
                    'address' => $address,
                    'age' => $age,
                    'gender' => $gender,
                    'occupation' => $occupation,
                    'marital_status' => $marital_status,
                    'last_logged_in' => $last_logged_in,
                    'status' => "PENDING"
                                );



	    
                $check = $this->patient_model->get_patient_by_email($patient_info['email_add']);
                if($check && is_array($check))
                {
                    $success = $check;
                    $patient = array('patient_info' => $success);
                    $title['title'] = "Sign Up - DentView Dental Clinic";
                    $patient['patient_exist_info'] = $check;
                    $patient['patient_retry_info'] = $patient_info;
                    $this->load->view('header',$title);
                    //$this->load->view('patient_exist',$patient);
                    $this->load->view('dental',$patient);
                    $this->load->view('footer');
                }
                else
                {
                    $success = $this->patient_model->insert($patient_info);

                    if($success == false)
                    {
                        redirect(base_url().'?msg=swwdr');
                    }

                    else
                    {

                        //$msg = array('msg' => "You are now a member of the DentView!");
                        $patient = $this->patient_model->get_patient_by_email($this->input->post('email_add'));


                        //for photo silhouette
                        $photo = array(
                            'from' => 'patient',
                            'from_id' => $patient['id'],
                            'name' => $patient['first_name'].' '.$patient['last_name'],
                            'description' => 'Your profile Picture',
                            'source' => 'images/patient/silhouette.jpg',
                            'status' => "ACTIVE"
                        );
                        
                        
                        $result = $this->photo_model->insert($photo);
                        if($result)
                        {
                            $photo_info = $this->photo_model->get_photo('patient',$patient['id']);
                            if($photo_info)
                            {

                                $patient_info = array('id'=>$patient['id'],
                                'first_name'=>$patient['first_name'],
                                'last_name' => $patient['last_name'],
                                'email_add' => $patient['email_add'],
                                'mi' => $patient['mi'],
                                'address' => $patient['address'],
                                'age' => $patient['age'],
                                'gender' => $patient['gender'],
                                'occupation' => $patient['occupation'],
                                'marital_status' => $patient['marital_status'],
                                'password' => $patient['password'],
                                'photo_info' => $photo_info,
                                    'mobile_number' => $patient['mobile_number']
                            );
                                //$this->session->set_userdata('patient_info',$patient_info);

                            }
                        }
                        //$uri = "patient/confirmation/".$patient['id'];
                        //$link = base_url().$uri;
                        $this->load->library('email');
                        //for configuration of email head to ci_day3/application/config/email.php

                        $this->email->from('DentViewDentalClinic@gmail.com', 'Administrator');
                        $this->email->to($patient['email_add']);
                        $this->email->subject('Confirmation of Account');
                        $this->email->message("Thank you! Please type this password in the log in page so that we can activate your account! Enjoy! This is the confirmation ".$patient_info['id']);

                       // $path = $this->config->item('server_root');
                       // $file = $path.'/ci_day3/attachments/yourInfo.txt';

                        //$this->email->attach($file);

                        if($this->email->send())
                        {
                            redirect(base_url().'?msg=np');
                        }
                        else
                        {
                            redirect(base_url().'?msg=npfsm&cid='.$patient_info['id']);
                        }
                        
                    }
            }
        }
    }
    
    function confirmation($encoded_patiend_id = null)
    {
        $patient_id = $this->encrypt->sha1($encoded_patiend_id);
        $patient = $this->patient_model->get_patient_by_id($patient_id);
        if(is_array($patient_info) && count($patient_info) > 0)
        {
            $patient['status'] = 'ACTIVE';
            $update = $this->patient_model->update($patient);
            if($update)
            {
                $photo_info = $this->photo_model->get_photo('patient',$patient['id']);
                $patient_info = array(
                                    'id'=>$patient['id'],
                                    'first_name'=>$patient['first_name'],
                                    'last_name' => $patient['last_name'],
                                    'email_add' => $patient['email_add'],
                                    'mi' => $patient['mi'],
                                    'address' => $patient['address'],
                                    'password' => $patient['password'],
                                    'photo_info' => $photo_info,
                                    'mobile_number' => $patient['mobile_number']
                    );

                $title['title'] = "Welcome - DentView Dental Clinic";
                $this->session->set_userdata('patient_info',$patient_info);
                $this->load->view('header',$title);
                $this->load->view('profile');
                $this->load->view('footer');
            }
            else
            {
                echo "Something is wrong with the update";
            }
        }
        else
        {
            redirect(base_url());
        }
    }
    
    function account_confirmation()
    {
        $title['title'] = "Confirmation - DentView Dental Clinic";
        $this->load->view('header',$title);
        $this->load->view('account_confirmation');
	$this->load->view('footer');
    }
    function log_in()
    {
        $title['title'] = "Log In - DentView Dental Clinic";
        $this->load->view('header',$title);
        $this->load->view('log_in');
	$this->load->view('footer');
    }
    
    function log_in_validate()
    {
        
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('email_add','Email Address', 'trim|required|valid_email');
        //$this->form_validation->set_rules('password','Password', 'trim|required');
        /*if($this->form_validation->run() == FALSE)
        {
            //redirect(base_url().'patient-sign-up');
            $title['title'] = "Log In - DentView Dental Clinic";
            $this->load->view('header',$title);
            $this->load->view('log_in');
            $this->load->view('footer');
        }
         * *?
         */
        $is_from_ajax = $this->input->post('is_from_ajax');
        if($is_from_ajax == 1)
        {
            $email_add = $this->input->post('email_add');
            $patient = $this->patient_model->get_patient_by_email($this->input->post('email_add'));
            if(!$patient)
                echo false;
            elseif($patient['status'] == "ACTIVE")
            {
                echo true;
            }
            else
            {
                ?>
                 <input type="text" id="confirmation_id" name ="confirmation_id" value="Confirmation code here" onclick="this.value=''">
                <?php
            }
        }
        
        else
        {
            
            $email_add = $this->input->post('email_add');
            $patient = $this->patient_model->get_patient_by_email($this->input->post('email_add'));
            if($patient['status'] != "ACTIVE")
            {
                $confirmation_id = $this->input->post('confirmation_id');
                if($patient['id'] != $confirmation_id)
                {
                    redirect(base_url().'?msg=cidnm');
                }
                else
                {
                    $confirm = $this->patient_model->confirm_email_and_password($patient['email_add'],$this->input->post('password'));
                    if(!$confirm)
                    {
                        redirect(base_url().'?msg=pdnm');
                    }
                    else
                    {
                        //$this->session->start();
                        
                        $msg = array('msg' =>  "LOGGED IN!");
                        $result = $this->patient_model->update_last_logged_in($patient);
                        //$patient['last_logged_in'] = 
                          $patient['status'] = "ACTIVE";
                          $time = now();  
                            $timezone = 'UM4';  
                            $daylight_saving = TRUE; // or FALSE  
                            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
                            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
                            
                          $notification_info = array(
                              'from' => 'patient',
                              'to' => 'admin',
                              'from_id' => $patient['id'],
                              'to_id' => 'default',
                              'about' => 'new patient',
                              'msg' => 'New registered patient',
                              'time' => $local_time,
                              'date' => $local_date,
                              'status' => "ACTIVE"
                          );
                            $this->notification_model->insert($notification_info);
                            $result = $this->patient_model->update($patient);
                        if($patient['age'] < 12)
                        {
                            
                            $tooth_child = array(
                                'patient_id' => $patient['id'],
                                'date' => date("Y-m-d", now())
                            );
                            
                            $confirm_tooth_child = $this->tooth_child_model->insert($tooth_child);
                            
                        }
                        else
                        {
                            $tooth_adult = array(
                                'patient_id' => $patient['id'],
                                'date' => date("Y-m-d", now())
                            );
                            
                            $confirm_tooth_adult = $this->tooth_adult_model->insert($tooth_adult);
                            
                        }
                            if(!$result)
                            {
                                $msg = array('msg'=>'There is something wrong with update',
                                    'error' => $result);
                            }
                            else
                            {
                                $msg = array('msg'=>'Nothing is wrong with update');
                                $reservation_info = $this->reservation_model->get_reserved($patient['id']);
                                $doctor_info = false;
                                if(is_array($reservation_info) && count($reservation_info) > 0)
                                {
                                    $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                                }
                                $photo_info = $this->photo_model->get_photo('patient',$patient['id']);
                                $patient_info = array(
                                'id'=>$patient['id'],
                                'first_name'=>$patient['first_name'],
                                'last_name' => $patient['last_name'],
                                'email_add' => $patient['email_add'],
                                'mi' => $patient['mi'],
                                'mobile_number' => $patient['mobile_number'],
                                'address' => $patient['address'],
                                'age' => $patient['age'],
                                'gender' => $patient['gender'],
                                'occupation' => $patient['occupation'],
                                'marital_status' => $patient['marital_status'],
                                'password' => $patient['password'],
                                'photo_info' => $photo_info,
                                'reservation_info' => $reservation_info,
                                'doctor_info' => $doctor_info
                                );

                                $this->session->set_userdata('patient_info',$patient_info);

                                redirect(base_url());

                            }
                    
                    $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                                    'title' => "Home - DentView Dental Clinic" );
                    $this->load->view('header',$data);
                    $this->load->view('dental',$msg);
                    $this->load->view('forms');
                    //$this->load->view('dental',$msg);
                    $this->load->view('footer');
                    }
                }
            }
            else
             {          
                $confirm = $this->patient_model->confirm_email_and_password($patient['email_add'],$this->input->post('password'));
                if(!$confirm)
                {
                    redirect(base_url().'?msg=pdnm');
                }
                else
                {
                    //$this->session->start();
                    $msg = array('msg' =>  "LOGGED IN!");
                    $result = $this->patient_model->update_last_logged_in($patient);
                    //$patient['last_logged_in'] = 
                    
                        if(!$result)
                        {
                            $msg = array('msg'=>'There is something wrong with update',
                                'error' => $result);
                        }
                        else
                        {
                            $msg = array('msg'=>'Nothing is wrong with update');
                            $reservation_info = $this->reservation_model->get_reserved($patient['id']);
                            $doctor_info = false;
                            if(is_array($reservation_info) && count($reservation_info) > 0)
                            {
                                $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                            }
                            $photo_info = $this->photo_model->get_photo('patient',$patient['id']);
                            $patient_info = array(
                            'id'=>$patient['id'],
                            'first_name'=>$patient['first_name'],
                            'last_name' => $patient['last_name'],
                            'email_add' => $patient['email_add'],
                            'mi' => $patient['mi'],
                            'mobile_number' => $patient['mobile_number'],
                            'address' => $patient['address'],
                            'age' => $patient['age'],
                            'gender' => $patient['gender'],
                            'occupation' => $patient['occupation'],
                            'marital_status' => $patient['marital_status'],
                            'password' => $patient['password'],
                            'photo_info' => $photo_info,
                            'reservation_info' => $reservation_info,
                            'doctor_info' => $doctor_info
                            );

                            $this->session->set_userdata('patient_info',$patient_info);
                            if($patient_info['age'] < 12)
                            {
                                $confirm_exist_tooth_child = $this->tooth_child_model->get_tooth_child_by_patient_id($patient_info['id']);
                                if(!$confirm_exist_tooth_child)
                                {
                                    $tooth_child = array(
                                        'patient_id' => $patient_info['id'],
                                        'date' => date("Y-m-d", now())
                                    );
                                    $confirm_tooth_child = $this->tooth_child_model->insert($tooth_child);
                                }
                            }
                            else
                            {
                                $confirm_exist_tooth_adult = $this->tooth_adult_model->get_tooth_adult_by_patient_id($patient_info['id']);
                                if(!$confirm_exist_tooth_adult)
                                {
                                    $tooth_adult = array(
                                        'patient_id' => $patient_info['id'],
                                        'date' => date("Y-m-d", now())
                                    );

                                    $confirm_tooth_adult = $this->tooth_adult_model->insert($tooth_adult);
                                }
                            }
                            redirect(base_url());
                    }
                    $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                                    'title' => "Home - DentView Dental Clinic" );
                    $this->load->view('header',$data);
                    $this->load->view('dental',$msg);
                    $this->load->view('forms');
                    $this->load->view('footer');
                }
          }

        }
    }
    
    function log_out()
    {
        $this->session->unset_userdata('patient_info');
        $msg = array('msg'=>'Successfully logged out!');
        redirect(base_url());
    }
    
    function reservation()
    {
        if(isset($this->session->userdata['patient_info']['id']))
        {
            $is_reserved = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
        }
        else
        {
            $is_reserved = false;
        }
            $doctors = $this->doctor_model->get_all();
            $data = array(
                'doctors' => $doctors,
                'is_reserved' => $is_reserved,
                'is_from' => 'reservation'
            );
        //$this->load->view('header');
           // print_r($is_reserved);
            $this->load->view('reservation',$data);
            $this->load->view('footer');
        
    }
    
    function reservation_validate()
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


        $timer = unix_to_human(now());
        //echo $timer;
        
        if(date('Ymd') == date('Ymd', strtotime($this->input->post('date'))))
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
                         $whole_day = false;
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
            //echo $time_hr;
            if($time_hr > $time_start)
            {
                if($time_hr < 20)
                {
                    $time_start = $time_hr;
                }
            }

            if($time_start > 20)
            {
                echo "You are not allowed to make reservations as of now. Adjust to tomorrow instead.";
            }
            else
            {
                
                if($time_start < 7)
                {
                    $time_start = 8;
                }
                
                if($day == 0 && $time_start <= 13)
                {
                    $time_start = 13;
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
                if(isset($this->session->userdata['patient_info']['id']))
                {
                    $reservation_info = array(
                        'patient_id' => $this->session->userdata['patient_info']['id'],
                        'doctor_id' => $this->input->post('doctor_id'),
                        'time' => $time,
                        'hour' => $hour,
                        'service_ids' => $service_ids,
                        'specified_service' => $specified_service,
                        'date' => $date_formatted,
                        'status' => "ACTIVE"

                    );
                }

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
                        //print_r($date_not_available);
                        $time_info = array('time_info' => $date_not_available,'time_start' => $time_start, 'time_end' => $time_end,'whole_day' => $whole_day);
                        $this->load->view('time',$time_info);
                    }
                    else
                        echo $date_not_available;
                }
                else
                {
                    //print_r($reservation_info);
                    $result = $this->reservation_model->insert($reservation_info);
                    if($result)
                    {
                        
                        $time = now();  
                            $timezone = 'UM4';  
                            $daylight_saving = TRUE; // or FALSE  
                            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
                            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
                            
                            //$date_before = date("F d Y",  strtotime($reservation_before['date']));
                            $date_info = date("F d Y",  strtotime($reservation_info['date']));
                            $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                          $notification_info = array(
                              'from' => 'patient',
                              'to' => 'doctor',
                              'from_id' => $reservation_info['patient_id'],
                              'to_id' => $reservation_info['doctor_id'],
                              'about' => 'reservation',
                              'msg' => $this->session->userdata['patient_info']['first_name'].' '.$this->session->userdata['patient_info']['first_name']." has made a reservation on time ".$this->input->post('time').','.$date_info,
                              'time' => $local_time,
                              'date' => $local_date,
                              'status' => "ACTIVE"
                          );
                        
                        $this->notification_model->insert($notification_info);
                        $reservation_info = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
                        $msg = "Your profile has been successfully updated!";
                        //$doctor_info = false;
                        if(is_array($reservation_info) && count($reservation_info) > 0)
                        {
                            $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                        }
                        else
                        {
                            $reservation_info = false;
                            $doctor_info = false;
                        }
                        $photo_info = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                        $patient_info = $this->patient_model->get_patient_by_id($this->session->userdata['patient_info']['id']);
                        $patient = array(
                            'id' => $patient_info['id'],
                            'first_name' => $patient_info['first_name'],
                            'last_name' => $patient_info['last_name'],
                            'mi' => $patient_info['mi'],
                            'password' => $patient_info['password'],
                            'address' => $patient_info['address'],
                            'mobile_number' => $patient_info['mobile_number'],
                            'age' => $patient_info['age'],
                            'gender' => $patient_info['gender'],
                            'occupation' => $patient_info['occupation'],
                            'marital_status' => $patient_info['marital_status'],
                            'email_add' => $patient_info['email_add'],
                            'photo_info' => $photo_info,
                            'reservation_info' => $reservation_info,
                            'doctor_info' => $doctor_info
                        );
                        $this->session->set_userdata('patient_info',$patient);

                        //email doctor

//                            $this->load->library('email');
//                            //for configuration of email head to ci_day3/application/config/email.php
//                            //echo $doctor_info['email_add'];
//                            $this->email->from('DentViewDentalClinic@gmail.com', 'Administrator');
//                            $this->email->to($doctor_info['email_add']);
//                            $this->email->subject('Reservation of Patient');
//                            $this->email->message("Patient ".$patient_info['first_name']." ".$patient_info['last_name']." has made a registration on ".$this->input->post('date')." at ".$time_for_doctor.".");
//
//                           // $path = $this->config->item('server_root');
//                           // $file = $path.'/ci_day3/attachments/yourInfo.txt';
//
//                            //$this->email->attach($file);
//                            if($this->email->send())
//                            {
//                                echo "Email sent to doctor";
//                            }
//                            else
//                            {
//                                echo "Something went wrong during the reservation.</br>It might be caused by the slow internet connection.</br>Please do check if the reservation has been successfully made.";
//                            }

                         echo "You are now reserved!";
                    }
                    else 
                    {
                        echo "Something is wrong with the reservation.";
                    }
                }
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
            
            
            if($day == 0 && $time_start <= 13)
            {
                $time_start = 13;
            }
            
            if($time_start < 7)
            {
                $time_start = 10;
            }
            
            //echo $time_start;
            
            
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
            if(isset($this->session->userdata['patient_info']['id']))
            {
                $reservation_info = array(
                    'patient_id' => $this->session->userdata['patient_info']['id'],
                    'doctor_id' => $this->input->post('doctor_id'),
                    'time' => $time,
                    'hour' => $hour,
                    'service_ids' => $service_ids,
                    'specified_service' => $specified_service,
                    'date' => $date_formatted,
                    'status' => "ACTIVE"

                );
            }

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
                       
                        $date_not_available[$i]['patient_info'] = $this->patient_model->get_patient_by_id($date_not_available[$i]['patient_id']);
                    }
                    //print_r($date_not_available);
                    $time_info = array('time_info' => $date_not_available,'time_start' => $time_start,'time_end' => $time_end,'whole_day' => $whole_day);
                    $this->load->view('time',$time_info);
                }
                else
                    echo $date_not_available;
            }
            else
            {
                //print_r($reservation_info);
                $result = $this->reservation_model->insert($reservation_info);
                
                if($result)
                {
                    $time = now();  
                            $timezone = 'UM4';  
                            $daylight_saving = TRUE; // or FALSE  
                            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
                            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
                            
                          $notification_info = array(
                              'from' => 'patient',
                              'to' => 'doctor',
                              'from_id' => $reservation_info['patient_id'],
                              'to_id' => $reservation_info['doctor_id'],
                              'about' => 'Reservation',
                              'msg' => 'Patient '.$this->session->userdata['patient_info']['first_name']." ".$this->session->userdata['patient_info']['last_name'].' has reserved a slot on time '.$this->input->post('time').','.date_format(new DateTime($date_formatted),"F d Y"),
                              'time' => $local_time,
                              'date' => $local_date,
                              'status' => "ACTIVE"
                          );
                        
                        $this->notification_model->insert($notification_info);
                        
                    $reservation_info = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
                    $msg = "Your profile has been successfully updated!";
                    //$doctor_info = false;
                    if(is_array($reservation_info) && count($reservation_info) > 0)
                    {
                        $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                    }
                    else
                    {
                        $reservation_info = false;
                        $doctor_info = false;
                    }
                    $photo_info = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                    $patient_info = $this->patient_model->get_patient_by_id($this->session->userdata['patient_info']['id']);
                    $patient = array(
                        'id' => $patient_info['id'],
                        'first_name' => $patient_info['first_name'],
                        'last_name' => $patient_info['last_name'],
                        'mi' => $patient_info['mi'],
                        'password' => $patient_info['password'],
                        'address' => $patient_info['address'],
                        'mobile_number' => $patient_info['mobile_number'],
                        'age' => $patient_info['age'],
                        'gender' => $patient_info['gender'],
                        'occupation' => $patient_info['occupation'],
                        'marital_status' => $patient_info['marital_status'],
                        'email_add' => $patient_info['email_add'],
                        'photo_info' => $photo_info,
                        'reservation_info' => $reservation_info,
                        'doctor_info' => $doctor_info
                    );
                    $this->session->set_userdata('patient_info',$patient);

                    //email doctor

//                        $this->load->library('email');
//                        $this->email->from('DentViewDentalClinic@gmail.com', 'Administrator');
//                        $this->email->to($doctor_info['email_add']);
//                        $this->email->subject('Reservation of Patient');
//                        $this->email->message("Patient ".$patient_info['first_name']." ".$patient_info['last_name']." has made a registration on ".$this->input->post('date')." at ".$time_for_doctor.".");

                       // $path = $this->config->item('server_root');
                       // $file = $path.'/ci_day3/attachments/yourInfo.txt';

                        //$this->email->attach($file);
//                        if($this->email->send())
//                        {
//                            echo "You are now reserved!";
//                        }
//                        else
//                        {
//                            echo "Something went wrong during the reservation.</br>It might be caused by the slow internet connection.</br>Please do check if the reservation has been successfully made.";
//                        }
                        echo "You are now reserved!";

                }
                else 
                {
                    echo "Something is wrong with the reservation.";
                }
            }
        }  
    }
    function profile()
    {
        
        if(!isset($this->session->userdata['patient_info']['id']))
        {
            redirect(base_url());
        }
        else
        {
            $patient = $this->patient_model->get_patient_by_email($this->session->userdata['patient_info']['email_add']);
            $reservation = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
            //print_r($reservation);
            //echo "Time karun!: ".unix_to_human(now());
            
            if(is_array($patient)) // && is_array($reservation)
            {
                
                $notification_about_reservation_info = $this->notification_model->get_notification_for_patient_about('Reservation',$this->session->userdata['patient_info']['id']);
                if(!is_array($notification_about_reservation_info) || count($notification_about_reservation_info) < 1)
                {
                    $notification_about_reservation_info = false;
                }
                
                /*
                $notification_about_personal_message_info = $this->notification_model->get_notification_for_patient_about('Personal Message',$this->session->userdata['patient_info']['id']);
                if(!is_array($notification_about_personal_message_info) || count($notification_about_personal_message_info) < 1)
                {
                    $notification_about_personal_message_info = false;
                }
                else
                {
                    $new = array();
                    $ctr = 0;
                    $ctr_new = 0;
                    $i = 0;
                    foreach($notification_about_personal_message_info as $notification)
                    {
                       
                       $notification_about_personal_message_info[$i]['doctor_info'] = $this->doctor_model->get_doctor_by_id($notification['from_id']);
                       if($i!=0)
                       {
                           if($notification_about_personal_message_info[$i]['doctor_info']['id'] != $notification_about_personal_message_info[$i+1]['doctor_info']['id'])
                           {
                                
                                $new[$ctr][$new_ctr] = $notification_about_personal_message_info[$i]['doctor_info'];
                                $ctr_new++;
                                $ctr++;
                                
                           }
                           else
                           {
                               $new[$ctr][$new_ctr] = $notification_about_personal_message_info[$i]['doctor_info'];
                           
                               $new_ctr++;
                           }
                       }
                       $i++;
//                       if(isset($notification_about_personal_message_info[$i+1]))
//                       {
//                            if($notification_about_personal_message_info[$i]['doctor_info']['id'] != $notification_about_personal_message_info[$i+1]['doctor_info']['id'])
//                            {
//                                $all_sorted = 
//                            }
//                       }
                    }
                    
                }
                 * */
                 
                    $reservation_info = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
                    $msg = "Your profile has been successfully updated!";
                    $doctor_info = false;
                    if(is_array($reservation_info) && count($reservation_info) > 0)
                    {
                        $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                    }
                    
                    $photo_info = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                    $patient_info = $this->patient_model->get_patient_by_id($this->session->userdata['patient_info']['id']);
                    $patient = array(
                        'id' => $patient_info['id'],
                        'first_name' => $patient_info['first_name'],
                        'last_name' => $patient_info['last_name'],
                        'mi' => $patient_info['mi'],
                        'password' => $patient_info['password'],
                        'address' => $patient_info['address'],
                        'mobile_number' => $patient_info['mobile_number'],
                        'age' => $patient_info['age'],
                        'gender' => $patient_info['gender'],
                        'occupation' => $patient_info['occupation'],
                        'marital_status' => $patient_info['marital_status'],
                        'email_add' => $patient_info['email_add'],
                        'photo_info' => $photo_info,
                        'reservation_info' => $reservation_info,
                        'doctor_info' => $doctor_info
                    );
                    $this->session->set_userdata('patient_info',$patient);

                
                $doctors = $this->doctor_model->get_all();
                $encoded = $patient['password'];
                $patient_info = array(
                    'first_name' => $patient['first_name'],
                    'mi' => $patient['mi'],
                    'last_name' => $patient['last_name'],
                    'email_add' => $patient['email_add'],
                    'mobile_number' => $patient['mobile_number'],
                    'age' => $patient['age'],
                    'gender' => $patient['gender'],
                    'occupation' => $patient['occupation'],
                    'marital_status' => $patient['marital_status'],
                    'password' => $encoded,
                    'address' => $patient['address'],
                );
                
                $record_info = $this->record_model->get_record_by_patient_id($this->session->userdata['patient_info']['id']);
                
                
                $patient = array(
                    'patient_info' => $patient_info,
                    'reservation_info' => $reservation,
                    'doctors' => $doctors,
                    'record_info' => $record_info,
                    'notification_about_reservation_info' => $notification_about_reservation_info
                    //'notification_about_personal_message_info' => $new
                );
                
                $title['title'] = "My Profile - DentView Dental Clinic";
                $this->load->view('header',$title);
                $this->load->view('profile',$patient);
                $this->load->view('footer');
                
            }
            else
            {
                echo 'Something was wrong during the retrieving of data.';
            }
        }
    }

    function profile_edit()
    {
//       
        
            
            $first_name = $this->input->post('first_name');
            $mi = $this->input->post('mi');
            $last_name = $this->input->post('last_name');
            $email_add = $this->input->post('email_add');
            $password = $this->input->post('password');
            if($password == "")
            {
                $password = $this->session->userdata['patient_info']['password'];
            }
            else
            {
                $password = $this->encrypt->sha1($password);
            }
            $age = $this->input->post('age');
                $gender = $this->input->post('gender');
                $occupation = $this->input->post('occupation');
                $marital_status = $this->input->post('marital_status');
                
            $mobile_number =$this->input->post('mobile_number');
            $address = $this->input->post('address');
            $last_logged_in = date('Y-m-d');
            $patient_info = array(
                'id' => $this->session->userdata['patient_info']['id'],
                'first_name' => $first_name,
                'mi' => $mi,
                'last_name' => $last_name,
                'email_add' => $email_add,
                'mobile_number' => $mobile_number,
                'age' => $age,
                'gender' => $gender,
                'occupation' => $occupation,
                'marital_status' => $marital_status,
                'password' => $password,
                'address' => $address,
                'last_logged_in' => $last_logged_in
                            );

            $result = $this->patient_model->update($patient_info);
            //$this->patient_model->password_check();
            if($result)
            {
                $reservation_info = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
                $msg = "Your profile has been successfully updated!";
                $doctor_info = false;
                if(is_array($reservation_info) && count($reservation_info) > 0)
                {
                    $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                }
                $photo_info = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                $patient_info = $this->patient_model->get_patient_by_id($this->session->userdata['patient_info']['id']);
                $patient = array(
                    'id' => $patient_info['id'],
                    'first_name' => $patient_info['first_name'],
                    'last_name' => $patient_info['last_name'],
                    'mi' => $patient_info['mi'],
                    'password' => $patient_info['password'],
                    'address' => $patient_info['address'],
                    'mobile_number' => $patient_info['mobile_number'],
                    'age' => $patient_info['age'],
                    'gender' => $patient_info['gender'],
                    'occupation' => $patient_info['occupation'],
                    'marital_status' => $patient_info['marital_status'],
                    'email_add' => $patient_info['email_add'],
                    'photo_info' => $photo_info,
                    'reservation_info' => $reservation_info,
                    'doctor_info' => $doctor_info
                );
                $this->session->set_userdata('patient_info',$patient);
                
            }
            else
            {
                $msg = "There was a failure in editing your data. Please do try again.";
            }
            
            $patient = $this->patient_model->get_patient_by_email($this->session->userdata['patient_info']['email_add']);
            $reservation = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
            //print_r($reservation);
            //echo "Time karun!: ".unix_to_human(now());
            if(count($patient) > 0)
            {
                //print_r($patient);
                $encoded = $patient['password'];
                $patient_info = array(
                    'first_name' => $patient['first_name'],
                    'mi' => $patient['mi'],
                    'last_name' => $patient['last_name'],
                    'email_add' => $patient['email_add'],
                    'mobile_number' => $patient['mobile_number'],
                    'password' => $encoded,
                    'address' => $patient['address'],
                    'age' => $patient['age'],
                    'gender' => $patient['gender'],
                    'occupation' => $patient['occupation'],
                    'marital_status' => $patient['marital_status'],
                    
                );
                $patient = array(
                    'patient_info' => $patient_info,
                    'reservation_info' => $reservation
                    
                );
                 
            }
            echo $msg;
    }
    
    function upload()
    {
        if(!isset($this->session->userdata['patient_info']['id']))
        {
            redirect(base_url());
        }
        $kind = $this->input->post('button_uploader');
        if(isset($kind) && $kind!="")
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
			//$this->load->view('upload_form', $error);
                        redirect(base_url().'patient-profile?msg=ufe');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
                        $path = $data['upload_data']['full_path'];
                        $name = $data['upload_data']['file_name'];
                        $photo_data = $data;
                }
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
			//$error = array('error' => $this->upload->display_errors());
                        redirect(base_url().'patient-profile?msg=ufe');
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
                        $path = $data['upload_data']['full_path'];
                        $name = $data['upload_data']['file_name'];
                        $photo_data = $data;
                        $this->resize_picture($path, $name);
                        $photo_from_patient = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                        if(!$photo_from_patient)
                        {
                            $photo_info = array(
                            'from' => 'patient',
                            'from_id' => $this->session->userdata['patient_info']['id'],
                            'name' => $this->session->userdata['patient_info']['first_name'].' '.$this->session->userdata['patient_info']['last_name'],
                            'description' => '',
                            'source' => 'images/patient/'.$data['upload_data']['file_name'],
                            'status' => 'ACTIVE'
                            );
                        
                            $this->photo_model->insert($photo_info);
                        }
                        else
                        {
                            $photo_info = array(
                            'id' => $photo_from_patient['id'],
                            'from' => 'patient',
                            'from_id' => $this->session->userdata['patient_info']['id'],
                            'name' => $this->session->userdata['patient_info']['first_name'].' '.$this->session->userdata['patient_info']['last_name'],
                            'description' => '',
                            'source' => 'images/patient/'.$data['upload_data']['file_name'],
                            'status' => 'ACTIVE'
                            );
                            
                            $this->photo_model->update($photo_info);
                            //print_r($photo_info);
                            //echo '<br/>';
                            $reservation_info = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
                            $doctor_info = false;
                            if(is_array($reservation_info) && count($reservation_info) > 0)
                            {
                                $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                            }
                            $result_from_photo = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                            if($result_from_photo)
                            {
                                $patient_info2 = array(
                                    'id' => $this->session->userdata['patient_info']['id'],
                                    'first_name' => $this->session->userdata['patient_info']['first_name'],
                                    'mi' => $this->session->userdata['patient_info']['mi'],
                                    'last_name' => $this->session->userdata['patient_info']['last_name'],
                                    'email_add' => $this->session->userdata['patient_info']['email_add'],
                                    'password' => $this->session->userdata['patient_info']['password'],
                                    'address' => $this->session->userdata['patient_info']['address'],
                                    'mobile_number' => $this->session->userdata['patient_info']['mobile_number'],
                                    'age' => $this->session->userdata['patient_info']['age'],
                                    'gender' => $this->session->userdata['patient_info']['gender'],
                                    'occupation' => $this->session->userdata['patient_info']['occupation'],
                                    'marital_status' => $this->session->userdata['patient_info']['marital_status'],
                                    'photo_info' => $result_from_photo,
                                    'reservation_info' => $reservation_info,
                                    'doctor_info' => $doctor_info
                                );
                                $this->session->set_userdata('patient_info',$patient_info2);
                                $msg = "Updating your profile is succcessful!";
                            }
                            else
                            {
                                echo "Wrong with retrieving photo.";
                            }
                        }
			$data = array('msg' => $msg, 'is_edited' => true);
            redirect(base_url().'patient-profile');
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
        
    function load_reservation_page()
    {
        $img = "<img src=".base_url()."images/loading.gif".">";
        //$is_reservation = $this->input->post('is_reservation');
        //echo $img;
        if(isset($this->session->userdata['patient_info']['id']))
        {
            $is_reserved = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
        }
        else
        {
            $is_reserved = false;
        }
            
        //$this->load->view('header');
           // print_r($is_reserved);
            
                $is_reschedule = $this->input->post('is_reschedule');
                if($is_reschedule)
                    $is_from = "reschedule";
            
                $is_reservation = $this->input->post('is_reservation');
                if($is_reservation)
                    $is_from = "reservation";
            
//            echo $is_reschedule;
            $doctors = $this->doctor_model->get_all();
            $data = array(
                'doctors' => $doctors,
                'is_reserved' => $is_reserved,
                'is_from' => $is_from
            );
            //$this->load->view('header');
            $this->load->view('reservation',$data);
            $this->load->view('footer');
    }
    
    function photo_preview()
    {
        $config['upload_path'] = './uploads/patient';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
        $config['overwrite'] = true;

        $this->load->library('upload', $config);
        $name = $this->input->post('upload_data');
        $data = array('upload_data' => $this->upload->data());
                        $path = $data['upload_data']['full_path'];
                        $name = $data['upload_data']['file_name'];
                        print_r($data);
    }
    
    function reschedule()
    {
        
            //$date_first = $this->input->post('date');
            
            $date = date_create($this->input->post('date'));
            $time_for_doctor = $this->input->post('time');
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
            'patient_id' => $this->session->userdata['patient_info']['id'],
            'doctor_id' => $this->input->post('doctor_id'),
            'time' => $time,
            'hour' => $hour,
            'service_ids' => $service_ids,
            'specified_service' => $specified_service,
            'date' => $date_formatted,
            'status' => 'ACTIVE'

            );
            $reservation_before = $this->reservation_model->get_reservation($this->input->post('reservation_id'));
            $result = $this->reservation_model->update($reservation_info);
            
            if(isset($this->session->userdata['patient_info']['gender']))
            {
                if($this->session->userdata['patient_info']['gender'] == "Male")
                {
                    $gender = "his";
                }
                else
                {
                    $gender = "her";
                }
            }
            else
            {
                $gender = "his";
            }
            
            $real_time = "";
            $time = $reservation_before['time'][0].$reservation_before['time'][1];
            if($time<=11)
            {
                $real_time = $time.":00 AM";
            }
            elseif($time == 12)
            {
                $real_time = $time.":00 PM";
            }
            else
            {
                $real_time = ($time-12).":00 PM";
            }
            
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
             if($reservation_before['doctor_id'] == $reservation_info['doctor_id'])
             {
                 //$date = DateTime::createFromFormat('Y-m-d',$reservation_info);
                 $date_before = date("F d Y",  strtotime($reservation_before['date']));
                 $date_info = date("F d Y",  strtotime($reservation_info['date']));
                  $notification_info = array(
                      'from' => 'patient',
                      'to' => 'doctor',
                      'from_id' => $reservation_info['patient_id'],
                      'to_id' => $reservation_info['doctor_id'],
                      'about' => 'Reservation',
                      'msg' => 'Patient '.$this->session->userdata['patient_info']['first_name']." ".$this->session->userdata['patient_info']['last_name'].' has rescheduled '.$gender.' time '.$real_time.','.$date_before.' to '.$time_for_doctor.', '.$date_info,
                      'time' => $local_time,
                      'date' => $local_date,
                      'status' => "ACTIVE"
                  );
                  $this->notification_model->insert($notification_info);
             }
             else
             {
                 if(isset($this->session->userdata['patient_info']['gender']))
                {
                    if($this->session->userdata['patient_info']['gender'] == "MALE")
                    {
                        $gender = "his";
                    }
                    else
                    {
                        $gender = "her";
                    }
                }
                else
                {
                    $gender = "his";
                }
                 $date_before = date("F d Y",  strtotime($reservation_before['date']));
                 $date_info = date("F d Y",  strtotime($reservation_info['date']));
                 $notification_info = array(
                      'from' => 'patient',
                      'to' => 'doctor',
                      'from_id' => $reservation_info['patient_id'],
                      'to_id' => $reservation_info['doctor_id'],
                      'about' => 'Reservation',
                      'msg' => 'Patient '.$this->session->userdata['patient_info']['first_name']." ".$this->session->userdata['patient_info']['last_name'].' has reserved a slot on time '.$this->input->post('time').','.$date_info,
                      'time' => $local_time,
                      'date' => $local_date,
                      'status' => "ACTIVE",
                     
                  );
                 $this->notification_model->insert($notification_info);
                 
                 $time = abs($reservation_before['time'][0].$reservation_before['time'][1]);
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
                 $date_before = date("F d Y",  strtotime($reservation_before['date']));
                 $date_info = date("F d Y",  strtotime($reservation_info['date']));
                 
                 $notification_info = array(
                      'from' => 'patient',
                      'to' => 'doctor',
                      'from_id' => $reservation_info['patient_id'],
                      'to_id' => $reservation_info['doctor_id'],
                      'about' => 'Reservation',
                      'msg' => 'Patient '.$this->session->userdata['patient_info']['first_name']." ".$this->session->userdata['patient_info']['last_name'].' has cancelled '.$gender.' reservation on time '.$real_time.','.$date_info,
                      'time' => $local_time,
                      'date' => $local_date,
                      'status' => "ACTIVE",
                     
                  );
                 $this->notification_model->insert($notification_info);
             }
            
                     
            if($result)
            {
                $reservation_info = $this->reservation_model->get_reserved($this->session->userdata['patient_info']['id']);
                $doctor_info = false;
                if(is_array($reservation_info) && count($reservation_info) > 0)
                {
                    $doctor_info = $this->doctor_model->get_doctor_by_id($reservation_info['doctor_id']);
                }
                $msg = "Your profile has been successfully updated!";
                $photo_info = $this->photo_model->get_photo('patient',$this->session->userdata['patient_info']['id']);
                $patient_info = $this->patient_model->get_patient_by_id($this->session->userdata['patient_info']['id']);
                $patient = array(
                    'id' => $patient_info['id'],
                    'first_name' => $patient_info['first_name'],
                    'last_name' => $patient_info['last_name'],
                    'mi' => $patient_info['mi'],
                    'password' => $patient_info['password'],
                    'address' => $patient_info['address'],
                    'mobile_number' => $patient_info['mobile_number'],
                    'email_add' => $patient_info['email_add'],
                    'age' => $patient_info['age'],
                    'gender' => $patient_info['gender'],
                    'occupation' => $patient_info['occupation'],
                    'marital_status' => $patient_info['marital_status'],

                    'photo_info' => $photo_info,
                    'reservation_info' => $reservation_info,
                    'doctor_info' => $doctor_info
                );
                $this->session->set_userdata('patient_info',$patient);

                
             echo "Successfully rescheduled!";
        }
       
     
            
    }
    function lapay()
    {
        
        $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                'title' => "Services - DentView Dental Clinic" );
	$this->load->view('header',$data);
        $this->load->view('lapay');
        $this->load->view('footer');
    }
    
    function view_doctor_profile($doctor_id)
    {
        
        $doctor = $this->doctor_model->get_doctor_by_id($doctor_id);
        if(!$doctor)
        {
            redirect(base_url());
        }
        else
        {
            $expertise_info = $this->expertise_model->get_all_from_doctor($doctor['id']);
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
            
            $photo_info = $this->photo_model->get_photo('doctor',$doctor['id']);
            $doctor_profile['doctor_info'] = $doctor;
            $doctor_profile['photo_info'] = $photo_info;
            $doctor_profile['expertise_with_service'] = $expertise_with_service;
            $title['title'] = "Dr. ".$doctor['first_name']." ".$doctor['last_name']."'s Profile - DentView Dental Clinic";
            $this->load->view('header',$title);
            $this->load->view('view_doctor_profile',$doctor_profile);
            if(!isset($this->session->userdata['patient_info']['id']))
            {
                $this->load->view('forms');
            }
            $this->load->view('footer');
        }
    }
    function email_validate($email)
    {
        $this->load->library('form_validation');
        //echo "alalah!";
        $this->form_validation->set_rules($email,'Email Address', 'trim|required|valid_email');
        if($this->form_validation->run() == FALSE)
        {
            echo "<img src=".base_url()."images/wrong.jpg".">";
        }
        else
        {
            echo "<img src=".base_url()."images/right.jpg".">";
        }
    }
    
    function view_all_doctors()
    {
       
        $doctors = $this->doctor_model->get_all();
        //print_r($doctors);
        $complete_info_from_doctor = array();
        $i = 0;
        for($i=0;;$i++)
        {
            $complete_info_from_doctor[$i]['doctor_info'] = $doctors[$i];
            $complete_info_from_doctor[$i]['photo_info'] = $this->photo_model->get_photo('doctor',$doctors[$i]['id']);
            $complete_info_from_doctor[$i]['expertise_info'] = $this->expertise_model->get_all_from_doctor($doctors[$i]['id']);
            if(!isset($doctors[$i+1]))
            {
                break;
            }
        }
        $complete_info = array('complete_info_from_doctor' => $complete_info_from_doctor);
        //print_r($complete_info_from_doctor);
        $title['title'] = "Doctors - DentView Dental Clinic";
        $this->load->view('header',$title);
        $this->load->view('view_all_doctor',$complete_info);
        if(!isset($this->session->userdata['patient_info']['id']))
        {
            $this->load->view('forms');
        }
        $this->load->view('footer');
    }
    
    function send_mail($reservation_info)
    {
        if(isset($this->session->userdata['patient_info']['id']))
        {
            redirect(base_url());
        }
        else
        {
            $this->load->library('email');
            //for configuration of email head to ci_day3/application/config/email.php

            $this->email->from('captainbuggythefifth@gmail.com', 'Gaudencio Teves');
            $this->email->to('melvs.evangelista@gmail.com');
            $this->email->subject('This is an email test');
            $this->email->message('It is working. Great!');

           // $path = $this->config->item('server_root');
           // $file = $path.'/ci_day3/attachments/yourInfo.txt';

            //$this->email->attach($file);

            if($this->email->send()){
                echo 'Your email was sent, fool.';
            }
            else{
                show_error($this->email->print_debugger());
            }
        }
    }
    
    function lapay_new()
    {
        $data = array('all_photos' => $this->all_photos,'services_with_photos' => $this->service_with_photos,
                'title' => "Services - DentView Dental Clinic" );
	$this->load->view('header',$data);
        $this->load->view('new');
        $this->load->view('footer');
    }
    
    function history()
    {
        //echo $this->session->userdata['patient_info']['id'];
        $record_info = $this->record_model->get_record_by_patient_id($this->session->userdata['patient_info']['id']);
        if(is_array($record_info) && count($record_info) > 0)
        {
            $patient_record_info = $record_info;
            ?>
                 <script>
                    $(function() {
                    $("#tab_record").tabs();
                    $('.search_history').datepicker({})
                    })
                </script>
                Search History by Date : <input type="text" class="search_history">
                <div id="tab_record" style="height:493">
                    <ul>
                        <?php 
                            foreach($patient_record_info as $record)
                            {
                        ?>
                        <li><a href="#<?php echo $record['id']?>" class="ul_tab" name="<?php echo $record['id']?>"> <?php echo $record['date']?> </a></li>

                        <?php }

                        ?>
                    </ul>
                    <?php foreach($patient_record_info as $record)
                        {
                        ?>
                        <div id="<?php echo $record['id'];?>">
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



                        </div>
                    <?php
                        }
                    ?>
                    <script>
                        $('.search_history').change(function(){
                            var form_data = {
                                patient_id : "<?php echo $this->session->userdata['patient_info']['id']?>",
                                date : $(this).val()
                                //data : $('.tab_record').html()
                            }

                            $.ajax({
                                url : "<?php echo base_url()?>patient/search_history",
                                type : "POST",
                                data : form_data,
                                success : function(msg){
                                    $('#tab_record').slideUp('slow');
                                    $('#searched').html(msg);
                                }
                            })

                        });


                    </script>
                    <a href="#" id="print" name="<?php echo $patient_record_info[0]['id']?>">Print</a></br>
                    <div id="rame" style=" display: none"></div>

                    <script>
                        $('#print').click(function(){
                            var record_id = this.name
                            var url = "<?php echo base_url()?>admin/record_print/"+record_id;
                             //var url = this.href;
                             $('#rame').html("<iframe src='"+url+"'></iframe>");
                             window.frames[0].print();
                        })
                    </script>

                    <script>
                        $('.ul_tab').click(function(){
                            document.getElementById("print").name = this.name;
                        })
                    </script>
                    </div>
                    <a href="#" id="latest_record">Hide Latest Record</a>
                    <div id="searched"></div>
                
                <script>
                        $('#latest_record').toggle(function(){
                            $('#tab_record').slideUp('slow'),
                            $(this).text("Show Latest Record")
                        }, function(){
                            $('#tab_record').slideDown('slow'),
                            $(this).text("Hide Latest Record")
                        })
                    </script>
                    
            <?php
        }
        else
        {
            echo "You do not have a record yet";
        }
    }
    
    function tooth()
    {
        if($this->session->userdata['patient_info']['age'] < 12)
        {
            $tooth_info = $this->tooth_child_model->get_tooth_child_by_patient_id($this->session->userdata['patient_info']['id']);
            if(is_array($tooth_info) && count($tooth_info) > 0)
            {
                $tooth_child_info = $tooth_info;
            if(isset($tooth_child_info) && is_array($tooth_child_info) && count($tooth_child_info) > 0)
            {
                

        ?>
                
                <div class="bg_table" style="height:550px; padding:15px;">
                <h3 style="color:#069;">My Tooth</h3>
                <input type="hidden" value="<?php echo $this->session->userdata['patient_info']['id'];?>" id="patient_id">
                

                <div class="droppable tooth_prof" id="droppable2">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 55 </div>
                <p id="55" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['55']?></p>
                </div>

                <div class="droppable tooth_prof" id="droppable2">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 54 </div>
                <p id="54" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['54']?></p>
                </div>

                <div class="droppable tooth_prof" id="droppable3">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 53 </div>
                <p id="53" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['53']?></p>
                </div>

                <div class="droppable tooth_prof" id="droppable4">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 52 </div>
                <p id="52" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['52']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 51 </div>
                <p id="51" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['51']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 61 </div>
                <p id="61" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['61']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 62 </div>
                <p id="62" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['62']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 63 </div>
                <p id="63" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['63']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 64 </div>
                <p id="64" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['64']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 65 </div>
                <p id="65" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['65']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 85 </div>
                <p id="85" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['85']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 84 </div>
                <p id="84" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['84']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 83 </div>
                <p id="83" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['83']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 82 </div>
                <p id="82" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['82']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 81 </div>
                <p id="81" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['81']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 71 </div>
                <p id="71" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['71']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 72 </div>
                <p id="72" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['72']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 73 </div>
                <p id="73" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['73']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 74 </div>
                <p id="74" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['74']?></p>
                </div>

                <div class="droppable tooth_prof">
                <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 75 </div>
                <p id="75" style="background:#FBFBFB; height:15px;"><?php echo $tooth_child_info['75']?></p>
                </div>
                
                <?php
            }
            
            else
            {
                echo "You have not a record yet.";
            }
        }
        
    }
    else
    {
        $tooth_info = $this->tooth_adult_model->get_tooth_adult_by_patient_id($this->session->userdata['patient_info']['id']);
    
        if(is_array($tooth_info) && count($tooth_info) > 0)
        {
            $tooth_adult_info = $tooth_info;
            if(isset($tooth_adult_info) && is_array($tooth_adult_info) && count($tooth_adult_info) > 0)
    {
        
?>
  </div>              
        <input type="hidden" value="<?php echo $this->session->userdata['patient_info']['id'];?>" id="patient_id">
        
       
        <div class="bg_table" style="height:550px; padding:15px;">
        <h3 style="color:#069;">My Tooth</h3>
        
        <div class="droppable tooth_prof" id="droppable2">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 18 </div>
        <p id="18" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['18']?></p>
        </div>
        
        <div class="droppable tooth_prof" id="droppable2">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 17 </div>
        <p id="17" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['17']?></p>
        </div>

        <div class="droppable tooth_prof" id="droppable3">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 16 </div>
        <p id="16" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['16']?></p>
        </div>

        <div class="droppable tooth_prof" id="droppable4">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 15 </div>
        <p id="15" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['15']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 14 </div>
        <p id="14" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['14']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 13 </div>
        <p id="13" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['13']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 12 </div>
        <p id="12" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['12']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 11 </div>
        <p id="11" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['11']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 21 </div>
        <p id="21" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['21']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 22 </div>
        <p id="22" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['22']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 23 </div>
        <p id="23" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['23']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 24 </div>
        <p id="24" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['24']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 25 </div>
        <p id="25" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['25']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 26 </div>
        <p id="26" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['26']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 27 </div>
        <p id="27" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['27']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 28 </div>
        <p id="28" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['28']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 48 </div>
        <p id="48" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['48']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 47 </div>
        <p id="47" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['47']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 46 </div>
        <p id="46" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['46']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 45 </div>
        <p id="45" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['45']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 44 </div>
        <p id="44" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['44']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 43 </div>
        <p id="43" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['43']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 42 </div>
        <p id="42" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['42']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 41 </div>
        <p id="41" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['41']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 31 </div>
        <p id="31" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['31']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 32 </div>
        <p id="32" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['32']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 33 </div>
        <p id="33" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['33']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 34 </div>
        <p id="34" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['34']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 35 </div>
        <p id="35" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['35']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 36 </div>
        <p id="36" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['36']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 37 </div>
        <p id="37" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['37']?></p>
        </div>

        <div class="droppable tooth_prof">
        <div style="background-color: #CEFFFF; width: auto; font-size:14px; font-weight:bold; border-bottom:1px solid #ccc;"> Tooth 38 </div>
        <p id="38" style="background:#FBFBFB; height:15px;"><?php echo $tooth_adult_info['38']?></p>
        </div>
        </div>
        
                <?php
        }
    }
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
    
    function send_query()
    {
        $patient_id = $this->input->post('patient_id');
        $patient_info = $this->patient_model->get_patient_by_id($patient_id);
        if(is_array($patient_info) && count($patient_info) > 0)
        {
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));  
            $time = $local_time;
            $date = date("Y-m-d");
            $customer_care_info = array(
                'date' => $date,
                'time' => $time,
                'patient_id' => $patient_info['id'],
                'query' => $this->input->post('query'),
                'about' => $this->input->post('about')
                
            );
            $confirm = $this->customer_care_model->insert($customer_care_info);
            if($confirm)
            {
                echo "Successfully sent your queries to the administrator. You will be then notified through your email";
            }
            else
            {
                echo "Something went wrong. Please do send it again";
            }
        }
        else
        {
            echo "Was not able to retrieve your data";
        }
    }
    
    function reservation_cancel()
    {
        $reservation_id = $this->input->post('reservation_id');
        $reservation_info = $this->reservation_model->get_reservation($reservation_id);
        if(is_array($reservation_info) && count($reservation_info) > 0)
        {
            $kind = $this->session->userdata['patient_info']['gender'];
            if($kind == "Male")
            {
                $gender = "his";
            }
            else
            {
                $gender = "her";
            }
            $reservation_info['status'] = "INACTIVE";
            $confirm = $this->reservation_model->update($reservation_info);
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
                 
                 $notification_info = array(
                      'from' => 'patient',
                      'to' => 'doctor',
                      'from_id' => $reservation_info['patient_id'],
                      'to_id' => $reservation_info['doctor_id'],
                      'about' => 'Reservation',
                      'msg' => 'Patient '.$this->session->userdata['patient_info']['first_name']." ".$this->session->userdata['patient_info']['last_name'].' has cancelled '.$gender.' reservation on time '.$real_time.','.date_format(new DateTime($reservation_before['date']),"F d Y").'.',
                      'time' => $local_time,
                      'date' => $local_date,
                      'status' => "ACTIVE",
                     
                  );
                 $this->notification_model->insert($notification_info);
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
    
    function notification_send_personal_message()
    {
        $doctor_info = $this->doctor_model->get_doctor_by_id($this->input->post('to_id'));
        if(is_array($doctor_info) && count($doctor_info) > 0)
        {
            $time = now();  
            $timezone = 'UM4';  
            $daylight_saving = TRUE; // or FALSE  
            $local_time = date("H:i:s",(gmt_to_local($time, $timezone, $daylight_saving)));
            $local_date = date("Y-m-d",(gmt_to_local($time, $timezone, $daylight_saving)));
            
            $notification_info = array(
                  'from' => 'patient',
                  'to' => 'doctor',
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
            echo "Was not able to retrieve info from doctor";
        }
       
    }
    
    function notification_update()
    {
        $notification_id = $this->input->post('notification_id');
        $notification_info = $this->notification_model->get_notification_by_id($notification_id);
        if(is_array($notification_info) && count($notification_info) > 0)
        {
            $notification_info['status'] = "INACTIVE";
            $confirm = $this->notification_model->update($notification_info);
            if($confirm)
            {
                echo "Successfully updated";
            }
            else
            {
                echo "Something went wrong during the update";
            }
        }
        else
        {
            echo "Was not able to retrieve the notification info";
        }
    }
    
    
    function faq()
    {
        $this->load->model('faq_model');
        $faq_info = $this->faq_model->get_all_active();
        $data['faq_info'] = $faq_info;
        if(is_array($faq_info) && count($faq_info) > 0)
        {
            $this->load->view('header');
            $this->load->view('faq',$data);
            if(!isset($this->session->userdata['patient_info']['id']))
            {
                $this->load->view('forms');
                        
            }
            $this->load->view('footer');
        }
        else
        {
            echo "Was not able to retrieve faq";
        }
    }
    
    function forgot_password()
    {
        $email_add = $this->input->post('email_add');
        $patient_info = $this->patient_model->get_patient_by_email($email_add);
        if(is_array($patient_info) && count($patient_info) > 0)
        {
            
            $patient_info['photo_info'] = $this->photo_model->get_photo('patient',$patient_info['id']);
            if(is_array($patient_info['photo_info']) && count($patient_info['photo_info']) > 0)
            {
            ?>
                    Are you <a style="cursor: pointer; text-decoration: none" id="yes_i_am"><?php echo $patient_info['first_name']." ".$patient_info['last_name'] ;?></a>?<br/>
                    <img src="<?php echo base_url().$patient_info['photo_info']['source']?>" style="width: 40px; height: 40px"><br/>
                    <input type="hidden" id="mobile_number_hidden" value="<?php echo $patient_info['mobile_number']?>">
                    <div id="confirmed" style="display : none">
                        <input type="button" id="forgot_password_confirmed_email_add_and_mobile_number" value="Send to my mail">
                    </div>
                    <script>
                        $('#forgot_password_mobile_number').live('change',function(){
                            var mobile_number = $(this).val().trim();
                            var mobile_number_hidden = $("#mobile_number_hidden").val().trim();
                            if(mobile_number == mobile_number_hidden){
                                $('#confirmed').show('slow');
                            }
                        })
                    </script>
                    <script>
                        
                        $('#forgot_password_confirmed_email_add_and_mobile_number').click(function(){
                            var form_data = {
                                email_add : $("#forgot_password_email_add").val().trim()
                        }

                        $.ajax({
                            url : "<?php echo base_url()?>patient/send_forgot_password",
                            type: "POST",
                            data : form_data,
                            success : function(msg){
                                //$('#patient_profile').html(msg);
                                noty({type:"notification",text:msg});
                            }
                        })
                        })
                    </script>
            <?php
            }
        }
    }
    
    function send_forgot_password()
    {
        $email_add = $this->input->post('email_add');
        $patient_info = $this->patient_model->get_patient_by_email($email_add);
        if(is_array($patient_info) && count($patient_info) > 0)
        {
            
            $this->load->library('email');
            //for configuration of email head to ci_day3/application/config/email.php

            $this->email->from('captainbuggythefifth@gmail.com', 'Gaudencio Teves');
            $this->email->to($email_add);
            $this->email->subject('Your forgotten password');
            $this->email->message('It is our pleasure to serve you well. Here is your forgotten password in your account '.$patient_info['password']);
            if(@$this->email->send())
            {
                echo 'Your email has been sent to you. Please do visit your email address. Thank you!';
            }
            else
            {
                echo 'Was not able to send to your mail. Please try again. It might be due to your slow internet connection';
            }
            
        }
    }
    
    function doctor_loader()
    {
        if(isset($this->session->userdata['patient_info']['reservation_info']['specified_service']))
        {
            
            $specified_service = $this->session->userdata['patient_info']['reservation_info']['specified_service'];
        }
        else
        {
            $specified_service = "";
        }
        $doctor_id = $this->input->post('doctor_id');
        if (isset($this->session->userdata['patient_info']['reservation_info']['id'])) 
        {
             $doctor_id = $this->session->userdata['patient_info']['reservation_info']['doctor_id'];
        }
        //echo $doctor_id;
        $doctors = $this->doctor_model->get_all();
        if(is_array($doctors) && count($doctors) > 0)
        {
            $new = array();
            $i = 0;
            foreach($doctors as $doctor)
            {
                $system_infos = $this->system_model->get_date($this->input->post('date'));
                //print_r($system_info);
                if(is_array($system_infos) && count($system_infos) > 0)
                {
                    foreach($system_infos as $system_info)
                    {
                        if($doctor['id'] == $system_info['doctor_id'])
                        {
                            if($system_info['time_in'] < 20)
                            {
                                $new[$i] = $doctor;
                                $i++;
                            }
                        }
                        else
                        {
                            $new[$i] = $doctor;
                            $i++;
                        }
                    }
                }
                else
                {
                    $new[$i] = $doctor;
                    $i++;
                }
            }
            
            $doctors = $new;
        }
        
        ?>
                    Select Doctor: <select id="doctor_id" name="doctor_id" title="Click me to Select Doctor">
                                    <?php foreach ($doctors as $doctor) { ?>
                                                        <option value="<?php echo $doctor['id'] ?>" <?php
                            
                                if($doctor_id == $doctor['id'])
                                {
                                    echo "selected";
                                }
                           
                            ?>>
            <?php echo $doctor['first_name'] . " " . $doctor['last_name'] ?>
                                                        </option>
        <?php } ?>      
                                                </select>

        
    
                                    
                                    Not available? Please specify: <input type="text" id="specified_service" value="<?php echo $specified_service?>">
                                    <div align="left" id="doctor_expertise" style="width: 300"></div>


        <?php
        }
    
}
?>