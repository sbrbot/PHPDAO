      <div class="row">

        <div class="col-12">

          <div class="alert alert-info"><b>PHP DAO Builder</b> is web application which generates <b>persistence (DAO) layer</b> in PHP for <b>MySQL database</b>.</div>
          <p>The whole process of creating DAO layer (ORM) consists of these four steps:</p>
          <ol>
            <li> Connect to your MySQL database schema you want to generate DAO layer for.<br>
                 (PHP DAO Builder will read all tables, views, indexes, and foreign keys in given schema.)</li>
            <br>
            <li> Define which tables/views should be included in your DAO layer and what should be the names of corresponding mapped objects.<br>
                 (PHO DAO Builder will read all columns and their attributes from previously selected tables/views.)</li>
            <br>
            <li> Define what columns should be included, what methods created, and what will be their names.<br>
                 (PHP DAO Builder will suggest initial settings of methods according to column attributes: primary keys, foreign keys, existence of index, etc.).</li>
            <br>
            <li> Proceed and PHP DAO Builder will create the complete DAO layer with classes.</li>
          </ol>
          <div class="alert alert-info">
            <b>PHP DAO Builder</b> stores all DAO setting (object/method names, etc.) into <b>model/dao.xml</b> for later DAO layer rebuilding.<br>
            Next time when you run DAO Builder, it will read <b>dao.xml</b> and your schema, show if some DB entities were changed inside DB from last build up
            and recreate new DAO layer according to your new settings. Only DAO classes will be rebuilt/overwritten, not your entity (Business layer) classes.
          </div>

        </div><!-- .col -->
      </div><!-- .row -->

      <div class="row text-center">
        <div class="col-12">
          <a href="index.php?p=1" class="btn btn-info">OK</a>
        </div><!-- .col -->
      </div><!-- .row -->
