<?php

$config['form'] = array(
    'attributes' => array(
        'class' => 'form-horizontal',
        'action' => 'auth/signup',
        'role' => 'form'
    ),
    'hidden' => array(),
    'inputs' => array(
        'login_email' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'login_email',
                'placeholder' => 'login_email',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        ),
        'login_email_repeat' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'text',
                'class' => 'form-control',
                'id' => 'login_email_repeat',
                'placeholder' => 'login_email_repeat',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required|matches[login_email]'
        ),
        'login_password' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'password',
                'class' => 'form-control',
                'id' => 'login_password',
                'placeholder' => 'login_password',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required'
        ),
        'login_password_repeat' => array(
            'label' => array(
                'class' => 'col-sm-4 control-label'
            ),
            'input' => array(
                'type' => 'password',
                'class' => 'form-control',
                'id' => 'login_password_repeat',
                'placeholder' => 'login_password_repeat',
                'container_class' => 'col-sm-8'
            ),
            'validation' => 'required|matches[login_password]'
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
    )
);