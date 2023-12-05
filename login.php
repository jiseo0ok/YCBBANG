<?php
$uid = $_POST['uid'];
$upass = $_POST['upass'];

$servername = "realbread.csjj47wsn6pa.us-east-1.rds.amazonaws.com";
$username = "root";
$password = "rootroot";
$dbname = "bread";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Using prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM kbread WHERE uid = ? LIMIT 1");
$stmt->bind_param("s", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    // Verify password using password_verify() function if passwords are hashed
    if ($row['upass'] === $upass) {

        // 세션 시작
        session_start();
        // 사용자 ID 세션 변수 설정
        $_SESSION['userId'] = $row['uid'];
        
?>
        <script>
            alert("로그인에 성공하였습니다.");
            location.href = "index1.php";
        </script>
<?php
    } else {
?>
        <script>
            alert("로그인에 실패하였습니다.");
            location.href = "login.html";
        </script>
<?php
    }
} else {
?>
    <script>
        alert("사용자를 찾을 수 없습니다.");
        location.href = "login.html";
    </script>
<?php
}

$stmt->close();
$conn->close();
?>
