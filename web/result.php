<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename 	: result.php
purpose  	: result page
create   	: 20210210
last edit	: 20220510
author   	: cahya dsn
demo site 	: https://psycho.cahyadsn.com/mbti_test
soure code 	: https://github.com/cahyadsn/mbti_test
================================================================================
This program is free software; you can redistribute it and/or modify it under the
terms of the MIT License.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

See the MIT License for more details

copyright (c) 2022 by cahya dsn; cahyadsn@gmail.com
================================================================================*/
session_start();
include 'inc/config.php';
$version = 0.2;
$c=isset($_SESSION['c'])?$_SESSION['c']:(isset($_GET['c'])?$_GET['c']:'indigo');
$_SESSION['author'] = 'cahyadsn';
$_SESSION['ver']    = sha1(rand());
header('Expires: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
if(isset($_POST['d'])){
  $a=$b=array();
  for($i=1;$i<=60;$i++){
    $a[$i]=isset($_POST['d'][$i]) && $_POST['d'][$i]==1?1:0;
    $b[$i]=isset($_POST['d'][$i]) && $_POST['d'][$i]==2?1:0;
  }
  $I=($b[60]+$b[52]+$a[45]+$a[38]+$b[35]+$a[31]+$a[29]+$b[28]+$a[20]+$a[15]+$a[11]+$a[10]+$b[7]+$b[5]+$a[2])/15;
  $E=($a[60]+$a[52]+$b[45]+$b[38]+$a[35]+$b[31]+$b[29]+$a[28]+$b[20]+$b[15]+$b[11]+$b[10]+$a[7]+$a[5]+$b[2])/15;
  $S=($a[53]+$a[51]+$a[46]+$a[43]+$a[41]+$a[36]+$a[34]+$a[27]+$a[25]+$b[22]+$b[18]+$a[16]+$a[13]+$a[8]+$b[6])/15;
  $N=($b[53]+$b[51]+$b[46]+$b[43]+$b[41]+$b[36]+$b[34]+$b[27]+$b[25]+$a[22]+$a[18]+$b[16]+$b[13]+$b[8]+$a[6])/15;
  $T=($a[58]+$a[57]+$a[55]+$b[49]+$a[48]+$a[42]+$b[39]+$a[37]+$a[23]+$b[32]+$a[30]+$a[17]+$b[9]+$a[4]+$a[14])/15;
  $F=($b[58]+$b[57]+$b[55]+$a[49]+$b[48]+$b[42]+$a[39]+$b[37]+$b[23]+$a[32]+$b[30]+$b[17]+$a[9]+$b[4]+$b[14])/15;
  $J=($b[59]+$a[56]+$a[54]+$b[50]+$a[47]+$b[44]+$b[40]+$b[33]+$b[26]+$a[24]+$b[21]+$a[19]+$b[12]+$a[3]+$b[1])/15;
  $P=($a[59]+$b[56]+$b[54]+$a[50]+$b[47]+$a[44]+$a[40]+$a[33]+$a[26]+$b[24]+$a[21]+$b[19]+$a[12]+$b[3]+$a[1])/15;
  $resultStr=($I>$E?'I':'E').($S>$N?'S':'N').($T>$F?'T':'F').($J>$P?'J':'P');
  $query="SELECT * FROM mbti_test_interprestation WHERE symbol='{$resultStr}' ";
  $result = pg_query($db, $query) or die('Query failed: ' . pg_last_error());
  $data=pg_fetch_array($result, null, PGSQL_ASSOC);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>MBTI Test</title>
	<meta charset="utf-8" />
    <meta http-equiv="expires" content="<?php echo date('r');?>" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="content-language" content="en" />
	<!-- <meta name="author" content="Cahya DSN" /> -->
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<meta name="keywords" content="MBTI, personality, test" />
	<meta name="description" content="MBTI (Myer Briggs Type Indicator) Personality Test ver <?php echo $version;?> " />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="<?php echo _ASSET;?>img/favicon.ico" type="image/x-icon">
<?php if(_ISONLINE):?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">
<?php else:?>
	<link rel="stylesheet" href="<?php echo _ASSET;?>css/w3.css">
	<link rel="stylesheet" href="<?php echo _ASSET;?>css/w3-theme-<?php echo $c;?>.css" media="all" id="mbti_css">
<?php endif;?>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<style>body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif} td.incomplete {color:red !important;}
	  .w3-closebtn {text-decoration: none;float: right;font-size: 24px;font-weight: bold;color: inherit;} .w16left{padding-left:16px !important;}</style>
<?php if(_ISONLINE):?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php else:?>
	<script src="<?php echo _ASSET;?>js/jquery.min.js"></script>
<?php endif;?>
  </head>
  <body>
  <div class="w3-top">
  <div class="w3-bar w3-theme-d5">
    <span class="w3-bar-item"># MBTI Test v<?php echo $version;?></span>
    <!-- <a href="#" class="w3-bar-item w3-button">Home</a> -->
		<!-- <div class="w3-dropdown-hover">
		  <button class="w3-button">Themes</button>
		  <div class="w3-dropdown-content w3-white w3-card-4" id="theme">
				<?php
				$color=array("black","brown","pink","orange","amber","lime","green","teal","purple","indigo","blue","cyan");
				foreach($color as $c){
					echo "<a href='#' class='w3-bar-item w3-button w3-{$c} color' data-value='{$c}'> </a>";
				}
				?>
			</div>
		</div> -->
	</div>
</div>
<div class="w3-container">
    <h2>&nbsp;</h2>
	<div class="w3-card-4">
		<h1 class='w3-padding w3-theme-d1'><?php echo $data['symbol'];?></h1>
		<h2 class='w3-theme-l2' style='padding-left:20px;'><em><?php echo $data['short'];?></em></h2>
		<div class='w3-container'>
			<div class='result'>
				<b>Description</b><br />
				<?php echo $data['description'];?>
			</div>
			<div class='result'>
				<b>Jungian functional preference ordering:</b><br />
				<?php echo $data['ordering'];?>
			</div>
			</div>
			<h2 class='w3-theme-l3' style='padding-left:20px;'><?php echo $data['symbol'];?> Relationships</h2>
			<div class='w3-container'>
				<div class='result'>
					<?php echo $data['relationships'];?>
				</div>
				<div class='result'>
					<b><?php echo $data['symbol'];?> Strengths:</b><br />
					<?php echo $data['strengths'];?>
				</div>
				<div class='result'>
					<b><?php echo $data['symbol'];?> Weakness:</b><br />
					<?php echo $data['weakness'];?>
				</div>
				
			</div>
			<h2 class='w3-theme-l3' style='padding-left:20px;'><?php echo $data['symbol'];?> Personality Growth</h2>
			<div class='w3-container'>
				<div class='result'>
					<p>Perhaps the most important realization that an individual can make in their quest for personal growth is that there is no single formula that defines the path to personal success. We all have different goals and priorities, which means that different activities and attitudes will make us feel good about ourselves. We also have different natural strengths and weaknesses that are a part of our inherent personality type. How then, as individuals, can we feel successful in our lives?</p>
					<b>What does Success mean to an <?php echo $data['symbol'];?>?:</b><br />
					<?php echo $data['success_mean'];?>
				</div>
				<div class='result'>
					<b>Allowing Your <?php echo $data['symbol'];?> Strengths to Flourish:</b><br />
					<?php echo $data['flourish_strengths'];?>
				</div>
				<div class='result'>
					<b>Potential Problem Areas:</b><br />
					<?php echo $data['problems'];?>
				</div>
				<div class='result'>
					<b>Explanation of Problems:</b><br />
					<?php echo $data['problems_explanation'];?>
				</div>
				<div class='result'>
					<b>Solutions:</b><br />
					<?php echo $data['solutions'];?>
				</div>
				<div class='result'>
					<b>Living Happily in our World as an <?php echo $data['symbol'];?></b><br />
					<?php echo $data['living'];?>
				</div>
				<div class='result'>
					<b>Specific suggestions:</b><br />
					<?php echo $data['suggestions'];?>
				</div>
				<div class='result'>
					<b>Ten Rules to Live By to Achieve <?php echo $data['symbol'];?> Success</b><br />
					<?php echo $data['ten_rules'];?>
				</div>
			</div>
			<h2 class='w3-theme-l3' style='padding-left:20px;'>Careers for <?php echo $data['symbol'];?> Personality Type</h2>
			<div class='w3-container'>
				<p>Whether you're a young adult trying to find your place in the world, or a not-so-young adult trying to find out if you're moving along the right path, it's important to understand yourself and the personality traits that will impact your likeliness to succeed or fail at various careers. It's equally important to understand what is really important to you. When armed with an understanding of your strengths and weaknesses, and an awareness of what you truly value, you are in an excellent position to pick a career that you will find rewarding.</p>
				<div class='result'>
					<b><?php echo $data['symbol'];?>s generally have the following traits:</b><br />
					<?php echo $data['traits'];?>
				</div>
				<div class='result'>
					<b>Possible Career Paths for the <?php echo $data['symbol'];?></b><br />
					<?php echo $data['profession'];?>
				</div>
				<div class='result'>
					<b>Partner:</b><br />
					<?php echo $data['partner'];?>
				</div>
			</div>
			<h2>&nbsp;</h2>
		</div>
	</div>
</div>
<div class="w3-bottom">
	<div class="w3-bar w3-theme-d4 w3-center w3-padding">
		MBTI Test v<?php echo $version;?> copyright &copy; 2021<?php echo (date('Y')>2021?date('-Y'):'');?> by <a href='www.cooljobz.com'>Cooljobz</a><br />
	</div>
</div>
<script src="<?php echo _ASSET;?>js/mbti_test.v1.0.php?v=<?php echo md5(filemtime(_ASSET.'/js/mbti_test.v1.0.php'));?>"></script>
</body>
</html>
<?php
}