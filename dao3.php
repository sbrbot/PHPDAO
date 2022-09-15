<?php

session_start();

//error_reporting(E_ALL ^ E_WARNING);

$path='../../../models';

$tvs=$_SESSION['tvs'];
$tvtypes=$_SESSION['tvtypes'];
//$tvupdatable=$_SESSION['tvupdatable'];
$tvobject=$_SESSION['tvobject'];
$tvobjects=$_SESSION['tvobjects'];

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

require 'Engine.php';

try
{
  $Engine=new Engine();

  if(file_exists($path.'/dao.xml'))
  {
    $XML=simplexml_load_file($path.'/dao.xml');
  }
  else
  {
    $XML=new SimpleXMLElement('<dao></dao>');
  }
?>
      <form method="post">

        <div class="alert alert-info text-center"><i class="fa fa-info-circle fa-5x"></i><br>Define here which columns <b>getter</b>, <b>setter</b> and <b>finder</b> methods shall be created for and what will be their method names.<br>Primary key columns must have setter and getter methods!<br>E.g. if you define your column's method name root as <b>firstName</b>, then methods <b>getFirstName</b>, <b>setFirstName</b> and <b>findByFirstName</b> will be created.</div>

<?php

  foreach($_SESSION['tvs'] as $tvname=>$tvcheck)
  {
    $XmlTableViews=$XML->xpath("//table[@name='".$tvname."']");

    //$updatable=($tvupdatable[$tvname]==='YES');

?>
        <div class="row">
          <div class="col-12">
            <div class="img-thumbnail">

              <h3><?= $tvtypes[$tvname] ?>=<?= $tvname ?><?php if(!$XmlTableViews) echo ' <span class="badge badge-primary">NEW</span>'; ?></h3>singular=<?= $tvobject[$tvname] ?>, plural=<?= $tvobjects[$tvname] ?>

              <table class="table table-bordered table-sm bg-light">
                <thead class="thead-dark">
                  <tr>
                    <th>COLUMN</th>
                    <th>TYPE</th>
                    <th width="30" title="Primary Key">PK</th>
                    <th width="30" title="Single Unique Key">UQ</th>
                    <th width="30" title="Foreign Key">FK</th>
                    <th width="30" title="Not NULL">NN</th>
                    <th width="30" title="Auto-increment">AI</th>
                    <th width="30" title="Has indexes">IDX</th>
                    <th>REFERENCE</th>
                    <th>COMMENT</th>
                    <th>get</th>
                    <th>set</th>
                    <th>find</th>
                    <th>method root</th>
                  </tr>
                </thead>
                <tbody>
<?php

    $columns=$Engine->getColumnsWithAttributes($tvname);

    foreach($columns as $column)
    {
      $columnname=$column['COLUMN_NAME'];

      $XmlColumns=false;

      if($XmlTableViews && $XmlColumns=$XmlTableViews[0]->xpath("column[@name='".$columnname."']")) //if table and colum exist in XML
      {
        $method=(string)$XmlColumns[0]['method'];
        $gettercheckbox=(strtolower((string)$XmlColumns[0]['getter'])==='yes' || $column['PK']) ?  ' checked="checked"' : '';
        $settercheckbox=((strtolower((string)$XmlColumns[0]['setter'])==='yes' || $column['PK']) && $tvtypes[$tvname]=='TABLE') ?  ' checked="checked"' : '';
        $findercheckbox=(strtolower((string)$XmlColumns[0]['finder'])==='yes' || $column['PK']) ?  ' checked="checked"' : '';
      }
      else
      {
        $English=new English($columnname);
        $method=$English->camel;
        $gettercheckbox=' checked="checked"';
        $settercheckbox=' checked="checked"';
        $findercheckbox=($column['IDX']) ? ' checked="checked"' : '';
      }
      $getterreadonly = $column['PK'] ? ' readonly="readonly"' : '';
      $setterreadonly = $column['PK'] ? ' readonly="readonly"' : '';
      $setterdisabled = $tvtypes[$tvname]=='VIEW' ? ' disabled="disabled"' : '';//view cannot have setters
      if($tvtypes[$tvname]=='VIEW') $settercheckbox=''; //if(!$updatable) $settercheckbox='';
?>
                  <tr>
                    <td width="15%"><b><?= $columnname ?></b><?php if(!$XmlColumns) echo ' <span class="badge badge-primary">NEW</span>'; ?></td>
                    <td width="15%"><?= $column['COLUMN_TYPE'] ?></td>
                    <td width="5%" align="center"><?php if($column['PK']) echo '<i class="fa fa-check"></i>'; ?></td>
                    <td width="5%" align="center"><?php if($column['UQ']) echo '<i class="fa fa-check"></i>'; ?></td>
                    <td width="5%" align="center"><?php if($column['FK']) echo '<i class="fa fa-check"></i>'; ?></td>
                    <td width="5%" align="center"><?php if($column['NN']) echo '<i class="fa fa-check"></i>'; ?></td>
                    <td width="5%" align="center"><?php if($column['AI']) echo '<i class="fa fa-check"></i>'; ?></td>
                    <td width="5%" align="center"><?php if($column['IDX']) echo '<i class="fa fa-check"></i>'; ?></td>
                    <td width="5%"><?php if($column['REFERENCED_TABLE_NAME']) echo $column['REFERENCED_TABLE_NAME'].'.'.$column['REFERENCED_COLUMN_NAME'] ?></td>
                    <td width="5%" align="center"><?php if($column['COLUMN_COMMENT']) echo '<i title="'.$column['COLUMN_COMMENT'].'" class="fa fa-comment"></span>'; ?></td>
                    <td width="5%" align="center"><input type="checkbox" name="getters[<?= $tvname ?>][<?= $columnname ?>]" <?= $gettercheckbox ?><?= $getterreadonly ?>></td>
                    <td width="5%" align="center"><input type="checkbox" name="setters[<?= $tvname ?>][<?= $columnname ?>]" <?= $settercheckbox ?><?= $setterreadonly ?><?= $setterdisabled ?>></td>
                    <td width="5%" align="center"><input type="checkbox" name="finders[<?= $tvname ?>][<?= $columnname ?>]" <?= $findercheckbox ?>></td>
                    <td width="15%"><input type="text" name="methods[<?= $tvname ?>][<?= $columnname ?>]" value="<?= $method ?>" class="form-control"></td>
                  </tr>
<?php
    }
?>
                </tbody>
<?php
    if($constraints=$Engine->getCompositeUniqueConstraints($tvname))
    {
?>
                <thead class="thead-dark">
                  <tr>
                    <th>CONSTRAINT</th>
                    <th>Columns #</th>
                    <th colspan="10">The list of constrained columns</th>
                    <th>find</th>
                    <th>method root</th>
                  </tr>
                </thead>
                <tbody>
<?php
      foreach($constraints as $constraint)
      {
        $constraintname=$constraint['CONSTRAINT_NAME'];
        $constrainedno=$constraint['CONSTRAINED_NO'];
        $constrainedcolumns=$constraint['CONSTRAINED_COLUMNS'];

        $XmlConstraints=false;
        $XmlConstraintsColumnsChanged=false;

        if($XmlTableViews && $XmlConstraints=$XmlTableViews[0]->xpath("constraint[@name='".$constraintname."']")) //if table and constraint exist in XQML
        {
          $method=(string)$XmlConstraints[0]['method'];
          $findercheckbox=(strtolower((string)$XmlConstraints[0]['finder'])==='yes') ? ' checked="checked"' : '';
          if((string)$XmlConstraints[0]['columns']!=$constrainedcolumns) $XmlConstraintsColumnsChanged=true;
        }
        if(!$XmlConstraints || $XmlConstraintsColumnsChanged)
        {
          $constrainedcolumnsen=array();
          $constrainedlist=explode(',',$constrainedcolumns);
          foreach($constrainedlist as $constrainedcolumnname)
          {
            $English=new English($constrainedcolumnname);
            $constrainedcolumnsen[]=$English->camel;
          }
          $method=implode('And',$constrainedcolumnsen);
          $findercheckbox=' checked="checked"';
        }
?>
                  <tr>
                    <td><b><?= $constraintname ?></b><?php if(!$XmlConstraints) echo ' <span class="badge badge-primary">NEW</span>'; ?></td>
                    <td><?= $constrainedno ?></td>
                    <td colspan="10"><?= $constrainedcolumns ?><?php if($XmlConstraintsColumnsChanged) echo ' <span class="badge badge-primary">CHANGED</span>'; ?></td>
                    <td align="center"><input type="checkbox" name="constrs[<?= $tvname ?>][<?= $constraintname ?>]" <?= $findercheckbox ?>></td>
                    <td><input type="text" name="methods[<?= $tvname ?>][<?= $constraintname ?>]" value="<?= $method ?>" class="form-control"></td>
                  </tr>
<?php
      }
?>
                </tbody>
<?php

    }
?>
              </table>

            </div><!-- .thumbnail -->
          </div><!-- .col -->
        </div><!-- .row -->

<?php
  }
?>
        <div class="row text-center">
          <div class="col-sm-4 offset-sm-4">
            <input type="checkbox" name="backup"> Make backup files<br>
          </div><!-- .col -->
        </div><!-- .row -->

        <div class="row text-center">
          <div class="col-sm-4 offset-sm-4">
            <button type="submit" name="p" class="btn btn-info" value="4">Build</button>
          </div><!-- .col -->
        </div><!-- .row -->

      </form>
<?php
}
catch (ConnectioException $ce)
{
?>
              <div class="alert alert-critical text-center"><i class="fa fa-exclamation-triangle fa-5x"></i><br>Cannot connect to database!<br><?= $ce->getHtmlMessage() ?></div>
<?php
}
?>
