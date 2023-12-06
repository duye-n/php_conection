<?php
require_once 'templates/header.php';
?>

<?php
$host     = 'localhost'; // Because MySQL is running on the same computer as the web server
$database = 'PHP_connect'; // Name of the database you use (you need first to CREATE DATABASE in MySQL)
$user     = 'root'; // Default username to connect to MySQL is root
$password = ''; // Default password to connect to MySQL is empty

// TO DO: CREATE CONNECTION TO DATABASE 
// Read file: https://www.w3schools.com/php/php_mysql_connect.asp

$db = new mysqli($host, $user, $password, $database);

// check connect
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
//   echo "Connected successfully";
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['message'])) :
    $username = $_POST['username'];
    $message = $_POST['message'];
    $db->query("INSERT INTO `posts`(`name`, `message`) VALUES ('$username','$message')");
// TO DO: INSERT NEW POST IN DATABASE
endif;
?>

<?php
// TO DO: SELECT ALL POSTS FROM DATABASE

$posts = $db->query("SELECT * FROM `posts`");


foreach ($posts as $post) :
    // var_dump($post);
?>
    <div class="card">
        <div class="card-header">
            <span><?php echo $post["name"] // TO DO: display the value of username for this post 
                    ?></span>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $post["message"] // TO DO: display the message for this post 
                                    ?></p>
        </div>
    </div>
    <hr>
<?php
endforeach;
?>

<form action="index.php" method="POST">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
        </div>
    </div>

    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Add new post</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>