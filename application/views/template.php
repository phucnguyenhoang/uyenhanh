<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $title ?></title>

    <!-- Bootstrap -->
    <link href="/resources/css/bootstrap.min.css" rel="stylesheet">

    <?php if (!empty($css) && is_string($css)) : ?>
      <link href="/resources/css/<?= $css ?>.css" rel="stylesheet">
    <?php endif; ?>

    <?php if (!empty($css) && is_array($css)) : ?>
      <?php foreach ($css as $link) : ?>
        <link href="/resources/css/<?= $link ?>.css" rel="stylesheet">
      <?php endforeach; ?>
    <?php endif; ?>

    <link href="/resources/css/layout.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-home"></span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="<?= $this->uri->rsegment(1) == 'orders' ? 'active' : '' ?>"><a href="<?= base_url('orders') ?>"><?= lang('order') ?></a></li>
            <li class="<?= $this->uri->rsegment(1) == 'quotations' ? 'active' : '' ?>"><a href="<?= base_url('quotations') ?>"><?= lang('quotation') ?></a></li>
            <li class="<?= $this->uri->rsegment(1) == 'reports' ? 'active' : '' ?>"><a href="<?= base_url('reports') ?>"><?= lang('report') ?></a></li>
            <li class="dropdown <?= in_array($this->uri->rsegment(1), array('products', 'customers')) ? 'active' : '' ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= lang('lists') ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="<?= $this->uri->rsegment(1) == 'products' ? 'active' : '' ?>"><a href="<?= base_url('products') ?>"><span class="glyphicon glyphicon-leaf"></span> <?= lang('product') ?></a></li>
                <li class="<?= $this->uri->rsegment(1) == 'customers' ? 'active' : '' ?>"><a href="<?= base_url('customers') ?>"><span class="glyphicon glyphicon-user"></span> <?= lang('customer') ?></a></li>
              </ul>
            </li>
          </ul>
          
          <ul class="nav navbar-nav navbar-right">
            <?php if ($this->auth->isLoggedIn()) : ?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="user-info">
                    <img src="<?= $this->auth->user('avatar') ?>">
                    Hello, <?= $this->auth->user('name') ?>
                  </li>
                  <li><a href="#"><?= lang('change_avatar') ?></a></li>
                  <li><a href="#"><?= lang('change_password') ?></a></li>
                  <li role="separator" class="divider"></li>
                  <li><a class="text-danger" href="<?= base_url('users/logout') ?>"><span class="glyphicon glyphicon-log-out"></span> <?= lang('logout') ?></a></li>
                </ul>
              </li>
            <?php else : ?>
              <li><a href="<?= base_url('users/login') ?>"><span class="glyphicon glyphicon-user"></span> <?= lang('login') ?></a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <?php if (!empty($header)) : ?>
        <div class="page-header">
          <h1><?= $header['main'] ?> <small><?= $header['sub'] ?></small></h1>
        </div>
      <?php endif; ?>

      <?php if (!empty($breadcrumb)) : ?>
        <ol class="breadcrumb">
          <li><a href="/"><span class="glyphicon glyphicon-home"></span></a></li>
          <?php foreach ($breadcrumb as $key => $value) : ?>
            <?php if (empty($value)) : ?>
              <li class="active"><?= $key ?></li>
            <?php else : ?>
              <li><a href="<?= base_url($value) ?>"><?= $key ?></a></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ol>
      <?php endif; ?>

      <?= $view ?>
        
    </div>

    <div class="footer">copyright@phucnguyen 2017</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/resources/js/jquery-2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/resources/js/bootstrap.min.js"></script>

    <?php if (!empty($js) && is_string($js)) : ?>
      <script src="/resources/js/<?= $js ?>.js"></script>
    <?php endif; ?>

    <?php if (!empty($js) && is_array($js)) : ?>
      <?php foreach ($js as $link) : ?>
        <script src="/resources/js/<?= $link ?>.js"></script>
      <?php endforeach; ?>
    <?php endif; ?>

    <script src="/resources/js/main.js"></script>
  </body>
</html>