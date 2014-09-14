<!DOCTYPE html>
<html lang="<?php echo $this->HTMLDOC->Meta->getLanguageCode(); ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $this->HTMLDOC->Meta->getDescription(); ?>">
    <meta name="author" content="<?php echo $this->HTMLDOC->Meta->getAuthor(); ?>">
    <title><?php echo $this->HTMLDOC->Meta->getTitle(); ?></title>
    <?php echo $this->assetor->generate('header'); ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Oberhills</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav pull-right"><?php if($this->Visitor->isLoggedIn()) : ?>
            <li>
              <?php echo anchor('logout', lang('navbar_logout_link')); ?>
            </li>
          <?php else : ?>
            <li>
              <?php echo anchor('signup', lang('navbar_signup_link')); ?>
            </li>
            <li>
              <?php echo anchor('login', lang('navbar_login_link')); ?>
            </li>
          <?php endif; ?></ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div id="content_wrapper">

    <?php if(count($systemmessages)>0) foreach($systemmessages as $type => $messages) : ?>
        <div class="row"><div class="col-sm-4 col-sm-offset-4 col-xs-12 col-md-4 col-md-offset-4">
        <?php foreach($messages as $message) : ?>
            <div class="alert alert-<?php echo $type; ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <?php echo $message; ?>
            </div>
        <?php endforeach; ?>
        </div></div>
    <?php endforeach; ?>
            
    <?php
        // send output
        echo $content.PHP_EOL;
    ?>
        
    </div>
    <div id="footer">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
    <?php echo $this->assetor->generate('footer'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            if(!Modernizr.inputtypes.date) {
                $('.datepicker').each(function(){
                    $(this).datepicker();
                });
            }
        });
    </script>
  </body>
</html>