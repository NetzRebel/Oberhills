<?php

$config['form'] = array(
    'attributes' => array(
        'class' => 'form-horizontal',
        'action' => 'signup',
        'role' => 'form'
    ),
    'hidden' => array(),
    'inputs' => array(
        'signup_email' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'signup_email',
                'placeholder' => 'signup_email',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required|valid_email|is_unique[userAccount.email]'
        ),
        'signup_email_repeat' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'signup_email_repeat',
                'placeholder' => 'signup_email_repeat',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required|matches[signup_email]'
        ),
        'signup_password' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'password',
                'class' => 'form-control',
                'id' => 'signup_password',
                'placeholder' => 'signup_password',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        ),
        'signup_password_repeat' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'password',
                'class' => 'form-control',
                'id' => 'signup_password_repeat',
                'placeholder' => 'signup_password_repeat',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required|matches[signup_password]'
        ),
        'signup_first_name' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'signup_first_name',
                'placeholder' => 'signup_first_name',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        ),
        'signup_last_name' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'signup_last_name',
                'placeholder' => 'signup_last_name',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        ),
        'signup_last_name' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'signup_last_name',
                'placeholder' => 'signup_last_name',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        ),
        'signup_birthday' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'date',
                'class' => 'form-control datepicker',
                'id' => 'signup_birthday',
                'placeholder' => 'signup_birthday',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        )
    ),
    'actions' => array(
        'signup' => array(
            'class' => 'btn btn-primary',
            'type' => 'submit',
            'container_class' => 'col-sm-offset-2 col-sm-4'
        ),
        'reset' => array(
            'class' => 'btn btn-primary',
            'type' => 'reset',
            'container_class' => 'col-sm-offset-2 col-sm-4'
        )
    ),
    'scripts' => array(
        'header' => array(
            'datepicker.css'
        ),
        'footer' => array(
            'bootstrap-datepicker.js'
        )
    )
);