<div class="content-wrapper" style="min-height: 1203.6px; background-color: rgb(227, 227, 242)">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admin Members</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../../View/Admin_home">Home</a></li>
                        <li class="breadcrumb-item active">Admin Members</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <!-- container -->
    <div class="container">

 <?php
// include database connection
include 'config/database.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";

// if it was redirected from delete.php
if($action=='deleted'){
echo "<div class='alert alert-success'>Record was deleted.</div>";
}

// select all data
$query = "SELECT id, name, description, price FROM products ORDER BY id DESC";
$stmt = $con->prepare($query);
$stmt->execute();

// this is how to get number of rows returned
$num = $stmt->rowCount();

// link to create record form
echo "<a href='create.php' class='btn btn-primary m-b-1em'>New Admin</a>";

echo "<br> <br>";
//check if more than 0 record found
if($num>0){

//start table
echo "<table>";

//creating our table heading
echo "<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Action</th>
</tr>";

// retrieve our table contents
// fetch() is faster than fetchAll()
// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
// extract row
// this will make $row['firstname'] to
// just $firstname only
extract($row);

// creating new table row per record
echo "<tr>
 <td>{$id}</td>
 <td>{$name}</td>
 <td class='description'>{$description}</td>
 <td> $ {$price}</td>
 <td>";
     // read one record
     echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Informations</a>"; 
    
     // we will use this links on next part of this post
     echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";

     // we will use this links on next part of this post
     echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
 echo "</td>";
echo "</tr>";
}

// end table
echo "</table>";


}

// if no records found
else{
echo "<div class='alert alert-danger'>No records found.</div>";
}
?>

</div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type='text/javascript'>
// confirm record deletion
function delete_user (id) {

var answer = confirm('Are you sure?');
if (answer) {
 // if user clicked ok,
 // pass the id to delete.php and execute the delete query
 window.location = 'delete.php?id=' + id;
}
}
</script>
    </section>
</div>