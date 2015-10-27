<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title_for_layout; ?></title>    
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php 
        echo $this->Html->css(array('libs/bootstrap.min.css', 'libs/bootstrap-responsive.min.css', 'admin/login.css'));
        echo $this->fetch('meta');
        echo $this->fetch('css');
    ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="span6 offset3">
                <div id="loginView">
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->Session->flash('auth'); ?>
                    <?php echo $this->fetch('content'); ?>
                </div>
            </div>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
    <?php echo $this->Html->script('libs/bootstrap.min'); ?>
</body>
</html>