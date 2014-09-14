<div class="jumbotron">
    <div class="container">
        <h1><?php echo lang('404_page_title'); ?></h1>
        <p><?php echo lang('404_page_message'); ?></p>
        <p>
            <a class="btn btn-primary btn-lg" role="button" onclick="history.go(-1)"><?php echo lang('button_go_back'); ?></a>
            <a class="btn btn-primary btn-lg" role="button" href="<?php echo site_url(); ?>"><?php echo lang('button_go_home'); ?></a>
        </p>
    </div>
</div>