<!DOCTYPE html>
<html lang="ko">
  <head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>YC BBANG</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

  <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>

  <link rel="stylesheet" href="css/new_product.css">
  

  <link rel="shortcut icon" type="image/x-icon" href="https://www.k-bread.com/favicon.ico">


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.html"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
  
       
         
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              ORDER
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              <li><a class="dropdown-item" href="#">주문하기</a></li>
              
            </ul>
          </li>
      
      </ul>
     <ul class="navbar-nav">
		<a href="logout.php" id="Login"><img src="img/login.png" alt="" width="20px" style="margin-right: 10px;">Logout</a>
        
         </ul> 

    </div>
  </div>
</nav>

<header class="new_product">
  <div class="container" id="con1" style="margin-top: 150px;">

   <div class="row" >
     <p style="text-align: center;">
     <h2 class="obj1" id="s1">주문결과</span></p>
   
  
     </div>
 
   </div>
 </header>


 
 
    <div class="container category">
      <div class="row">
        <div class="col col1" id="new_product" style="font-family: 'GmarketSansLight'; cursor: pointer;" onclick="location.href='#';">
          주문결과
        </div>
      </div>
    </div>

    
    <div class="container text-center" id="con1">
      <div class="line"></div>
      <h3 class="sub-title" style="font-family: 'KOTRA_BOLD-Bold';">주문결과는 데이터베이스에 전달됩니다.</h3>



      <div class="row">
<?php
session_start();
         
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POST 데이터에서 상품 정보 가져오기
    if (isset($_POST['breadname']) && isset($_POST['breadprice']) && isset($_POST['quantity'])) {
        $breadNames = $_POST['breadname'];
        $breadPrices = $_POST['breadprice'];
        $quantities = $_POST['quantity'];
		$totalPriceAll = 0; // 전체 총 가격 변수 초기화
    $selectedBreadNames = []; // 빵 종류를 담을 빈 배열 초기화


        // 각 상품 정보 출력
		echo '<h1>' . $_SESSION['userId'] . ' 님이 주문하신 빵 종류는 </h1>';
        for ($i = 0; $i < count($breadNames); $i++) {
          
            $totalPrice = $breadPrices[$i] * $quantities[$i];
            if($quantities[$i]!=0){
              $selectedBreadNames[] = $breadNames[$i];
            echo "<p>상품명: " . $breadNames[$i] . ", 가격: " . $breadPrices[$i] . ", 수량: " . $quantities[$i] . ", 총 가격: " . $totalPrice . "</p>";
          }
			$totalPriceAll += $totalPrice; // 전체 총 가격 누적
	   }
     $allSelectedBreadNames = implode(", ", $selectedBreadNames);

		echo "<h1>선택하신 빵종류는 ". $allSelectedBreadNames . "이며, 전체 주문 총 가격은 " . $totalPriceAll . "</h1>";
     //이메일
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
$dd = $_SESSION["userId"];
// 데이터베이스에서 정보 가져오기 (예시: SELECT)
$sql = "SELECT uaddress FROM kbread WHERE uid = '$dd'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 가져온 데이터를 INSERT하기 (예시: INSERT)
    while($row = $result->fetch_assoc()) {
        $column1_value = $row["uaddress"];

        // 가져온 데이터를 이용하여 INSERT 쿼리 실행
        $insert_sql = "INSERT INTO orderd (uid, uaddress, kind, money) VALUES ('$dd', '$column1_value','$allSelectedBreadNames','$totalPriceAll')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "새로운 레코드가 성공적으로 추가되었습니다.";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "0개의 결과";
}
$conn->close();

    } else {
        echo "주문 정보가 올바르게 전달되지 않았습니다.";
    }
} else {
    echo "올바른 요청이 아닙니다.";
}
?>
        
        
      </div>
	  
	  
	  


    </div>

     <div class="container text-center" style="margin-top: 30px; margin-bottom: 30px;">    <!--이미지 컨테이너-->
    <img src="https://www.k-bread.com/_skin/sw_kor_1/img/sub/make_cake_banner.jpg" class="img-fluid" alt="">
  </div>

  
  <div style="background-color: #2F2B29; margin-top: 100px;  text-align: center;">
    <img src="https://www.k-bread.com/_skin/sw_kor_1/img/common/footer_logo.gif" alt="">
  <ul>
    <li class="footer-li"><a href="#" style="color: white; text-decoration: none;">이용약관</a></li> |
    <li class="footer-li"><a href="#" style="color: white; text-decoration: none;">개인정보처리방침</a></li> |
      <li class="footer-li"><a href="#" style="color: white; text-decoration: none;">인재채용</a></li> |
        <li class="footer-li"><a href="#" style="color: white; text-decoration: none;">협력 및 제안문의</a></li>
  </ul>
  <address style="color: white; font-family: 'GmarketSansLight';" >
    ㈜파치시에 김영모
    <span></span>
    대표 : 서민정
    <span></span>
    사업자번호 : 129-86-21289
    <span></span>
    통신판매업신고번호 : 제2009-경기성남-0368호
    <span></span>
    이메일 : kymbread@naver.com<br>
    경기 성남시 중원 사기막골로 159(상대원동 138-1) 금강하이테크밸리2차 108호
    <span></span>
    Tel: 031)737-4064
    <span></span>
    Fax: 031)737-4266
    <span></span>
    상담시간: 평일 9시~18시
    <span></span>
    <br>
    개인정보관리책임자: 김정희031-737-4064
    <span></span>
    *김영모과자점의 홈페이지는 ㈜파치시에 김영모에서 운영합니다.
    <br><br>
    <p>Copyright © 김영모과자점,  All Rights Reserved</p>
    
  </address>
  </div> 
    </body>
    </html>