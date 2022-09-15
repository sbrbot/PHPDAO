      <div class="ajax">
        <h2><a href="https://github.com/sbrbot/phpdao">Data Access Objects Builder on GitHub</a></h2>

        <p>This is simple web tool for automatic creation of DAO persistence layer classes from existing MySQL database schema.</p>

        <ul>
          <li>The lowest level of DAO class hierarchy is MySQLi databse singleton class <b>DataBase</b> (for DB connection) (username/password are stored in /models/DAO/DB.php),</li>
          <li>Above it is abstract <b>EntityBase</b> class with generic Create/Read/Update/Delete/Save methods (/models/DAO/DAO.php) for MySQL database in PHP,</li>
          <li>For each database table one DAO core class is created extending EntityBase (/models/DAO/*.dao.php) - these files are overwritten upon each DAO (re)building process</li>
          <li>Finally, for each database table one empty class is created (/models/*.php) where you should add your own business logic</li>
        </ul>
      </div>

      <hr>

      <h3>Files organization</h3>

      <table cellspacing="20">
        <tr>
          <th>DataModel for which DAO layer will be built</th>
          <th>File tree of DAO Builder</th>
          <th>File tree after building DAO layer</th>
        </tr>
        <tr>
          <td valign="top">
            <img src="images/model.png" alt="Database Model">
          </td>
          <td valign="top">
            <img src="images/tree.png" alt="File tree of DAO Builder">
          </td>
          <td valign="top">
            <img src="images/build.png" alt="File tree after building DAO">
          </td>
        </tr>
      </table>

      <hr>

      <h3>Database connection</h3>
      <p>Install PHPDAO with Composer and it will be stored in vendors/sbrbot/phpdao folder.</p>
      <p>(make root folder 'models' writable for PHPDAO) and start PHPDAO:</p>
      <p><a href="http://localhost/MyProject/vendors/sbrbot/phpdao/index.php">http://localhost/MyProject/vendors/sbrbot/phpdao/index.php</a></p>
      <div class="text-center"><img src="images/dao0.png" alt="PHPDAO - connection"></div>

      <hr>

      <h3>Database tables/views</h3>
      <p>The list of all tables from previously given db schema will be shown</p>
      <div class="text-center"><img src="images/dao1.png" alt="PHPDAO - tables/views"></div>
      <p>Select all tables you want to build DAO classes for. DAO PHP will try to guess name (singular and plural words) for each table/DAO class
         but don't rely on its english grammar capabilities :-). Put your own correct or other wanted names if necessary.
         For example, if inside database you have one-to-many relation between 'employees' and 'projects' tables,
         and for 'employees' table define 'Employee' (singular) and 'Employees' (plural) names
         and for 'projects' table define 'Project' (singular) and 'Projects' (plural) names, then PHP DAO will generate
         <b>Employee</b> class for 'employees' table and <b>getProjects()</b> function in it for retrieving related (many) objects from related table 'projects'
         and vice versa <b>getEmployee()</b> function for retrieving related (one) object inside <b>Project</b> class.</p>
      <p><u>NOTE</u>: Table comment (comment from database) will be used as initial description of class inside DAO code.
         PHP DAO uses CamelCase naming for classes (underscores are omitted), so if table name inside database is 'employees_projects',
         PHP DAO will guess that class name should be <b>EmployeeProject</b> (singular) and <b>EmployeeProjects</b> (plural)</p></p>

      <hr>

      <h3>Tables/views columns</h3>
      <p>Previously selected tables are shown with their columns and column attributes and relations to other tables.
         One can select here what columns should be included in DAO class build process. By default all columns are selected
         but you can exclude some of them if you want. (Primary key column(s) are selected and mandatory.)
         For example if column 'name' is selected, then class <b>Employee</b> will have protected property <b>name</b>.
         The similar thing is with finder functions, if you want particular finder functions for some columns, select them in finder column
         (columns that are indexed inside database are selected by default because PHP DAO assumes you want finder functions for them).
         So if finder is selected for column <b>name</b>, PHP DAO will create <b>findByName($name)</b> function (always prefixed with findBy).
         Here you defined creation of particular finder functions but, each DAO class will have generic 'find()' function
         you can use for searching/finding records by any column (columns given as associative array).</p>
      <p><u>NOTE</u>: Column comment (comment from database) will be used as initial description of property inside DAO code.
         PHP DAO uses CamelCase naming for properties (underscores are omitted), so if column name inside database is 'first_name',
         PHP will create finder function with name <b>findByFirstName($firstname)</b></p>
      <div class="text-center"><img src="images/dao2.png" alt="PHPDAO - columns"></div>

      <hr>

      <h3>DAO builder</h3>
      <p>PHP DAO generator starts and finally shows what classes have been created. (One DAO class for each selected table, plus DA.php and DAO.php core classes
        inside /models/DAO/ subfolder and one table class inside models for customization).
        vendors/sbrbot/phpdao folder can be deleted if you do not intend to rebuild DAO layer for tables in database. But after every database model change one should rebuild
        DAO layer to reflect changes made in tables/columns. Only /models/DAO/*.dao.php classes of DAO layer are overwritten (but backuped before if wanted).</p>
      <div class="text-center"><img src="images/dao3.png" alt="PHPDAO - builder"></div>

      <hr>

      <h2>Functions</h2>

      <p>PHP DAO can build DAO classes for both; single and composite primary key tables.
        (Single primary key (PK) table has only one column as primary key and it can be auto-incremented (AI).
        Composite primary key table has primary key which is combination of more columns and in this case auto-increment is not possible - primary keys should be defined explicitly.)
        So CRUD(S) ('Create', 'Read', 'Update', 'Delete', and 'Save') functions accept as parameter single primary key value or associative array of primary key names => values:</p>

      <hr>
        
      <h3>Create</h3><!-- -------------------------------------------------- -->

      Example #1:

      <pre>

        require 'models/Receipt.php';

        try
        {
          $Receipt = new Receipt();
          $Receipt->name = 'some name';
          $Product->create(); //PK is auto-incremented
          $receiptId = $Receipt->getId(); // return autoincremented PK
        }
        catch(CreateException $e)
        {
          //handle exception
        }
      </pre>

      Example #2:

      <pre>

        require 'models/Item.php';

        try
        {
          $Item = new Item();
          $Item->setReceiptId(1); // Relate with Receipt
          $Item->setName('some item');
          $Item->setPrice(10.0);
          $Usage->create();
          $itemId = $Item->getId(); // return autoincremented PK
        }
        catch(CreateException $e)
        {
          //handle exception
        }
      </pre>

      <hr>
        
      <h3>Read</h3><!-- ---------------------------------------------------- -->

      Example #1:

      <pre>

        require 'models/Receipt.php';

        try
        {
          $Receipt = new Receipt();
          $Receipt->setId(1);
          $Receipt->read();
        }
        catch(ReadException $e)
        {
          //handle exception
        }
      </pre>

      Example #2:

      <pre>

        require 'models/Receipt.php';
        require 'models/Item.php';

        try
        {
          $Receipt = new Receipt(1);
          $Items = $Receipt->getItems(); //returns array of Items
        }
        foreach($Items as $Item)
        {
          echo $Item->price;
        }
      </pre>

      <hr>
        
      <h3>Update</h3><!-- -------------------------------------------------- -->

      Example:

      <pre>

        require 'models/Receipt.php';

        try
        {
          $Receipt = new Receipt(1); //create object and read where id=1
          $Receipt->name='new name'; //change name of existing
          $Receipt->update(); //update new data
        }
        catch(UpdateException $e)
        {
          //handle exception
        }
      </pre>

      <hr>
        
      <h3>Delete</h3><!-- -------------------------------------------------- -->

      Example:

      <pre>

        require 'models/Receipt.php';

        try
        {
          $Receipt = new Receipt();
          $Receipt->delete(1);
        }
        catch(DeleteException $e)
        {
          //handle exception
        }
      </pre>

      <hr>
        
      <h3>Save</h3><!-- ---------------------------------------------------- -->

      <p>'save()' function inserts record but if record already exist or if any
        of referential constraints on this table is violated (unique key or referential
        constraint is violated) then existing record is updated.</p>

      <pre>

        require 'models/Receipt.php';

        try
        {
          $Receipt = new Receipt(1);
          $Receipt->name='new';
          $Receipt->save(); //insert or update
        }
        catch(SaveException $e)
        {
          //handle exception
        }
      </pre>

      <hr>
        
      <h3>Specific finders</h3><!-- ---------------------------------------- -->

      Example: (specific findByName() finder created by PHP DAO)

      <pre>

        require 'models/Receipt.php';

        $Receipt = new Receipt();
        $Receipt = $Receipt->findByName('new'); //returns array
        foreach($Receipts as $Receipt)
        {
          echo $Receipt->name;
        }
      </pre>

      <h3>Generic finder</h3>

      Example: (argument is associative array where keys are table column names)

      <pre>

        require 'models/Receipt.php';

        $Receipt = new Receipt();
        $Receipts = $Receipt->find(['name'=>'new','date'=>'2022-08-15']);
        foreach($Receipts as $Receipt)
        {
          echo $Receipt->total;
        }
      </pre>