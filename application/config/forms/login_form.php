<?php

$config['form'] = array(
    'attributes' => array(
        'class' => 'form-horizontal',
        'action' => 'login',
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
        'login_remember_me' => array(
            'input' => array(
                'type' => 'checkbox',
                'container_class' => 'col-sm-offset-4 col-sm-8'
            )
        )
    ),
    'actions' => array(
        'sign_in' => array(
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