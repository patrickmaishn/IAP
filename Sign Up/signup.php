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
    <style>
        body{
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a116a, #2575fc);
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2{
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: white;
        }

        form{
            background: white;
            color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background: #2575fc;
            color: #fff;
            border: none;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }

        form input[type="submit"]:hover {
            background: #6a11cb;
        }

        form select {
            background: #f5f5f5;
            border: 1px solid #ddd;
        }
        .message {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 20px;
        }
        
    </style>
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
        echo '<div class= "message">User was created successfully!</div>';
    }else{
        echo "<div>Unable to create user!</div>";
    }
?>

</body>
</html>