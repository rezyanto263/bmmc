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
$route['default_controller'] = 'Home';
$route['404_override'] = 'Errors/error404';
$route['translate_uri_dashes'] = FALSE;

/* 
| -------------------------------------------------------------------------
| PAGE ROUTES
| -------------------------------------------------------------------------
*/

// User
$route['login'] = 'AuthUser';
$route['logout'] = 'AuthUser/logoutUser';
$route['forgotpassword'] = 'AuthUser/forgotPasswordPage';
$route['resetpassword'] = 'AuthUser/resetPasswordPage';
$route['home'] = 'Home';
$route['partners'] = 'user/Partners';
$route['news'] = 'user/News';
$route['about'] = 'user/About';
$route['profile'] = 'user/Profile';

// Dashboard
$route['dashboard'] = 'dashboard/dashboard';
$route['dashboard/login'] = 'AuthDashboard';
$route['dashboard/logout'] = 'AuthDashboard/logoutDashboard';
$route['dashboard/forgotpassword'] = 'AuthDashboard/forgotPasswordPage';
$route['dashboard/resetpassword'] = 'AuthDashboard/resetPasswordPage';



/* 
| -------------------------------------------------------------------------
| Get Datas with AJAX 
| -------------------------------------------------------------------------
*/

// Dashboard
$route['dashboard/getPatientByNIK'] = 'dashboard/Dashboard/scanQR';
$route['dashboard/getAllAdminsDatas'] = 'dashboard/Admins/getAllAdminsDatas';
$route['dashboard/getAllUnconnectedHospitalAdminsDatas'] = 'dashboard/Admins/getAllUnconnectedHospitalAdminsDatas';
$route['dashboard/getAllUnconnectedCompanyAdminsDatas'] = 'dashboard/Admins/getAllUnconnectedCompanyAdminsDatas';
$route['dashboard/getAllDiseasesDatas'] = 'dashboard/Diseases/getAllDiseasesDatas';
$route['dashboard/getCompanyDiseases'] = 'dashboard/Diseases/getCompanyDiseases';
$route['dashboard/getAllHospitalsDatas'] = 'dashboard/Hospitals/getAllHospitalsDatas';
$route['dashboard/getHospitalDetailsByHospitalId'] = 'dashboard/Hospitals/getHospitalDetailsByHospitalId';
$route['dashboard/getAllCompaniesDatas'] = 'dashboard/Companies/getAllCompaniesDatas';
$route['dashboard/getCompanyDetails'] = 'dashboard/Companies/getCompanyDetails';
$route['dashboard/getAllCompanyInvoiceDatas'] = 'dashboard/Invoices/getAllCompanyInvoiceDatas';
$route['dashboard/getDepartmentAllocationBillsByBillingId'] = 'dashboard/Invoices/getDepartmentAllocationBillsByBillingId';
$route['dashboard/createInvoice'] = 'dashboard/Invoices/createInvoice';
$route['dashboard/markInvoicesAsPaid'] = 'dashboard/Invoices/markInvoicesAsPaid';
$route['dashboard/markInvoiceAsUnpaid'] = 'dashboard/Invoices/markInvoiceAsUnpaid';
$route['dashboard/getPatientHealthHistoryDetailsByNIK'] = 'dashboard/HealthHistories/getPatientHealthHistoryDetailsByNIK';
$route['dashboard/getAllHealthHistoriesDatas'] = 'dashboard/HealthHistories/getAllHealthHistoriesDatas';
$route['dashboard/getAllHealthHistoriesByBillingId'] = 'dashboard/HealthHistories/getAllHealthHistoriesByBillingId';
$route['dashboard/getAllPatientsData'] = 'dashboard/HealthHistories/getAllPatientsData';
$route['dashboard/getAllDoctorsByHospitalId'] = 'dashboard/HealthHistories/getAllDoctorsByHospitalId';
$route['dashboard/getAllDoctors'] = 'dashboard/Doctors/getAllDoctors';
$route['dashboard/getAllDoctorSpecialization'] = 'dashboard/Doctors/getAllDoctorSpecialization';
$route['dashboard/getAllNews'] = 'dashboard/News/getAllNews';
$route['dashboard/getAllNewsTags'] = 'dashboard/News/getAllNewsTags';
$route['dashboard/getAllNewsTypes'] = 'dashboard/News/getAllNewsTypes';

