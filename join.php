 <?php
	$uid = $_POST['uid'];
  $uname = $_POST['uname'];
  $uphone = $_POST['uphone'];
 $uaddress = $_POST['uaddress'];
  $upass = $_POST['upass'];
  
		// 데이터베이스 연결 정보
		$servername = "realbread.csjj47wsn6pa.us-east-1.rds.amazonaws.com"; // 데이터베이스 서버 이름
		$username = "root"; // 데이터베이스 사용자명
		$password = "rootroot"; // 데이터베이스 암호
		$dbname = "bread"; // 사용할 데이터베이스 이름

		// MySQL 연결 생성
		$conn = new mysqli($servername, $username, $password, $dbname);

		// 연결 확인
		if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }

//   if($conn)
//   echo "<h1>연결성공!</h1><br>";
// else
// echo "<h1>연결실패ㅠ</h1>";

$sql = "insert into kbread(uid,uname,uaddress,uphone,upass) values('$uid', '$uname','$uaddress,'$uphone','$upass')";
//2. 쿼리 날리기(테이블에 있는 모든 데이터 가지고 오기)
    mysqli_query($conn, $sql); 
    
   echo "<script>데이터가 성공적으로 추가되었습니다!</script>";
   
   mysqli_close($conn);
  //  echo $uid."<br>";
  // echo $uname."<br>";
  // echo $uphone."<br>";
  // echo $upass."<br>";
   
?>
<meta http-equiv="refresh" content="0; url=list.php">