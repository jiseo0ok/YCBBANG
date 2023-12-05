<?php
session_start();

// 모든 세션 변수 삭제
$_SESSION = array();

// 세션 쿠키 삭제
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 세션 삭제
session_destroy();

// 로그아웃 후 리다이렉트 또는 다른 작업 수행
header("Location: index.html");
exit;
?>
