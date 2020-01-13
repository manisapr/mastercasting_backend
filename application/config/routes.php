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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'Master_controllers';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//member routes
$route['member_details/(:any)'] = 'Master_controllers/member_details/$1';

//mastercontroller
$route['dashboard'] = 'Master_controllers/dashboard';



//projects
$route['projects'] = 'Project_controller';
$route['projects/all_projects'] = 'Project_controller/all_projects';
$route['projects/complete_projects'] = 'Project_controller/complete_projects';
$route['projects/proposal_projects'] = 'Project_controller/proposal_projects';
$route['projects/cancel_projects'] = 'Project_controller/cancel_projects';
$route['projects/live_projects'] = 'Project_controller/live_projects';
$route['projects/add_project'] = 'Project_controller/add_project';
$route['projects/add_project/(:any)'] = 'Project_controller/add_project/$1';
$route['projects/test'] = 'Project_controller/test';
$route['projects/add_project_action'] = 'Project_controller/add_project_action';
$route['projects/update_project/(:num)'] = 'Project_controller/update_project/$1';
$route['projects/project_details/(:num)'] = 'Project_controller/project_details/$1';
$route['projects/update_project_type/(:any)/(:num)'] = 'Project_controller/update_project_type/$1/$2';
$route['project/approve_estimate/(:num)'] = 'Project_controller/approve_estimate/$1';
$route['projects/estimated_projects'] = 'Project_controller/all_estimated_projects';
$route['projects/shipping_list'] = 'Project_controller/get_all_shipping_list';
$route['projects/api_projects'] = 'Project_controller/api_injected_projects';
$route['projects/due_projects'] = 'Project_controller/due_projects';





//user
$route['edit_profile'] = 'Master_controllers/edit_profile';
$route['create/trade'] = 'User_controller/create_trade';
$route['details/trade/(:num)'] = 'User_controller/trade_client_details/$1';
$route['edit/trade/(:num)'] = 'User_controller/edit_trade_client/$1';
$route['trade_clients'] = 'User_controller/trade_clients';
$route['all_team_members'] = 'Master_controllers/all_team_members';
$route['all_manager'] = 'Master_controllers/all_manager';
$route['all_sales_rep'] = 'Master_controllers/all_sales_rep';
$route['all_cad'] = 'Master_controllers/all_cad';
$route['create/associate'] = 'User_controller/create_associate';


//retailer
$route['create/retailer'] = 'User_controller/create_retailer';
$route['details/retailer/(:num)'] = 'User_controller/retailer_client_details/$1';
$route['edit/retailer/(:num)'] = 'User_controller/edit_retailer_client/$1';
$route['retail_clients'] = 'User_controller/retail_clients';
$route['company_list'] = 'User_controller/company_list';
$route['get_user_by_company/(:any)'] = 'User_controller/get_user_by_company/$1';
$route['resend_cred/(:any)/(:any)'] = 'User_controller/resend_cred/$1/$2';
$route['cad_slots/(:any)'] = 'User_controller/cad_slots/$1';
$route['view_associates'] = 'User_controller/view_associates';


$route['view_dispositions'] = 'Project_controller/view_dispositions';

//message
$route['get_messages'] = 'Message_controller/get_messages';

