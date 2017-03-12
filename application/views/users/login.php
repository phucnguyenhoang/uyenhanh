<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= lang('login') ?></title>

    <!-- Bootstrap -->
    <link href="/resources/css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">    
      label.required::after {
        content: "*";
        color: #a94442;
        margin-left: 3px;
      }
      .btn-link {
        color: #a94442;
      }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <form id="frmLogin" method="post">
      <div id="modalLogin" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?= lang('login_title') ?></h4>
            </div>
            <div class="modal-body">
              <?php if (!empty($flash)) : ?>
                <?= fMessage($flash['msg'], $flash['type']) ?>
              <?php endif; ?>
              <div class="form-group">
                <label for="txtUserName" class="required"><?= lang('username') ?></label>
                <input type="text" name="username" class="form-control" id="txtUserName" placeholder="<?= lang('username') ?>"  data-rule="required|maxLength:100">
              </div>

              <div class="form-group">
                <label for="txtPassword" class="required"><?= lang('password') ?></label>
                <input type="password" name="password" class="form-control" id="txtPassword" placeholder="<?= lang('password') ?>" data-rule="required|maxLength:100">
              </div>
            </div>
            <div class="modal-footer">
              <a href="<?= base_url('users/password') ?>" class="btn btn-link text-danger"><?= lang('forget_password') ?>?</a>
              <button type="submit" class="btn btn-primary"><?= lang('login') ?></button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/resources/js/jquery-2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/resources/js/bootstrap.min.js"></script>
    <script src="/resources/js/g-validator.js"></script>

    <script type="text/javascript">
      $(function() {
        $('#modalLogin').modal({
          backdrop: 'static',
          keyboard: false,
          show: true
        });

        $('#frmLogin').gValidator({
          message: {
            required: 'Thông tin bắt buộc.',
            maxLength: 'Cho phép tối đa %length% ký tự.'
          }
        });
      });
    </script>
  </body>
</html>