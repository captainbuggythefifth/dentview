<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['default_controller'] = "welcome";
//$route['404_override'] = '';
//$route['default_controller'] = "home";


// patient
$route['time'] = "doctor/time";

$route['default_controller'] = "patient";
$route['patient-sign-up'] = "patient/sign_up";
$route['patient-log-in'] = "patient/log_in";
$route['patient-log-in-validate'] = "patient/log_in_validate";
$route['patient-log-out'] = "patient/log_out";

$route['patient-reservation'] = "patient/reservation";
$route['patient-reservation-validate'] = "patient/reservation_validate";
$route['patient-profile'] = "patient/profile";
$route['patient-upload'] = "patient/upload";

// admin
$route['patient-all/(:any)/(:any)'] = "patient/all_patients/$1/$2";
$route['patient-all/(:any)'] = "patient/all_patients/$1/";
$route['patient-all'] = "patient/all_patients";
$route['patient-services/(:any)'] = "patient/services/$1";
$route['patient-services'] = "patient/services";
$route['patient-load-reservation-page'] = "patient/load_reservation_page";
$route['patient-reschedule'] = "patient/reschedule";
$route['patient-view-doctor-profile/(:any)'] = "patient/view_doctor_profile/$1";
$route['patient-view-all-doctors'] = "patient/view_all_doctors";
$route['patient-account-confirmation'] = "patient/account_confirmation";


$route['administer'] = 'admin/administer';
$route['administer/(:any)'] = 'admin/administer/$1';
$route['administer/(:any)/(:any)'] = 'admin/administer/$1/$2';


$route['administer-upload'] = 'admin/upload';
$route['administer-do-upload'] = 'admin/do_upload';
//$route['administer-upload-(:any)'] = 'admin/upload/$1';
$route['administer-upload-(:any)/(:any)'] = 'admin/upload/$1/$2';
$route['admin-get-all-photos-from-(:any)-id-(:any)'] = 'admin/get_all_photos/$1/$2';
$route['admin-log-in-validate'] = 'admin/log_in_validate';
$route['administer-log-out'] = 'admin/log_out';
$route['administer-log-(:any)'] = 'admin/log_on_/$1';
$route['administer-all-patients'] = 'admin/view_patients';
$route['administer-patient-edit'] = 'admin/patient_edit';


$route['doctor-profile'] = "doctor/profile";
$route['doctor-reservation-of-date'] = "doctor/reservation_of_date";
$route['doctor-reservation-of-date-and-time'] = "doctor/reservation_of_date_and_time";
//email
$route['email-send'] = 'email/send';

$route['doctor'] = "doctor/log_in";
$route['faq'] = "patient/faq";
$route['secretary'] = "secretary/home";
$route['secret/(:any)'] = "secretary/secret/$1";

$route['secretary-log_in_validate'] = "secretary/log_in_validate";

/* End of file routes.php */
/* Location: ./application/config/routes.php */