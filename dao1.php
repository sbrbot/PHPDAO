<?php

  $path='../../../models';

  $db_host='localhost';
  $db_name='';
  $db_port='3306';
  $db_user='';

  if(file_exists($path.'/dao.xml'))
  {
    $XML=simplexml_load_file($path.'/dao.xml');
    $XmlDatabase=$XML->database;
    $db_host=$XmlDatabase[0]['host'];
    $db_name=$XmlDatabase[0]['name'];
    $db_port=$XmlDatabase[0]['port'];
    $db_user=$XmlDatabase[0]['user'];
  }
  
?>
    <form method="post">

      <div class="row">

        <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3">

          <label for="DB_HOST" class="control-label">Hostname</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-archive"></i></div>
            </div>
            <input id="DB_HOST" name="DB_HOST" type="text" class="form-control" value="localhost">
          </div>

          <label for="DB_NAME" class="control-label">Database</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-database"></i></div>
            </div>
            <input id="DB_NAME" name="DB_NAME" type="text" class="form-control" value="<?= $db_name ?>">
          </div>

          <label for="DB_PORT" class="control-label">Port</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-plug"></i></div>
            </div>
            <input id="DB_PORT" name="DB_PORT" type="number" class="form-control" value="<?= $db_port ?>">
          </div>

          <label for="DB_USER" class="control-label">Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-user"></i></div>
            </div>
            <input id="DB_USER" name="DB_USER" type="text" class="form-control" value="<?= $db_user ?>">
          </div>

          <label for="DB_PASS" class="control-label">Password</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-unlock-alt"></i></div>
            </div>
            <input id="DB_PASS" name="DB_PASS" type="password" class="form-control">
          </div>

          <label for="DB_CHAR" class="control-label">Charset</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-globe"></i></div>
            </div>
            <select id="DB_CHAR" name="DB_CHAR" class="form-control">
              <option value="utf8" selected="selected">utf-8</option>
              <option value="latin1">latin1</option>
              <option value="latin2">latin2</option>
            </select>
          </div>

          <br>

        </div><!-- .col -->

      </div><!-- .row -->

      <div class="row text-center">

        <div class="col-12">
            <button type="submit" name="p" class="btn btn-info" value="2">Connect</button>
        </div><!-- .col -->

      </div><!-- .row -->

    </form>