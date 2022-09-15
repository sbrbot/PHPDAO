<?php

session_start();

//error_reporting(E_ALL ^ E_WARNING);

require 'Engine.php';

$path='../../../models';

try
{
  $Engine=new Engine();

  $tvs=$Engine->getTablesAndViews();

  if(file_exists($path.'/dao.xml'))
  {
    $XML=simplexml_load_file($path.'/dao.xml');
  }
  else
  {
    $XML=new SimpleXMLElement('<dao></dao>');
  }
  $XmlTables=$XML->dao;

?>
      <form method="post">

        <div class="row">
          <div class="col-12">

            <div class="alert alert-info text-center"><i class="fa fa-info-circle fa-5x"></i><br>Select tables and views you want to create objects for and then define how on tables/views mapped objects will be named in singular and plural forms.</div>

            <div class="img-thumbnail">

              <table class="table table-bordered table-sm bg-light">
                <thead class="thead-dark">
                  <tr>
                    <th>DAO</th>
                    <th>NAME</th>
                    <th>ENGINE</th>
                    <th>TYPE</th>
                    <!--th>UPDATABLE</th-->
                    <th>COMMENT</th>
                    <th>OBJECT (singular)</th>
                    <th>OBJECTS (plural)</th>
                  </tr>
                </thead>
<?php

  foreach($tvs as $tv)
  {
    if($XmlTable=$XmlTables->xpath("//table[@name='".$tv['TABLE_NAME']."']"))
    {
      $singular=$XmlTable[0]['singular'];
      $plural=$XmlTable[0]['plural'];
      $checked=($XmlTable[0]['active']=='yes') ? ' checked="checked"' : '';
    }
    else
    {
      $English=new English($tv['TABLE_NAME']);
      $singular=$English->singular;
      $plural=$English->plural;
      $checked=' checked="checked"';
    }
?>
                <tr>
                  <td align="center"><input type="checkbox" name="tvs[<?= $tv['TABLE_NAME'] ?>]"<?= $checked ?>></td>
                  <td><?= $tv['TABLE_NAME'] ?><?php if(!$XmlTable) echo ' <span class="badge badge-primary">NEW</span>'; ?></td>
                  <td align="center"><?php if($tv['TABLE_TYPE']=='TABLE') echo $tv['ENGINE']; ?></td>
                  <td align="center"><input type="hidden" name="tvtypes[<?= $tv['TABLE_NAME'] ?>]" value="<?= $tv['TABLE_TYPE'] ?>"><?= $tv['TABLE_TYPE'] ?></td>
                  <!--td align="center"><input type="hidden" name="tvupdatable[<?= $tv['TABLE_NAME'] ?>]" value="<?= $tv['IS_UPDATABLE'] ?>" ><?php if($tv['IS_UPDATABLE']==='YES') echo ' <i class="fa fa-ckeck"></span>'; ?></td-->
                  <td align="center"><?php if($tv['TABLE_COMMENT']) echo '<i title="'.$tv['TABLE_COMMENT'].'" class="fa fa-comment"></span>'; ?></td>
                  <td><input type="text" name="tvobject[<?= $tv['TABLE_NAME'] ?>]" value="<?= $singular ?>" class="form-control"></td>
                  <td><input type="text" name="tvobjects[<?= $tv['TABLE_NAME'] ?>]" value="<?= $plural ?>" class="form-control"></td>
                </tr>
<?php
  }
?>
              </table>

            </div><!-- .thumbnail -->
          </div><!-- .col -->
        </div><!-- .row -->

        <div class="row text-center">
          <div class="col-12">
            <button type="submit" name="p" class="btn btn-info" value="3">Proceed</button>
          </div><!-- .col -->
        </div><!-- .row -->

      </form>
<?php
}
catch(ConnectionException $ce)
{
?>
              <div class="alert alert-danger text-center"><i class="fa fa-exclamation-triangle fa-5x"></i><br>Cannot connect to database!</div>
<?php
}
?>
