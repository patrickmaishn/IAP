<?php
class Database {
    private $host =  "localhost";
    private $db_name = "iap_d";
    private $username = "root";
    private $password = "Patrickmaina05$";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

class User{
    private $conn;
    private $table_name = "users";

    public $fullname;
    public $username;
    public $email;
    public $password;
    public $genderId;
    public $roleId;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createUser(){
        $query = "INSERT INTO " . $this->table_name . " (fullname, username, email, password, genderId, roleId) VALUES (:fullname, :username, :email, :password, :genderId, :roleId)";
        $stmt = $this->conn->prepare($query);

        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); // Hash password for security
        $this->genderId = htmlspecialchars(strip_tags($this->genderId));
        $this->roleId = htmlspecialchars(strip_tags($this->roleId));


        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":genderId", $this->genderId);
        $stmt->bindParam(":roleId", $this->roleId);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

}

if($_POST) {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->fullname = $_POST['fullname'];
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->genderId = $_POST['genderId'];
    $user->roleId = $_POST['roleId'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form method = "POST" action="signup.php">
        Full Name: <input type="text" name="fullname" required><br>
        Username: <input type="text" name="username" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Gender: <select name="genderId" required>
            <option value="1">Male</option>
            <option value="2">Female</option>
        </select><br>
        Role: <select name="roleId" required>
            <option value="1">Admin</option>
            <option value="2">User</option>
        </select><br><br>
        <input type="submit" value="Sign Up">
    </form>
    <?php
    if($user->createUser()){
        echo '<div>User was created successfully!</div>';
    }else{
        echo "<div>Unable to create user!</div>";
    }
?>

</body>
</html>