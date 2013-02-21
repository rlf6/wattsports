<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include("../database.php");

$active1 ='active';
$active2 ='';
$active3 ='';
$active4 ='';
$active5 ='';
$active6 ='';
$active7 ='';
 $Title = "Wattsports";
$mobile ='';
include('./header.php');
?>
<script>
var bool = 0;

function order(id)
{
	
	if(id == 'time')
	{
		var elems = $('#board').children('li').remove();
		console.log(elems);
 
	
		//console.log(childs);
		for(var i =0; i < elems.length; i++)
		{
				var nid = elems[i].getAttribute('name');
				var store = elems[i].id;
			console.log(elems[i]);
			elems[i].setAttribute("name", store);
			elems[i].setAttribute("id", nid);
			
		}
			//$('#'+store).attr("name", store);
			//$('#'+store).attr("id", nid);
        
	//var elems = $('#board').children('li').remove();
	
		if(bool == 0)
		{	
			elems.sort(function(a,b){
				return parseInt(a.id) > parseInt(b.id);
			});
			bool = 1;

		}
		else
		{
			elems.sort(function(a,b){
				return parseInt(b.id) > parseInt(a.id);
			});
			bool = 0;
		}
		
		for(var i =0; i < elems.length; i++)
		{
				var nid = elems[i].getAttribute('name');
				var store = elems[i].id;
			console.log(elems[i]);
			elems[i].setAttribute("name", store);
			elems[i].setAttribute("id", nid);
			
		}
		
			$('#board').append(elems);
			
	}
	else
	{
		var elems = $('#board').children('li').remove();
		if(bool == 0){	
			elems.sort(function(a,b){
				return parseInt(a.id) > parseInt(b.id);
			});
			bool = 1;
			}
		else
		{
			elems.sort(function(a,b){
				return parseInt(b.id) > parseInt(a.id);
			});
			bool = 0;
		}
		$('#board').append(elems);
	}
	
		var rid = id+"-arrow";
	$("#"+rid).toggleClass('glyphicon-down-arrow glyphicon-up-arrow');
}

</script>

<div class="center_div" border="2px solid">
			<a  href="javascript:void(0)" onclick="showtabs();" >
			<span id='toggle' border='1px' style=" padding-right:185px; position:relative; top:40px; right:-918px;">
			
			</span></a>
				
			<div id='tabss' class='tabs'>
			
				<table id='tabs' >
				<tr><td>
				
				<ul class="nav nav-pills" style="height:15px;"> <li style="float:left; margin-left:7px;"><a id='rank' href="javascript:void(0)" onclick="order(id);" name='rank' ><i id='rank-arrow' class="glyphicon-down-arrow"></i> Importance</a></li> <li style="float:right; margin-right:7px;"><a id='time' href="javascript:void(0)" onclick="order(id);" ><i id='time-arrow' class="glyphicon-down-arrow"></i> Date </a> </li> </ul>
			
				<ul id="board" class="nav nav-tabs nav-stacked" style="height:auto;">
				<?
				$query = mysql_query("SELECT * FROM tabs ORDER BY `time` DESC");
				$num = mysql_num_rows($query);
				
				for($x =0;$x < $num;$x++)
				{
				$id = mysql_result($query,$x,0);
				$comment = mysql_result($query,$x,1);
				$url = mysql_result($query,$x,2);
				$rank = mysql_result($query,$x,3);
				$time = mysql_result($query,$x,4);
				echo"<li id='$rank' name='$time' ><a id=".$id." href=".$url.'?'.$id." style=' text-indent:-15px; padding-left:25px;'>".$rank.": ".$comment."  </a></li>";
				}
				?>
				
			</ul>
			</td></tr></table>
			</div>
			<div class='tabscover'>
				</div>
			<div class="scroll">

	
			<p> 
			Latest News: <br />
			Minimum Required Teams for tournament = 16 now instead of 20<br />
			Tickets Report now Daily instead of Weekly<br />
			Software Update Due: 25/06/2012<br />
			<br />
			Needing Attention:<br />
			Issues to be dealt with see Tabs to the right.<br />
			</p>
			<a href="http://www.wattsports.co.uk" />Wattsports</a>
			
			
 			</div>
		
		
			</div>
						
</div>

</div>
</html>