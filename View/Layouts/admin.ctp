<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="rehabstudio" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->css(array(
			'libs/bootstrap.min.css', 'libs/bootstrap-responsive.min.css', 'libs/icons.css',
			'admin/main.css'
		));
		echo $this->fetch('css');
		echo $this->fetch('meta');


        echo $this->Html->script('libs/jquery-1.9.1.js');
		echo $this->fetch('script');
	?>
</head>
<body>

    <nav class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <?php echo $this->Html->link(Configure::read('Company.name'), '/', array('class' => 'brand')); ?>
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="nav-collapse">
                <?php if ($this->Session->check('Auth.User.id')) { ?>
                <ul class="nav pull-right">
                    <li class="vertical-divider"></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Html->link('Edit',
                                //array('plugin' => 'users', 'controller' => 'users', 'action' => 'edit', $this->Session->read('Auth.User.id')),
                                array('controller' => 'adminusers', 'action' => 'edit', $this->Session->read('Auth.User.id')),
                                array('class' => 'icon icon-edit')); ?>
                            </li>
                            <li><?php echo $this->Html->link(__('Logout'), '/admin/logout', array('class' => 'icon icon-logout')); ?></li>
                        </ul>
                    </li>
                </ul>
                <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" id="container">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->Session->flash('auth'); ?>
        <ul style="clear:both;" class="nav nav-tabs">

            <li class="<?php echo $this->Html->highlight2('/^\/admin\/stories/'); ?>">
                <?php echo $this->Html->link(__('Stories'), array('controller' => 'stories', 'action' => 'index', 'admin' => true), array('class' => 'icon icon-book-alt')); ?>
            </li>

            <li class="<?php echo $this->Html->highlight2('/^\/admin\/news/'); ?>">
                <?php echo $this->Html->link(__('News'), array('controller' => 'news', 'action' => 'index', 'admin' => true), array('class' => 'icon icon-calendar')); ?>
            </li>

            <li class="<?php echo $this->Html->highlight2('/^\/admin\/tags/'); ?>">
                <?php echo $this->Html->link(__('Tags'), array('controller' => 'tags', 'action' => 'index', 'admin' => true), array('class' => 'icon icon-tags')); ?>
            </li>

            <li class="<?php echo $this->Html->highlight2('/^\/admin\/users/'); ?>">
                <?php echo $this->Html->link(__('Users'), array('controller' => 'users', 'action' => 'index', 'admin' => true), array('class' => 'icon icon-user')); ?>
            </li>

            <li class="<?php echo $this->Html->highlight2('/^\/admin\/adminusers/'); ?> right">
                <?php echo $this->Html->link(__('Admin Users'), array('controller' => 'admin_users', 'action' => 'index', 'admin' => true), array('class' => 'icon icon-users-alt')); ?>
            </li>

 <?php /*
 	    <li class="<?php echo $this->Html->highlight('/^\/admin\/locales/'); ?>">
                <?php echo $this->Html->link(__('Locales'), array('plugin'=>false, 'controller' => 'locales', 'action' => 'index', 'admin' => true), array('class' => 'icon icon-locales-alt')); ?>
            </li>
*/ ?>
        </ul>

        <div id="main" role="main">
            <?php echo $this->fetch('content'); ?>
        </div>

        <footer>
            <p class="pull-right"><?php echo Configure::read('Developer.name'); ?>. &copy; <?php echo date('Y'); ?></p>
            <p>Licensed for use by <?php echo Configure::read('Company.name'); ?>, developed by <strong><?php echo Configure::read('Developer.name'); ?></strong>.</p>
        </footer>
    </div>


	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	<script>
		$(document).ready(function() {
			$('#topbar').dropdown();
			$('.asc').parent().addClass('headerSortUp');
			$('.desc').parent().addClass('headerSortDown');

			$('#locale-selector').on('change', function() {
				$('#locale-change').submit();
			});
		});
    </script>
    <?php
        echo $this->Html->script('libs/bootstrap.min.js');
        echo $this->fetch('script');
    ?>
	<!--[if lt IE 7 ]>
		<script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
</body>
</html>