// Company
$route['company/getPatientByNIK'] = 'company/Dashboard/scanQR';
$route['company/getAllInsuranceByCompanyId'] = 'company/Insurance/getAllInsuranceByCompanyId';
$route['company/getAllEmployeesByCompanyId'] = 'company/Employees/getAllEmployeesByCompanyId';
$route['company/getInsuranceDetailsByEmployeeNIK'] = 'company/Employees/getInsuranceDetailsByEmployeeNIK';
$route['company/getAllDepartmentByCompanyId'] = 'company/Employees/getAllDepartmentByCompanyId';
$route['company/getAllBandByCompanyId'] = 'company/Employees/getAllBandByCompanyId';
$route['company/getAllFamilyDatas'] = 'company/Families/getAllFamilyDatas';
$route['company/getFamiliesByEmployeeNIK'] = 'company/Families/getFamiliesByEmployeeNIK';
$route['company/getAllHealthHistoriesByCompanyId'] = 'company/HealthHistories/getAllHealthHistoriesByCompanyId';
$route['company/getAllHealthHistoriesByBillingId'] = 'company/HealthHistories/getAllHealthHistoriesByBillingId';
$route['company/getPatientHealthHistoryDetailsByNIK'] = 'company/HealthHistories/getPatientHealthHistoryDetailsByNIK';
$route['company/getAllInvoicesByCompanyId'] = 'company/Invoices/getAllInvoicesByCompanyId';
$route['company/getDepartmentAllocationBillsByBillingId'] = 'company/Invoices/getDepartmentAllocationBillsByBillingId';
$route['company/getCompanyDiseases'] = 'company/Diseases/getCompanyDiseases';

// Hospital
$route['hospital/getPatientByNIK'] = 'hospital/Dashboard/scanQR';
$route['hospital/getHospitalQueueDatas'] = 'hospital/Queues/getHospitalQueueDatas';
$route['hospital/getQueuedPatientByNIK'] = 'hospital/Queues/getQueuedPatientByNIK';
$route['hospital/getQueuedPatientDetails'] = 'hospital/Queues/getQueuedPatientDetails';
$route['hospital/getAllHospitalsDatas'] = 'hospital/Queues/getAllHospitalsDatas';
$route['hospital/getAllDoctorsByHospitalId'] = 'hospital/Doctors/getAllDoctorsByHospitalId';
$route['hospital/getAllDoctorSpecialization'] = 'hospital/Doctors/getAllDoctorSpecialization';
$route['hospital/getAllHealthHistoriesByHospitalId'] = 'hospital/HealthHistories/getAllHealthHistoriesByHospitalId';
$route['hospital/getPatientHealthHistoryDetailsByNIK'] = 'hospital/HealthHistories/getPatientHealthHistoryDetailsByNIK';
$route['hospital/getDiseaseDatas'] = 'hospital/Disease/getDiseaseDatas';
$route['hospital/getCompanyDiseases'] = 'hospital/Diseases/getCompanyDiseases';

// User
$route['user/getAllActivePartnersMapData'] = 'user/Partners/getAllActivePartnersMapData';
$route['user/getAllPublishedNewsWithoutContent'] = 'user/News/getAllPublishedNewsWithoutContent';
$route['user/getAllInsuranceMembersHealhtHistoriesByUserNIK'] = 'user/Profile/getAllInsuranceMembersHealhtHistoriesByUserNIK';