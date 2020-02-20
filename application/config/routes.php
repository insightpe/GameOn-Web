<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//ayuda
$route['ayuda'] = 'Ayuda';
//home
$route['inicio-sesion'] = "auth/form_signin";
//$route['registro-usuario'] = "auth/form_signup";
$route['recuperar-contrasena'] = "auth/form_lost_pass";
$route['envio-contrasena'] = "auth/send_lost_pass";

//dash configuraciones
$route['editar-configuraciones'] = "configuraciones/form_edit_config";
$route['actualizar-configuraciones'] = "configuraciones/update_config";
$route['cambiar-tema'] = "configuraciones/cambiar_tema";

//Auth
$route['signin'] = "auth/signin";
$route['signup'] = "auth/signup";
$route['signout'] = "auth/signout";
$route['verification/(:any)'] = "auth/code_verification/$1";
$route['envio-contrasena'] = "auth/send_lost_pass";

//dash roles
$route['listar-roles'] = "roles/list_roles";
$route['get-list-roles'] = "roles/get_list_roles";
$route['nuevo-rol'] = "roles/form_new_role";
$route['agregar-rol'] = "roles/add_role";
$route['permisos-rol/(:num)'] = "rolepermissions/role_permissions/$1";
$route['editar-rol/(:num)'] = "roles/form_edit_role/$1";
$route['actualizar-rol'] = "roles/update_role";
$route['eliminar-rol/(:num)'] = "roles/delete_role";
$route['obtener-rol'] = "roles/get_role";
//dash role permissions
$route['actualizar-permisos-rol/(:num)'] = "rolepermissions/update_role_permissions/$1";


//dash permissions
$route['agregar-permiso'] = "permissions/add_permissions";
$route['nuevo-permiso'] = "permissions/form_new_permissions";
$route['listar-permiso'] = "permissions/list_permissions";
$route['get-list-permissions'] = "permissions/get_list_permissions";
$route['editar-permisos/(:num)'] = "permissions/form_edit_permission/$1";
$route['actualizar-permiso'] = "permissions/update_permission";
$route['eliminar-permisos/(:num)'] = "permissions/delete_permission/$1";

//dash users
$route['listar-usuarios'] = "users/list_users";
$route['get-list-users'] = "users/get_list_users";
$route['nuevo-usuario'] = "users/form_new_user";
$route['editar-usuario/(:num)'] = "users/form_edit_user/$1";
$route['actualizar-usuario'] = "users/update_user";
$route['cambiar-pass/(:num)'] = "users/form_change_pass/$1";
$route['actualizar-pass'] = "users/update_pass";
$route['eliminar-usuario/(:num)'] = "users/delete_user/$1";
$route['perfil'] = "users/form_user_profile";
$route['actualizar-perfil'] = "users/update_user_profile";
$route['actualizar-pass-perfil'] = "users/update_pass_user_profile";
$route['agregar-usuario'] = "users/add_user";

//dash users permissions
$route['permisos-usuario/(:num)'] = "userpermissions/user_permissions/$1";
$route['actualizar-permisos-usuario/(:num)'] = "userpermissions/update_user_permissions/$1";