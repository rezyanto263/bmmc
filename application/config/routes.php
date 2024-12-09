<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'AuthUser';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// User
$route['home'] = 'user/LandingToo';
$route['login'] = 'AuthUser';
$route['logout'] = 'AuthUser/logout';

// Dashboard
$route['dashboard'] = 'dashboard/dashboard';
$route['dashboard/login'] = 'AuthDashboard';
$route['dashboard/logout'] = 'AuthDashboard/logoutDashboard';
$route['dashboard/forgotpassword'] = 'AuthDashboard/forgotPasswordPage';
$route['dashboard/resetpassword'] = 'AuthDashboard/resetPasswordPage';
$route['dashboard/admins'] = 'dashboard/admins';

// Get Datas with AJAX
$route['dashboard/getAllAdminsDatas'] = 'dashboard/Admins/getAllAdminsDatas';
$route['dashboard/getAllUnconnectedHospitalAdminsDatas'] = 'dashboard/Admins/getAllUnconnectedHospitalAdminsDatas';
$route['dashboard/getAllUnconnectedCompanyAdminsDatas'] = 'dashboard/Admins/getAllUnconnectedCompanyAdminsDatas';
$route['dashboard/getAllHospitalsDatas'] = 'dashboard/Hospitals/getAllHospitalsDatas';
$route['dashboard/getAllCompaniesDatas'] = 'dashboard/Companies/getAllCompaniesDatas';
$route['hospitals/getHospitalDoctorsDatas'] = 'hospitals/Doctors/getHospitalDoctorsDatas';
$route['hospitals/getHospitalHistoriesDatas'] = 'hospitals/Histories/getHospitalHistoriesDatas';
$route['company/Employee/getAllEmployeesDatas'] = 'company/Employee/getAllEmployeesDatas';
$route['company/Family/getAllFamilyDatas'] = 'company/Family/getAllFamilyDatas';
$route['company/Family/getFamiliesByPolicyholderNIN'] = 'company/Family/getFamiliesByPolicyholderNIN';

// Route baru untuk tampilan profil pengguna
$route['profile'] = 'user/User';
$route['user/editEmployee'] = 'user/User/editEmployee';
$route['user/editFamily'] = 'user/User/editFamily';
$route['company/dashboard'] = 'company/dashboard';
$route['landing'] = 'user/landing/Landing';

// Hospital
$route['hospitals/doctors'] = 'hospitals/doctors';
$route['hospitals/hHistories'] = 'hospitals/hHistories';
$route['company/dashboard/editCompany'] = 'company/dashboard/editCompany';
