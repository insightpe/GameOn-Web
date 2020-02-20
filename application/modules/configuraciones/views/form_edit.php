<?php
defined('BASEPATH') OR exit('No direct script access allowed');


?>
<div class="row">
    <!-- left column -->
    <div class="col-xs-12 col-md-8 col-lg-6">
        <!-- general form elements -->

            <?php
            if (validation_errors()) {
                echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
            }
            ?>
            <!-- form start -->
            <form role="form" action="<?php echo base_url('actualizar-configuraciones'); ?>" method="POST">
                <input type="hidden" value="<?php echo $config == null ? "0" : $config->id_config; ?>" name="id">
                <div class="box-body">
                    <div class="form-group">
                        <label for="application_name">Nombre de Aplicación</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->application_name; ?>" 
                        class="form-control" name="application_name" placeholder="Nombre de Aplicación">
                    </div>
                   
                    <div class="form-group">
                        <label for="author">Autor</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->author; ?>" 
                        class="form-control" name="author" placeholder="Autor">
                    </div>        

                    <div class="form-group">
                        <label for="mail_server">Servidor de Correo</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->mail_server; ?>" 
                        class="form-control" name="mail_server" placeholder="Servidor de Correo">
                    </div>    

                    <div class="form-group">
                        <label for="file_system_server">Servidor de Almacenamiento de Archivos</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->file_system_server; ?>" 
                        class="form-control" name="file_system_server" placeholder="Servidor de Almacenamiento de Archivos">
                    </div>    

                    <div class="form-group">
                        <label for="database_server">Servidor de Base de Datos</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->database_server; ?>" 
                        class="form-control" name="database_server" placeholder="Servidor de Base de Datos">
                    </div>    

                    <div class="form-group">
                        <label for="company_name">Nombre de Empresa</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->company_name; ?>" 
                        class="form-control" name="company_name" placeholder="Nombre de Empresa">
                    </div>    


                    <div class="form-group">
                        <label for="company_address">Dirección de Empresa</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->company_address; ?>" 
                        class="form-control" name="company_address" placeholder="Dirección de Empresa">
                    </div>    

                    <div class="form-group">
                        <label for="main_person">Persona Encargada</label>
                        <input type="text" value="<?php echo $config == null ? "" : $config->main_person; ?>" 
                        class="form-control" name="main_person" placeholder="Persona Encargada">
                    </div>    

                    <div class="form-group">
                        <label for="main_person">Ajustar permisos a nivel de TRD</label>
                        <label class="switch switch-success">
                            <input type="checkbox" name="permisos_trd" <?php echo $config == null ? "" : ($config->permisos_trd == null || 
                            $config->permisos_trd == 0 ? "" : "checked"); ?> value="on">
                            <span></span>
                        </label>
                    </div> 
                    <div class="form-group">
                        <label for="main_person">Escoger tema</label>
                        <div style="width:198px;background-color:#454e59;padding-left:8px;padding-top:8px">
                        <ul class="sidebar-themes clearfix" >
                                    <li class="<?php
                                    echo (($config_for_template->theme == null) 
                                    || (($config_for_template->theme == "" || $config_for_template->theme == "default") && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse")
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('default', 'navbar-inverse', '', 'themed-background-default')" class="themed-background-default" data-toggle="tooltip" title="Default" data-theme="default" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-default"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "classy")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/classy.css', 'navbar-inverse', '', 'themed-background-classy')" class="themed-background-classy" data-toggle="tooltip" title="Classy" data-theme="css/themes/classy.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-classy"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "social")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/social.css', 'navbar-inverse', '', 'themed-background-social')" class="themed-background-social" data-toggle="tooltip" title="Social" data-theme="css/themes/social.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-social"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "flat")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/flat.css', 'navbar-inverse', '', 'themed-background-flat')" class="themed-background-flat" data-toggle="tooltip" title="Flat" data-theme="css/themes/flat.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-flat"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "amethyst")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/amethyst.css', 'navbar-inverse', '', 'themed-background-amethyst')" class="themed-background-amethyst" data-toggle="tooltip" title="Amethyst" data-theme="css/themes/amethyst.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-amethyst"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "creme")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/creme.css', 'navbar-inverse', '', 'themed-background-creme')" class="themed-background-creme" data-toggle="tooltip" title="Creme" data-theme="css/themes/creme.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-creme"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "passion")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/passion.css', 'navbar-inverse', '', 'themed-background-passion')" class="themed-background-passion" data-toggle="tooltip" title="Passion" data-theme="css/themes/passion.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="">
                                            <span class="section-side themed-background-dark-passion"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && $config_for_template->theme == "default") && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('default', 'navbar-inverse', 'sidebar-light', 'themed-background-default')" class="themed-background-default" data-toggle="tooltip" title="Default + Light Sidebar" data-theme="default" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "classy")) && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/classy.css', 'navbar-inverse', 'sidebar-light', 'themed-background-classy')" class="themed-background-classy" data-toggle="tooltip" title="Classy + Light Sidebar" data-theme="css/themes/classy.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "social")) && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/social.css', 'navbar-inverse', 'sidebar-light', 'themed-background-social')" class="themed-background-social" data-toggle="tooltip" title="Social + Light Sidebar" data-theme="css/themes/social.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "flat")) && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/flat.css', 'navbar-inverse', 'sidebar-light', 'themed-background-flat')" class="themed-background-flat" data-toggle="tooltip" title="Flat + Light Sidebar" data-theme="css/themes/flat.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "amethyst")) && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/amethyst.css', 'navbar-inverse', 'sidebar-light', 'themed-background-amethyst')" class="themed-background-amethyst" data-toggle="tooltip" title="Amethyst + Light Sidebar" data-theme="css/themes/amethyst.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "creme")) && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/creme.css', 'navbar-inverse', 'sidebar-light', 'themed-background-creme')" class="themed-background-creme" data-toggle="tooltip" title="Creme + Light Sidebar" data-theme="css/themes/creme.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "passion")) && $config_for_template->theme_sidebar == "sidebar-light" && $config_for_template->theme_navbar == "navbar-inverse"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/passion.css', 'navbar-inverse', 'sidebar-light', 'themed-background-passion')" class="themed-background-passion" data-toggle="tooltip" title="Passion + Light Sidebar" data-theme="css/themes/passion.css" data-theme-navbar="navbar-inverse" data-theme-sidebar="sidebar-light">
                                            <span class="section-side"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && $config_for_template->theme == "default") && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/default.css', 'navbar-default', '', 'themed-background-default')" class="themed-background-default" data-toggle="tooltip" title="Default + Light Header" data-theme="default" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-default"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "classy")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/classy.css', 'navbar-default', '', 'themed-background-classy')" class="themed-background-classy" data-toggle="tooltip" title="Classy + Light Header" data-theme="css/themes/classy.css" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-classy"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "social")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/social.css', 'navbar-default', '', 'themed-background-social')" class="themed-background-social" data-toggle="tooltip" title="Social + Light Header" data-theme="css/themes/social.css" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-social"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "passion")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/passion.css', 'navbar-default', '', 'themed-background-passion')" onclick="Uiconfiguraciones.change_theme('css/themes/passion.css', 'navbar-inverse', 'sidebar-light', 'themed-background-passion')" class="themed-background-flat" data-toggle="tooltip" title="Flat + Light Header" data-theme="css/themes/flat.css" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-flat"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "amethyst")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/amethyst.css', 'navbar-default', '', 'themed-background-amethyst')" class="themed-background-amethyst" data-toggle="tooltip" title="Amethyst + Light Header" data-theme="css/themes/amethyst.css" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-amethyst"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "creme")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/creme.css', 'navbar-default', '', 'themed-background-creme')" class="themed-background-creme" data-toggle="tooltip" title="Creme + Light Header" data-theme="css/themes/creme.css" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-creme"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                    <li class="<?php
                                    echo (($config_for_template != null && strrpos($config_for_template->theme, "passion")) && $config_for_template->theme_sidebar == "" && $config_for_template->theme_navbar == "navbar-default"
                                    ? "active" : "");
                                    ?>">
                                        <a href="javascript:void(0)" onclick="Uiconfiguraciones.change_theme('css/themes/passion.css', 'navbar-default', '', 'themed-background-passion')" class="themed-background-passion" data-toggle="tooltip" title="Passion + Light Header" data-theme="css/themes/passion.css" data-theme-navbar="navbar-default" data-theme-sidebar="">
                                            <span class="section-header"></span>
                                            <span class="section-side themed-background-dark-passion"></span>
                                            <span class="section-content"></span>
                                        </a>
                                    </li>
                                </ul>
        </div>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
     

                  <button type="submit" name="edit_config" value="dash" class="btn btn-primary"><?php echo $this->lang->line('button_update'); ?></button>
                  <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('dashboard'); ?>"'>Regresar</button>
                  
                </div>
            </form>

    </div>
</div>