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
    'signin_api' => [
        [
            'field' => 'usuario',
            'label' => 'Correo Electronico',
            'rules' => 'trim|required|min_length[6]|max_length[255]'
        ],
        [
            'field' => 'contraseña',
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
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[user_confirm_pass]'
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
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[user_confirm_pass]'
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
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[user_confirm_pass]'
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
    'actualizar_user_api' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ],
        [
            'field' => 'apellido',
            'label' => 'Apellido',
            'rules' => 'required|min_length[2]|max_length[90]'
        ],
        [
            'field' => 'nombre_usuario',
            'label' => 'Nombre de Usuario',
            'rules' => 'required|min_length[2]|max_length[90]|custom_is_unique[users.user_name||id||id||||Nombre de Usuario]'
        ]
    ],
    'new_user_api' => [
        [
            'field' => 'email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|valid_email|required|min_length[8]|max_length[255]|custom_is_unique[users.user_email||id||0||||Correo Electronico]'
        ],
        [
            'field' => 'contrasena',
            'label' => 'Contraseña',
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[rcontrasena]'
        ],
        [
            'field' => 'rcontrasena',
            'label' => 'Repetir Contraseña',
            'rules' => 'required'
        ],
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[90]'
        ],
        [
            'field' => 'apellido',
            'label' => 'Apellido',
            'rules' => 'required|min_length[2]|max_length[90]'
        ],
        [
            'field' => 'nombre_usuario',
            'label' => 'Nombre de Usuario',
            'rules' => 'required|min_length[2]|max_length[90]|custom_is_unique[users.user_name||id||0||||Nombre de Usuario]'
        ]
    ],
    'forgot_api' => [
        [
            'field' => 'email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|valid_email|required|min_length[8]|max_length[255]'
        ],
    ],
    'validate_code_api' => [
        [
            'field' => 'codigo',
            'label' => 'Código',
            'rules' => 'trim|required|min_length[4]|max_length[4]'
        ],
    ],
    'add_cancha_reservada_api' => [
        [
            'field' => 'fecha',
            'label' => 'Fecha',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'cancha_horario_dia_horas_id',
            'label' => 'Hora',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'campo_cancha_id',
            'label' => 'Campo',
            'rules' => 'trim|required'
        ],
    ],
    'new_partido_api' => [
        [
            'field' => 'nombregrupo',
            'label' => 'Nombre',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'deportesgrupo',
            'label' => 'Deportes',
            'rules' => 'trim|required'
        ],
    ],
    'update_partido_api' => [
        [
            'field' => 'nombregrupo',
            'label' => 'Nombre',
            'rules' => 'trim|required'
        ],
        [
            'field' => 'deportesgrupo',
            'label' => 'Deportes',
            'rules' => 'trim|required'
        ],
    ],
    'confirm_api' => [
        [
            'field' => 'email',
            'label' => 'Correo Electronico',
            'rules' => 'trim|valid_email|required|min_length[8]|max_length[255]'
        ],
        [
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required|min_length[8]|max_length[16]|matches[rpassword]'
        ],
        [
            'field' => 'rpassword',
            'label' => 'Repetir Contraseña',
            'rules' => 'required'
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
    'add_deporte' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|is_unique[deporte.nombre]'
        ]
    ],
    'update_deporte' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|custom_is_unique[deporte.nombre||deporte_id||id||||Nombre]'
        ]
    ],
    'add_promocion' => [
        [
            'field' => 'titulo',
            'label' => 'Título',
            'rules' => 'required|is_unique[promociones.titulo]'
        ],
        [
            'field' => 'subtitulo',
            'label' => 'Subtítulo',
            'rules' => 'required'
        ],
        [
            'field' => 'url',
            'label' => 'URL',
            'rules' => 'required'
        ]
    ],
    'update_promocion' => [
        [
            'field' => 'titulo',
            'label' => 'Título',
            'rules' => 'required|custom_is_unique[promociones.titulo||promocion_id||id||||Título]'
        ],
        [
            'field' => 'subtitulo',
            'label' => 'Subtítulo',
            'rules' => 'required'
        ],
        [
            'field' => 'url',
            'label' => 'URL',
            'rules' => 'required'
        ]
    ],
    'add_campo' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|is_unique[campo.nombre]'
        ],
        [
            'field' => 'campo_estados',
            'label' => 'Estado',
            'rules' => 'required'
        ],
        [
            'field' => 'ubicacion',
            'label' => 'Ubicación',
            'rules' => 'required'
        ],
        [
            'field' => 'external_url',
            'label' => 'External URL',
            'rules' => 'custom_valid_url[external_url||External URL]'
        ],
        [
            'field' => 'campo_departamentos',
            'label' => 'Departamento',
            'rules' => 'required'
        ],
        [
            'field' => 'campo_provincias',
            'label' => 'Pronvincia',
            'rules' => 'required'
        ],
        [
            'field' => 'campo_distritos',
            'label' => 'Distrito',
            'rules' => 'required'
        ],
    ],
    'update_campo' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|custom_is_unique[campo.nombre||campo_id||campo_id||||Nombre]'
        ],
        [
            'field' => 'campo_estados',
            'label' => 'Estado',
            'rules' => 'required'
        ],
        [
            'field' => 'ubicacion',
            'label' => 'Ubicación',
            'rules' => 'required'
        ],
        [
            'field' => 'external_url',
            'label' => 'External URL',
            'rules' => 'custom_valid_url[external_url||External URL]'
        ],
        [
            'field' => 'campo_departamentos',
            'label' => 'Departamento',
            'rules' => 'required'
        ],
        [
            'field' => 'campo_provincias',
            'label' => 'Pronvincia',
            'rules' => 'required'
        ],
        [
            'field' => 'campo_distritos',
            'label' => 'Distrito',
            'rules' => 'required'
        ],
    ],
    'add_campocanchas' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|custom_is_unique[campo_canchas.nombre||campo_cancha_id||id||||Nombre||campo_id£campo_id]'
        ],
        [
            'field' => 'campo_id',
            'label' => 'Campo',
            'rules' => 'required'
        ],
        [
            'field' => 'deporte_id',
            'label' => 'Deporte',
            'rules' => 'required'
        ],
        [
            'field' => 'campo_estado_id',
            'label' => 'Estado',
            'rules' => 'required'
        ],
    ],
    'update_campocanchas' => [
        [
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required|custom_is_unique[campo_canchas.nombre||campo_cancha_id||id||||Nombre||campo_id£campo_id]'
        ],
        [
            'field' => 'campo_id',
            'label' => 'Campo',
            'rules' => 'required'
        ],
        [
            'field' => 'deporte_id',
            'label' => 'Deporte',
            'rules' => 'required'
        ],
        [
            'field' => 'campo_estado_id',
            'label' => 'Estado',
            'rules' => 'required'
        ],
    ],
    'add_campo_imagen' => [
    ],
    'update_campo_imagen' => [
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
