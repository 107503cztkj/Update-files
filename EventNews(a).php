<?php
session_start();
include("db-contact.php"); 
include("timeout.php"); 
error_reporting(0);
?>

<?php 
if($_SESSION['email'] == null)
{
	echo "<script>alert('您無權限觀看此頁面!請先登入!'); location.href = 'login.php';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>|益尋愛|</title>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="css/myDropdownMenu.css" rel="stylesheet" type="text/css" />
<link href="css/EventNews.css" rel="stylesheet" type="text/css" />
<link href="css/Head.css" rel="stylesheet" type="text/css" />
<link href="css/Search(simple2).css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/footer.css" rel="stylesheet" type="text/css" />
<link href="css/totop.css" rel="stylesheet" type="text/css" />

</head>
<body>

<body>
	<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
	<div id="header-wrapper">
		<div class="container">
			<div id="header"> 
				<div id="logo"></div>
				<!--~~~~~~~~~~~~~~~~~~-->         
				<!--~~~導覽列~~~-->  
				<div class="navbar" >
					<ul>
						<li class="dropdown">
							<a class="dropdown-toggle" href="Index(a).php">訊息專欄</a>
							<ul class="dropdown-menu" >
								<a href="Downloadlist.php"><li>下載專區</li></a>
								<a href="BSthing.php"><li>桃園大小事</li></a>
								<a href="NewNews.php"><li>最新消息</li></a>
							</ul>
						</li>
						<li><a href="EventNews(a).php">活動快訊</a></li>
						<li><a href="Organization.php">公益組織</a></li>
						<li><a href="History(a).php">愛心回顧</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" href="About.php">關於益尋愛</a>
							<ul class="dropdown-menu">
								<a href="Q_A.php"><li>益尋愛Q&A </li></a>
							</ul>
						</li>
						<li class="dropdown">
						  <a class="dropdown-toggle" href="UserFile.php">益寶小檔案</a>
						  <ul class="dropdown-menu" >
								<a href="logout.php"><li>登出</li></a>
						  </ul>	
						</li>
					</ul>            
				</div>   
			</div>
			<!--~~~~~~~~~~~~--> 

			<!------------------------------------------------>
			<!--定義列表--------------------------------------->
			<!------------------------------------------------>
			<div class="love">

				<div class="act-select">
					<select>
						<option value="0">活動地區</option>
						<option value="1">北部</option>
						<option value="2">中部</option>
						<option value="3">南部</option>

					</select>
				</div>
				<div class="act-select">
					<select>
						<option value="0">活動類型</option>
						<option value="1">社區服務</option>
						<option value="2">公益義賣</option>
						<option value="3">社會援助</option>
						<option value="4">教育助學</option>
					</select>
				</div>
				<div class="act-select" >
					<select>
						<option value="0">開始日期</option>	
						
					</select>
				</div></center>
				<div class="act-select" >
					<select>
						<option value="0">結束日期</option>	
						
					</select>
				</div>
			<!-- The form -->

				<form class="example" action="/action_page.php" style="margin:auto;max-width:400px">
					<input type="text" placeholder="搜尋活動" name="search2">
					<button type="submit"><i class="fa fa-search"></i></button>
					<div class="addbt">
						<a href="AddEvent.php"><img src="images/addbt.png" title="新增活動"></a>
					</div>
				</form>
				
			</div> 

	<!------------------------------------------------>
	<!--定義列表--------------------------------------->
	<!------------------------------------------------>
	<div class="content">   		       
		<?php
		$sql="select * from event order by add_time desc";
		$result=mysql_query($sql) or die(mysql_error());
		?>
		<?php 
			$data_nums = mysql_num_rows($result); //統計總比數
			$per = 9; //每頁顯示項目數量
			$pages = ceil($data_nums/$per); //取得不小於值的下一個整數
			if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
				$page=1; //則在此設定起始頁數
			} else {
				$page = intval($_GET["page"]); //確認頁數只能夠是數值資料
			}
			$start = ($page-1)*$per; //每一頁開始的資料序號
			$result = mysql_query($sql.' LIMIT '.$start.', '.$per) or die("Error");
		?>
		
		<?php
		for($i=1;$i<=mysql_num_rows($result);$i++){
		$row=mysql_fetch_array($result);
		
		$count=0;
		$sql2 = "SELECT * FROM  applicationform where eventID='$row[eventID]'";
		$data2 = mysql_query($sql2) or die(mysql_error());
		for($j=1;$j<=mysql_num_rows($data2);$j++){
			$count++;
		}
		
		if($count>=$row['need']){
			$statusPic="fullbutton.png";
		}else if($row['DeadlineDate']< date("Y-m-d")){
			$statusPic="overbutton.png";
		}else if($row['DeadlineDate'] >= date("Y-m-d")){
			$statusPic="joinbutton.png";
		}
		
		?>
		<div class="item">
			<div class="photo"><img class="photo" src="upload/<?php echo $row['eventPic'] ?>"></div>
				<table>
					<tr>
						<td colspan="2"><b><a href="Event(a).php?f=<?php echo $row['eventID']?>"><font size="+1.5" color="#f29bda"><?php echo $row['eventName']?></font></a></b></td>
					</tr>
					<tr>
						<td colspan="2"><font color="#8dc7fc"><?php echo mb_substr($row['description'],0,14,"utf-8")?>....</font></td>
					</tr>
					<tr>
						<td colspan="2"><font color="#a2acb5">活動日期: <?php echo $row['startDate']?></font></td>
					</tr>
					<tr>
						<td rowspan="2" ><font color="#a2acb5">需求人數: <?php echo $row['need']?>人</font></td>
					</tr>
					<tr>
						<td><font color="#a2acb5">已報名人數: 12人</font></td>
					</tr>
					<td colspan="2" class="button"><a href="Event(a).php?f=<?php echo $row['eventID']?>"><img src="images/<?php echo $statusPic ?>"></td>
				</table>
		</div>
		<?php
		}
		?>
	
    </div>
		<div class="number">
	<?php
			//分頁頁碼
			echo "<br /><a href=?page=1>首頁</a> ";
			for( $i=1 ; $i<=$pages ; $i++ ) {
				if ( $page-3 < $i && $i < $page+3 ) {
					echo "[<a href=?page=".$i.">".$i."</a>] ";
				}
			} 
			echo " <a href=?page=".$pages.">末頁</a><br /><br />";
		?>
		</div>
    </div> 
    </div>
	
	<!------------------------------------------------>
	<!------------------------------------------------>
    <div class="totop">
        <img src="images/totop.png" id="btn">
	</div>
	
	<div class="back">
		<label><img src="images/back.png" title="回到上一頁">
			<input type="button" class="backbt" value="返回" onclick="javascript:history.go(-1)" />
		</label>
	</div>

	<!------------------------------------------------>
	<!------------------------------------------------>
    
 	<div class="footer">
                <h3>Copyright © 2018 益尋愛  怡仁愛心基金會</h3> 
    </div> 		
    

    <!--==========================================-->  
    
    <!--*********-->
    <!-- 載入js  -->
    <!--*********-->
    <!--*********-->
    <!-- 載入js  -->
    <!--*********-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    
	<script src="js/totop.js"></script>

	<script src="js/navbar.js"></script>
    <script src="js/select.js"></script>  
    <script src="js/myDropdownMenu.js"></script> 

           
</body>
</html>