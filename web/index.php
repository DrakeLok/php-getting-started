<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
filename 	: index.php
purpose  	: main application page
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
$page=isset($_SESSION['page'])?$_SESSION['page']:0;
$num_perpage=5;
$_SESSION['author'] = 'cahyadsn';
$_SESSION['ver']    = sha1(rand());
header('Expires: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
if(!isset($_SESSION['data_mbti_test'])){
	$query="SELECT * FROM mbti_test_statements";
	$result=pg_query($query) or die('Query failed: ' . pg_last_error());
	$data=array();
	while($row=pg_fetch_array($result, null, PGSQL_ASSOC))
		$data[]=$row;
	$_SESSION['data_mbti_test']=$data;
}else{
	$data=$_SESSION['data_mbti_test'];
}
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
	<meta name="author" content="Cahya DSN" />
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
	<meta name="keywords" content="MBTI, personality, test" />
	<meta name="description" content="MBTI (Myer Briggs Type Indicator) Personality Test ver <?php echo $version;?> created by cahya dsn" />
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
    <a href="#" class="w3-bar-item w3-button">Home</a>
		<div class="w3-dropdown-hover">
		  <button class="w3-button">Themes</button>
		  <div class="w3-dropdown-content w3-white w3-card-4" id="theme">
				<?php
				$color=array("black","brown","pink","orange","amber","lime","green","teal","purple","indigo","blue","cyan");
				foreach($color as $c){
					echo "<a href='#' class='w3-bar-item w3-button w3-{$c} color' data-value='{$c}'> </a>";
				}
				?>	
			</div>
		</div>
	</div>
</div>  
<div class="w3-container">
   <form action='result.php' method='post' id='mbti'>
	<input type="hidden" id="page" value="0">
    <div class="w3-card-4">
      <div class='w3-container'>
        <h2>&nbsp;</h2>
        <h2 class="w3-text-theme">Myer Briggs Type Indicator (<b>MBTI</b>) Test</h1>
        <div class="w3-row">
          <div class="w3-col s12">
			<p>
		    The following test is designed to measure your MBTI Personality type. 
			The Myers–Briggs Type Indicator (MBTI) is an introspective self-report questionnaire indicating differing psychological preferences in how people perceive the world and make decisions. 
			The test attempts to assign four categories: introversion or extraversion, sensing or intuition, thinking or feeling, judging or perceiving
			</p>
			<div class="w3-container w3-theme-l2 w3-section">
            <span onclick="this.parentElement.style.display='none'" class="w3-closebtn">x</span>
            <h3>Instruction</h3>
            <ul><li>Choose one answer in each of the 70 questions, and you must answer all the questions</li>
			<li>There are no right nor wrong answers to any of these questions.</li>
			<li>Answer the questions quickly, do not over-analyze them.  Some seem worded poorly.  Go with what feels best.</li>
			<li>Answer the questions as “the way you are”, not “the way you’d like to be seen by others”</li>
			</ul>
         </div>
          </div>
		  <h6>&nbsp;</h6>
        </div>   
		<div class="w3-row">
			<table class="w3-table w3-striped">
			  <thead>
				<tr class="w3-theme-d3">
				  <th>No</th>
				  <th colspan='2'>Questions</th>
				</tr>
			  </thead>
			  <tbody id='p0'>
				<?php
				$no=0;
				foreach($data as $d){
				  $c=rand()%2;
				  echo "
					<tr style='border-top:solid 1px #999;'>
					  <td rowspan='3' style='width:30px !important;'>".++$no."</td>
					  <td colspan='2'>{$d['question']}</td>
					</tr>
					<tr>
					  <td style='padding-left:16px !important;width:30px !important;' class='incomplete'><input type='radio' name='d[{$d['id']}]' value='1' class='w3-radio' ".(isset($_GET['auto'])?($c==0?'checked ':''):'')."required /></td>
					  <td class='right'>{$d['statement1']}</td>
					</tr>
					<tr>					
					  <td><input type='radio' name='d[{$d['id']}]' value='2' class='w3-radio' ".(isset($_GET['auto'])?($c==1?'checked ':''):'')."required /></td>
					  <td>{$d['statement2']}</td>
					</tr>
					   ";
				  if($no%$num_perpage==0) {
					echo "</tbody><tbody style='display:none' id='p".round($no/$num_perpage)."'>";
				  }
				}
				?>
			  </tbody>
			</table>
		</div>
		<h6>&nbsp;</h6>
        <div class="w3-row w3-theme-l3">
		  <div class="w3-col s6 w3-padding">
			<button class="w3-button w3-round-large w3-theme-d1 w3-margin-8 w3-disabled" id="btn_prev" disabled>previous</button>
			<button class="w3-button w3-round-large w3-theme-d1 w3-margin-8" id="btn_next">next</button>
          </div>
          <div class="w3-col s6 w3-padding">
            <input type='submit' value='process' id='btn_send' class='w3-button w3-round-large w3-theme-d1 w3-right w3-margin-8 w3-disabled' disabled/>
		  </div>
		</div>
		<h6>&nbsp;</h6>
		<div><b>source code (v0.1) </b> : <a href='https://github.com/cahyadsn/mbti_test'>https://github.com/cahyadsn/mbti_test</a></div>
        <h2>&nbsp;</h2>
      </div>
    </div>		
	</form>
</div>
<div class="w3-bottom">
	<div class="w3-bar w3-theme-d4 w3-center w3-padding">
		MBTI Test v<?php echo $version;?> copyright &copy; 2021<?php echo (date('Y')>2021?date('-Y'):'');?> by <a href='mailto:cahyadsn@gmail.com'>cahya dsn</a><br />
	</div>
</div>
<div id="warning" class="w3-modal">
  <div class="w3-modal-content">
    <header class="w3-container w3-red"> 
      <span onclick="document.getElementById('warning').style.display='none'" class="w3-closebtn w3-hover-red w3-container w3-padding-8 w3-display-topright" title="Close Modal">&times;</span>
      <h2>Warning</h2>
    </header>
    <div class="w3-container">
      <p id='msg'></p>
    </div>
    <footer class="w3-container w3-border-top w3-padding-16 w3-light-grey">
      <a href='#' onclick="document.getElementById('warning').style.display='none'" class="w3-button w3-grey">close</a>
    </footer>
  </div>
</div>
<script src="<?php echo _ASSET;?>js/mbti_test.v1.0.php?v=<?php echo md5(filemtime(_ASSET.'/js/mbti_test.v1.0.php'));?>"></script>     
</body>
</html>
