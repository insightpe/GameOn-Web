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


//dash deportes
$route['listar-deportes'] = "deportes/list_deportes";
$route['get-list-deportes'] = "deportes/get_list_deportes";
$route['nuevo-deporte'] = "deportes/form_new_deporte";
$route['agregar-deporte'] = "deportes/add_deporte";
$route['editar-deporte/(:num)'] = "deportes/form_edit_deporte/$1";
$route['actualizar-deporte'] = "deportes/update_deporte";
$route['eliminar-deporte/(:num)'] = "deportes/delete_deporte";
$route['obtener-deporte'] = "deportes/get_deporte";

//dash promociones
$route['listar-promociones'] = "promociones/list_promociones";
$route['get-list-promociones'] = "promociones/get_list_promociones";
$route['nuevo-promocion'] = "promociones/form_new_promocion";
$route['agregar-promocion'] = "promociones/add_promocion";
$route['editar-promocion/(:num)'] = "promociones/form_edit_promocion/$1";
$route['actualizar-promocion'] = "promociones/update_promocion";
$route['eliminar-promocion/(:num)'] = "promociones/delete_promocion";
$route['obtener-promocion'] = "promociones/get_promocion";

//dash campos
$route['listar-campos'] = "campos/list_campos";
$route['get-list-campos'] = "campos/get_list_campos";
$route['nuevo-campo'] = "campos/form_new_campo";
$route['agregar-campo'] = "campos/add_campo";
$route['editar-campo/(:num)'] = "campos/form_edit_campo/$1";
$route['actualizar-campo'] = "campos/update_campo";
$route['eliminar-campo/(:num)'] = "campos/delete_campo";
$route['obtener-campo'] = "campos/get_campo";
$route['get-list-detallefotos'] = "campos/get_list_detallefotos";
$route['agregar-campoimagen'] = "campos/add_campo_imagen";
$route['actualizar-campoimagen'] = "campos/update_campo_imagen";
$route['editar-campoimagen/(:num)'] = "campos/edit_campo_imagen/$1";
$route['eliminar-campoimagen/(:num)'] = "campos/delete_campo_imagen/$1";
$route['get-by-pronvincias'] = "campos/get_by_provincias";
$route['get-by-distritos'] = "campos/get_by_distritos";

//dash camposcanchas
$route['listar-campocanchas'] = "campocanchas/list_campocanchas";
$route['get-list-campocanchas'] = "campocanchas/get_list_campocanchas";
$route['nuevo-campocancha'] = "campocanchas/form_new_campocancha";
$route['agregar-campocancha'] = "campocanchas/add_campocancha";
$route['editar-campocancha/(:num)'] = "campocanchas/form_edit_campocancha/$1";
$route['actualizar-campocancha'] = "campocanchas/update_campocancha";
$route['eliminar-campocancha/(:num)'] = "campocanchas/delete_campocancha";
$route['obtener-campocancha'] = "campocanchas/get_campocancha";

//dash canchas reservadas
$route['get-list-canchas'] = "canchareservada/get_list_campo_canchas";
$route['canchareservada-get-list-deportes'] = "canchareservada/get_list_deportes";
$route['listar-canchareservada'] = "canchareservada/list_canchareservada";
$route['get-list-canchareservada'] = "canchareservada/get_list_canchareservada";