<?php

function render_form($form)
{
    $form_html = render_form_head($form['attributes']);
    $form_html .= render_hidden_inputs($form['hidden']);
    foreach($form['inputs'] as $name => $form_input_data)
    {
        $form_html .= render_form_row($name, $form_input_data);
    }
    $form_html .= render_form_actions($form['actions']);
    $form_html .= PHP_EOL.'</form>'.PHP_EOL;
    return $form_html;
}

// render form head
function render_form_head($attributes)
{
    // make sure the method attribute is there
    if(!array_key_exists('method', $attributes))
    {
        $attributes['method'] = 'post';
    }
    // make sure the action attribute is there
    if(array_key_exists('action', $attributes))
    {
        $attributes['action'] = site_url($attributes['action']);
    }
    else
    {
        $attributes['action'] = current_url();
    }
    // build the head
    $form_head = PHP_EOL
        . '<form'
        . render_attribute_string($attributes)
        . '>';
    return $form_head;
}

// render hidden inputs
function render_hidden_inputs($hidden_inputs)
{
    $hidden_inputs_html = '';
    foreach($hidden_inputs as $name => $value)
    {
        $hidden_inputs_html .= '<input type="hidden" name="'
            . $name
            . '" value ="'
            . $value
            . '" />'
            . PHP_EOL;
    }
}

// render a row
function render_form_row($name, $form_input_data)
{
    // check for validation errors
    $form_class = '';
    $form_error = form_error($name);
    if($form_error!="")
    {
        $form_class = ' has-error';
        $form_input_data['help_block'] = $form_error;
    }
    // render control
    $form_control = '';
    switch($form_input_data["input"]["type"])
    {
        case 'checkbox':
            $form_control = render_form_control_checkbox($name, $form_input_data);
            break;
        case 'password':
        default:
            $form_control = render_form_control_text($name, $form_input_data);
            break;
    }
    // put control between form group
    $form_row = PHP_EOL
        . '<div class="form-group'
        . $form_class
        . '">'
        . PHP_EOL
        . $form_control
        . '</div>';
    return $form_row;
}

// render normal textbox inputs
function render_form_actions($actions)
{
    $form_controls = array();
    foreach($actions as $name => $attributes)
    {
        $form_control = '<div>'.PHP_EOL;
        if(isset($attributes["container_class"]))
        {
            $form_control = '<div class="'
                . $attributes["container_class"]
                . '">'
                . PHP_EOL;
            unset($attributes["container_class"]);
        }
        $form_control .= '<button'
            . render_attribute_string($attributes)
            . '>'
            . lang($name.'_action_label')
            . '</button>'
            . PHP_EOL
            . '</div>';
        $form_controls[] = $form_control;
    }
    // put control between form group
    $form_row = PHP_EOL
        . '<div class="form-group">'
        . PHP_EOL
        . implode(PHP_EOL, $form_controls)
        . PHP_EOL
       
        . '</div>';
    return $form_row;
}

// render normal textbox inputs
function render_form_control_text($name, $form_input_data)
{
    // prepare label
    $label_attributes = 'for="'.$name.'"'.render_attribute_string($form_input_data["label"]);
    $form_label = '<label '.$label_attributes.'>'.lang($name.'_form_label').'</label>';
    // prepare input
    $form_input = '<div>';
    // is there a class defined for the outer container?
    if(isset($form_input_data["input"]["container_class"]))
    {
        $form_input = '<div class="'
            . $form_input_data["input"]["container_class"]
            . '">'
            . PHP_EOL;
        unset($form_input_data["input"]["container_class"]);
    }
    $control_attributes = '';
    // value is defined?
    if(isset($form_input_data["input"]['value']))
    {
        $form_input_data["input"]['value'] = set_value($name, $form_input_data["input"]['value']);
    }
    else
    {
        $form_input_data["input"]['value'] = set_value($name);
    }
    // name defined?
    if(!isset($form_input_data["input"]['name']))
    {
        $form_input_data["input"]['name'] = $name;
    }
    $help_block = '';
    // help block?
    if(isset($form_input_data["help_block"]))
    {
        if(isset($form_input_data["label"]["class"]))
        {
            $help_block .= '<div class="'
                . $form_input_data["label"]["class"]
                . '"></div>';
        }
        $help_block_class = '';
        if(isset($form_input_data["input"]["class"]))
        {
            $help_block_class .= ' ' . $form_input_data["input"]["class"];
        }
        $help_block .= '<p class="help-block col-sm-8">'
            . $form_input_data["help_block"]
            . '</p>';
    }
    foreach($form_input_data["input"] as $key => $value)
    {
        // should something be translated?
        if(in_array($key , array('placeholder')))
        {
            $value = lang($value.'_placeholder');
        }
        $control_attributes .= ' '.$key.'="'.$value.'"';
    }
    $form_input .= '<input'
        . $control_attributes
        . ' /></div>'
        . PHP_EOL;
    
    return $form_label . $form_input . $help_block;
}

// render a checkbox
function render_form_control_checkbox($name, $form_input_data)
{
    // prepare input
    $form_input = '<div>' . PHP_EOL;
    // is there a class defined for the outer container?
    if(isset($form_input_data["input"]["container_class"]))
    {
        $form_input = '<div class="'
            . $form_input_data["input"]["container_class"]
            . '">'
            . PHP_EOL;
        unset($form_input_data["input"]["container_class"]);
    }
    // build checkbox
    $form_input .= '<div class="checkbox"><label>'
        . PHP_EOL;

    // attribues
    if(isset($_POST[$name]))
    {
        $form_input_data["input"]['checked'] = 'checked';
    }
    $attributes = ' name="'
        . $name
        . '"'
        . render_attribute_string($form_input_data["input"]);
    $form_input .= '<input'.$attributes.' /> ' .lang($name.'_form_label');
    
    // help block?
    if(isset($form_input_data["help_block"]))
    {
        $form_input .= ' ('.$form_input_data["help_block"] . ')';
    }
    
    // close checkbox
    $form_input .= '</label></div>'
        . PHP_EOL;
    
    // close form
    $form_input .= '</div>'
        . PHP_EOL;
    return $form_input;
}

// render an attribute string
function render_attribute_string($attributes)
{
    $attribute_string = '';
    foreach($attributes as $key => $value)
    {
        $attribute_string .= ' '
            . $key
            . '="'
            . $value
            . '"';
    }
    return $attribute_string;
}