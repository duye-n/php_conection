<?php
require_once 'templates/header.php';

$host = 'localhost'; // Because MySQL is running on the same computer as the web server
$database = 'php_conn'; // Name of the database you use (you need first to CREATE DATABASE in MySQL)
$user = 'root'; // Default username to connect to MySQL is root
$password = ''; // Default password to connect to MySQL is empty

try {
    // TO DO: CREATE CONNECTION TO DATABASE
    $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['message'])) {
    $username = $_POST['username'];
    $message = $_POST['message'];

    try {
        // TO DO: INSERT NEW POST IN DATABASE
        $stmt = $db->prepare("INSERT INTO `postst`(`nameq`, `message`) VALUES (:username, :message)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    // TO DO: SELECT ALL POSTS FROM DATABASE
    $stmt = $db->query("SELECT * FROM `postst`");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($posts as $post) {
        // var_dump($post);
?>
        <div class="card">
            <div class="card-header">
                <span><?php echo $post["nameq"]; // TO DO: display the value of username for this post 
                        ?></span>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo $post["message"]; // TO DO: display the message for this post 
                                        ?></p>
            </div>
        </div>
        <hr>
<?php
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<form action="index.php" method="POST">
    <div class="row mb-3 mt-3">
        <div class="col">
            <!-- Đổi name="nameq" thành name="username" để phản ánh chính xác với tên cột trong cơ sở dữ liệu -->
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
