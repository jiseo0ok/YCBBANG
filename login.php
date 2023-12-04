<?php

$uid = $_POST['uid'];
$upass = $_POST['upass'];


$servername = "realbread.csjj47wsn6pa.us-east-1.rds.amazonaws.com"; // 데이터베이스 서버 이름
		$username = "root"; // 데이터베이스 사용자명
		$password = "rootroot"; // 데이터베이스 암호
		$dbname = "bread"; // 사용할 데이터베이스 이름

		// MySQL 연결 생성
		$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM kbread WHERE upass = '{$upass}' AND uid = '{$uid}'";
$result=mysqli_query($conn,$sql);
$count = mysqli_num_rows($result);



for($i=0; $i<$count; $i++){
 $re=mysqli_fetch_row($result);



if ($re[1] === $uid && $re[4] === $upass) {
    // 로그인 성공
    // 세션에 id 저장
    // session_start();
    // $_SESSION['userId'];
    // print_r($_SESSION);
    // echo $_SESSION['userId'];
    
?>
    <script>
        alert("로그인에 성공하였습니다.")
        location.href = "index1.php";
    </script>

<?php
} else {
    // 로그인 실패 
?>
    <script>
        alert("로그인에 실패하였습니다.")
        location.href = "login.html";
    </script>
<?php
}
}
?>
