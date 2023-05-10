﻿<!DOCTYPE HTML>
<!--
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Future Imperfect by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../newspage/assets/css/main.css" />
		<link href="icheck-material.css" rel="stylesheet" type="text/css">
		<style>
			th { padding:100%; }
			label { margin:0; padding:1%; }
			hr { height: 30px; margin:0; padding:0; }
			.result tr { height:40px; }
		</style>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="../main.html">Webzin</a></h1>
						<nav class="links">
							<ul>
								<li><a href="../newspage/news.html">News</a></li>
								<li><a href="../newspage/col-table.php">Board</a></li>
								<li><a href="poll.html">Event</a></li>
								<li><a href="../gallerypage/gallery.html">Gallery</a></li>
							</ul>
						</nav>
					</header>

					<div id="main">

						<!-- Post -->
							<article class="post">
								<header>
									<div class="title">
										<h2><a href="index.html">Who's NEXT?</a></h2>
										<p>다음호 특집의 주인공은?</p>
									</div>
								</header>
<?PHP
// 실습: MySQL 연결하기 위하여 상위 폴더의 connDB.php 코드 재사용
include("../connDB.php");
// 실습: 사용자가 answer 입력 여부 확인하여 $answer 변수에 저장
$answer = $_POST['answer'];
$etc = $_POST['etc'];

if (!$answer)   {
	echo ("
		<script>
		window.alert('설문 항목을 선택해 주세요');
		history.go(-1);
		</script>
	     ");
	exit;
} else if ($answer == 4) {
	$sql = "select * from polletc where name='$etc';";
	$result = mysqli_query($con, $sql); 
		$row = mysqli_fetch_array($result);
		$total = mysqli_num_rows($result);
		//echo $total;
	if ($total != 0) {
		$cont = $row['cont'] + 1 ;
		$sql = "update polletc set cont=$cont where name='$etc';";
	} else {
		$sql = "insert into polletc values ('$etc', 1)";
	}
	//echo $sql;
	mysqli_query($con, $sql);
}

// 실습: poll 테이블을 검색하여 $result에 저장하는 코드 작성
$result = mysqli_query($con, "select * from poll;");         

// 실습: $result에 반환받은 레코드의 갯수를 $total에 얻어오는 코드 작성
$total = mysqli_num_rows($result);

if (!$total) { // 찾아진 레코드가 없으면 초기화 
	// 실습: $ans1, $ans2, $ans3, $ans4를 0으로 초기화
      $ans1 = 0;
      $ans2 = 0;
      $ans3 = 0;
      $ans4 = 0;
	  mysqli_query($con, "insert into poll values ($ans1, $ans2, $ans3, $ans4)");

	// 실습: 초기화한 변수를 poll에 추가

} else { // 레코드가 있으면 배열에서 얻어옴
	// 실습: $result에서 레코드 추출해서 $row에 저장
	$row = mysqli_fetch_array($result);
	// 실습: $row 배열에서 'ans1' 필드 추출하여 $ans1 변수에 저장
$ans1= $row['ans1'];
	// 실습: $row 배열에서 'ans2' 필드 추출하여 $ans2 변수에 저장
$ans2= $row['ans2'];
	// 실습: $row 배열에서 'ans3' 필드 추출하여 $ans3 변수에 저장
$ans3= $row['ans3'];
	// 실습: $row 배열에서 'ans4' 필드 추출하여 $ans4 변수에 저장
$ans4= $row['ans4'];
}

// 실습: switch 문으로 사용자 입력에 따라 설문 결과 수정 (6줄)
switch ($answer) {
case 1: $ans1++; break;
case 2: $ans2++; break;
case 3: $ans3++; break;
case 4: $ans4++; break;
}

// 실습: 레코드를 갱신하는 sql 실행
mysqli_query($con, "update poll set ans1=$ans1, ans2=$ans2, ans3=$ans3, ans4=$ans4");

mysqli_close($con);  // 접속 종료

// 전체 응답자 수 계산
$total = $ans1 + $ans2 + $ans3 + $ans4;

// 비율 계산 및 막대 그래프 길이 계산
$ans1rate=  (int)(($ans1 / $total) * 100); // 차지하는 비율(백분율)
$ans1width= (int)(($ans1 / $total) * 300); // 항목별 막대그래프 길이
$ans2rate=  (int)(($ans2 / $total) * 100);
$ans2width= (int)(($ans2 / $total) * 300);
$ans3rate=  (int)(($ans3 / $total) * 100);
$ans3width= (int)(($ans3 / $total) * 300);
$ans4rate=  (int)(($ans4 / $total) * 100);
$ans4width= (int)(($ans4 / $total) * 300);

// 막대 그래프 표시 
?>
<table border='1' width='300px' class='result'>
	<tr><td colspan='4'>
        투표 결과(총 응답자 수 : <?=$total?> 명)</td></tr>
	<tr><th>항목</th>
	    <th>응답자수</th> <th>비율(%)</th>
      <th width='300'>막대그래프</th></tr>
	<tr><th>전미도</th>
	    <td><?=$ans1?></td> <td><?=$ans1rate?></td>
  	    <td><hr size='4' color='black' width='<?=$ans1width?>' height='10px'></td></tr>
	<tr><th>박강현</th>
	    <td><?=$ans2?></td><td><?=$ans2rate?></td>
      <td><hr size='4' color='black' width='<?=$ans2width?>' height='10px'></td></tr>
	<tr><th>민경아</th>
	    <td><?=$ans3?></td><td><?=$ans3rate?></td>
	    <td><hr size='4' color='black' width='<?=$ans3width?>' height='10px'></td></tr>
	<tr><th>기타</th>
	    <td><?=$ans4?></td><td><?=$ans4rate?></td>
	    <td><hr size='4' color='black' width='<?=$ans4width?>' height='10px'></td></tr>
  </table>
							</article>

					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>