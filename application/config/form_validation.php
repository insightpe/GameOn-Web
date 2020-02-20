<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$config = [
    'signin' => [
        [
            'field' => 'user_email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|required|min_length[6]|max_length[255]'
        ],
        [
            'field' => 'user_pass',
            'label' => 'Contraseña',
            'rules' => 'trim|required|min_length[8]|max_length[32]'
        ]
    ],
    'signup' => [
        [
            'field' => 'user_email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|valid_email|required|min_length[8]|max_length[255]|is_unique[users.user_email]'
        ],
        [
            'field' => 'user_pass',
            'label' => 'Contraseña',
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[user_confirm_pass]|check_password_strength'
        ],
        [
            'field' => 'user_confirm_pass',
            'label' => 'Confirma Contraseña',
            'rules' => 'required'
        ],
        [
            'field' => 'user_name',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ],
        [
            'field' => 'user_captcha',
            'label' => 'Captcha',
            'rules' => 'trim|alpha_numeric|required|validate_captcha'
        ],
    ],
    'update_pass_user' => [
        [
            'field' => 'user_pass',
            'label' => 'Contraseña',
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[user_confirm_pass]|check_password_strength'
        ],
        [
            'field' => 'user_confirm_pass',
            'label' => 'Confirma Contraseña',
            'rules' => 'required'
        ],
    ],
    'new_user' => [
        [
            'field' => 'user_email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|valid_email|required|min_length[8]|max_length[255]|custom_is_unique[users.user_email||id||0||||Correo Electronico]'
        ],
        [
            'field' => 'user_pass',
            'label' => 'Contraseña',
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[user_confirm_pass]|check_password_strength'
        ],
        [
            'field' => 'user_confirm_pass',
            'label' => 'Confirma Contraseña',
            'rules' => 'required'
        ],
        [
            'field' => 'user_name',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ]
    ],
    'new_user2' => [
        [
            'field' => 'user_email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|valid_email|required|min_length[8]|max_length[255]|is_unique[users.user_email]'
        ],
        [
            'field' => 'user_name',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ]
    ],
    'update_config' => [
        [
            'field' => 'application_name',
            'label' => 'Nombre de Aplicación',
            'rules' => 'required|min_length[2]|max_length[200]'
        ],
        [
            'field' => 'author',
            'label' => 'Autor',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        [
            'field' => 'mail_server',
            'label' => 'Servidor de Correo',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        [
            'field' => 'file_system_server',
            'label' => 'Servidor de Almacenamiento de Archivos',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        [
            'field' => 'database_server',
            'label' => 'Servidor de Base de Datos',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        [
            'field' => 'company_name',
            'label' => 'Nombre de Empresa',
            'rules' => 'required|min_length[2]|max_length[200]'
        ],
        [
            'field' => 'company_address',
            'label' => 'Dirección de Empresa',
            'rules' => 'required|min_length[2]|max_length[200]'
        ],
        [
            'field' => 'main_person',
            'label' => 'Persona Encargada',
            'rules' => 'required|min_length[2]|max_length[200]'
        ]
    ],
    'update_user' => [
        [
            'field' => 'user_name',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ]
    ],
    'update_profile' => [
        [
            'field' => 'user_name',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ]
    ],
    'valida_contact' => [
        [
            'field' => 'captcha',
            'label' => 'Captcha',
            'rules' => 'trim|alpha_numeric|required|validate_captcha'
        ]
    ],
    'add_role' => [
        [
            'field' => 'rol_name',
            'label' => 'Nombre de rol',
            'rules' => 'required|min_length[4]|max_length[99]|is_unique[roles.role]'
        ]
    ],
    'update_role' => [
        [
            'field' => 'rol_name',
            'label' => 'Nombre de rol',
            'rules' => 'required|min_length[4]|max_length[99]|custom_is_unique[roles.role||role_id||id||||Nombre de rol]]'
        ]
    ],
    'add_permissions' => [
        [
            'field' => 'permissions_name',
            'label' => 'Nombre del permiso',
            'rules' => 'required|min_length[4]|max_length[99]'
        ],
        [
            'field' => 'permissions_key',
            'label' => 'Llave del permiso',
            'rules' => 'required|min_length[4]|max_length[50]'
        ]
    ],
    
    'add_config' => [
        [
            'field' => 'config_name',
            'label' => 'Nombre de la Configuración',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        [
            'field' => 'config_setting',
            'label' => 'Configuracion',
            'rules' => 'required'
        ],
    ],
];
