var id='';
var id2='';
var value='';
var blurid='';

function generate(data,type) {
	var n = noty({
		text: data,
		type: type,
		dismissQueue: true,
		timeout: '1500',
		layout: 'topRight',
		theme: 'defaultTheme'
	});
	console.log('html: '+n.options.id);
}

function confirm(id) {
	var n = noty(
	{
		text: 'Are you sure you wish to delete Hurdler with<br /> ID = '+id+'?<br /> Please note if a hurdler is in any race they will not be deleted.',
		type: 'alert',
		dismissQueue: true,
		layout: 'center',
		width: '250',
		theme: 'defaultTheme',
		buttons: [
		{	
			addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty)
			{
				$noty.close();
				noty({dismissQueue: true, timeout: '1000', force: true, layout: 'topRight', theme: 'defaultTheme', text: 'Deleting..', type: 'information'});
				$.post("./hurdlerdelete.php",{variable: id},
				function(data)
				{
					if(data == 'Successfully Deleted')
					{
					var type = "success";
					deleteRow('t'+id)
					}
					if(data == 'Delete was unsuccessful'){ 
					var type = "warning";
					}
					console.log(data);
					generate(data,type);
				});
			}
		},
		{
			addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty)
			{
				$noty.close();
				noty({dismissQueue: true, timeout: '1000', force: true, layout: 'topRight', theme: 'defaultTheme', text: 'Delete Cancelled', type: 'warning'});
			}
		}
	]});
	console.log('html: '+n.options.id);
}

function confirmW(id) {
	var pivot;
	if(id.length < 9) pivot =1;
	else pivot =0;
	var texts;
	if (pivot == 1) texts ='Are you sure you wish to delete Wattball Team Member with<br /> ID = '+id+'?<br /> Please note if a player is in any match they will not be deleted.';
	else texts ='Are you sure you wish to delete Wattball Team with<br /> ID = '+id+'?<br /> Please note if a Team is in any match they will not be deleted.';
	var n = noty(
	{
		text: texts,
		type: 'alert',
		dismissQueue: true,
		layout: 'center',
		width: '250',
		theme: 'defaultTheme',
		buttons: [
		{
			addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty)
			{
				$noty.close();
				noty({dismissQueue: true, timeout: '1000', force: true, layout: 'topRight', theme: 'defaultTheme', text: 'Deleting..', type: 'information'});
				nid = id+":"+pivot;
				$.post("./wattballdelete.php",{variable: nid},
				function(data) {
				if(data == 'Successfully Deleted')
				{
					var type = "success";
					//fixes the expand on delete.
					if(pivot == 0)
					{
						var row =document.getElementById('t'+id);
						if(row = document.getElementById('e'+id))
						{
							row.parentNode.removeChild( row );
						}
					}
					//
					deleteRow('t'+id)
				}
				if(data == 'Delete was unsuccessful')
				{ 
					var type = "warning";
				}
				console.log(data);
				generate(data,type);
				});
			}
		},
		{
			addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty)
			{
				$noty.close();
				noty({dismissQueue: true, timeout: '1000', force: true, layout: 'topRight', theme: 'defaultTheme', text: 'Delete Cancelled', type: 'warning'});
			}
		}
		]
	});
	console.log('html: '+n.options.id);
}

//function to record inital data in table for comparison 
$('body').live("focus","input",function() { 
	value = event.target.value;  
	id = event.target.id;
	console.log('focus');
});

///function that checks for changes in the table to update
$("input").live('focusout',function(){

	console.log('unfocus');
	id2 = event.target.id;
	var name = event.target.name;
	var value2 = event.target.value;
	///checks the two versions
	if (value != value2 && id == id2)
	{
		///validation checks
		if ( name == 'hurdler:dob' || name == 'watt:dob')
		{
			if( !validateDate( value2 ) )
			{
				generate( "Invalid date of birth.\nFormat: YYYY-MM-DD" ,"warning");
				return false;
			}
		}
		
		if ( name == 'hurdler:email' || name == 'watt:email' || name == 'team:email')
		{
			if( !validateEmail( value2 ) )
			{
				generate( "Invalid Email.\n" ,"warning");
				return false;
			}
		}
			if ( name == 'team:assoc_id')
		{
			if( !validateAssoc( value2 ) )
			{
				generate( "Invalid Association ID:<br /> Must be 9 Digits." ,"warning");
				return false;
			}		
		}
		
		
		if ( name =='team:mgr_name' || name == 'team:mgr_surname' || name == 'hurdler:name' || name == 'watt:name' || name == 'hurdler:surname' || name == 'watt:surname')
		{
			if( !validateName( value2 ) )
			{
				generate( "Invalid Name.\nMust be Letters only and have more than 2 characters" ,"warning");
				return false;
			}
		}
		
		if ( name == 'hurdler:id' || name == 'watt:member_id')
		{
			if( !validateId( value2 ) )
			{
				generate( "Invalid ID:<br /> Must be a positive integer " ,"warning");
				return false;
			}		
		}
		
		if ( name == 'hurdler:sex' || name == 'watt:sex')
		{
			if( !validateSex( value2 ) )
			{
				generate( "Invalid sex:<br /> 'm' or 'f'" ,"warning");
				return false;
			}		
		}
		if ( name == 'hurdler:phone' || name == 'watt:phone')
		{
			if( !validatePhone( value2 ) )
			{
				generate( "Invalid Phone Number:<br /> Number must be 11 digits" ,"warning");
				return false;
			}	
		}
		if ( name == 'watt:position')
		{
			if( !validatePos( value2 ) )
			{
				generate( "Invalid Position:<br /> 'GoalKeepr' or 'Defender' or 'Midfielder' or 'Forward'" ,"warning");
				return false;
			}		
		}
		if ( name == 'hurdler:previous_best')
		{
			if( !validateTime( value2 ) )
			{
				generate( "Invalid Time:<br /> Number must be valid" ,"warning");
				return false;
			}	

		}
		var id3 =id.substr(0,(id.length-1));
		var packet = id3+":"+name+":"+value2;
		$.post("./hurdlerupdate.php",{variable: packet},
		function(data)
		{
			if( data == "ID already Exists") generate(data,'warning');
			else
			{
				generate(data,'success');
				if(name == "team:assoc_id")
				{
					console.log('im here');
					var tid ='t'+value2;
					//changes row Id
					$('#t'+id3).attr("id",tid);
					//changes image ids for expand and delete.
					$('#'+id3).attr("id",value2);
					$('#'+id3).attr("id",value2);
					//change ids for rest of inputs
					for(var i=0;i < 8;i++)
					{
						var id =value2+i;
						$('#'+id3+i).attr("id",id);
					}
					//if expanded change id
					if(document.getElementById('e'+id3))
					{
						var eid ='e'+value2;
						$('#e'+id3).attr("id",eid);
					}
				}
			}
		});
	}
});



//delete row function
function deleteRow(id) {
	var tr = document.getElementById(id);
	if (tr)
	{
		if (tr.nodeName == 'TR')
		{
			var tbl = tr; // Look up the hierarchy for TABLE
			while (tbl != document && tbl.nodeName != 'TABLE')
			{
				tbl = tbl.parentNode;
			}
			if (tbl && tbl.nodeName == 'TABLE')
			{
				while (tr.hasChildNodes())
				{
					tr.removeChild( tr.lastChild );
				}
				tr.parentNode.removeChild( tr );
			}
		}
	}
}
//add row function
function addRow() {
	var table = document.getElementById('table');
	var rowCount = table.rows.length;
	var lastid = $('#table tr:last').attr('id');
	var size = lastid.length;
	var id = lastid.substr(1,size);
	console.log(id);
	var row = table.insertRow(rowCount);
	var colCount = table.rows[0].cells.length;
	id= parseInt(id)+1;
	row.id = 't'+id;
	var cell1=row.insertCell(0);
	var cell2=row.insertCell(1);
	var cell3=row.insertCell(2);
	var cell4=row.insertCell(3);
	var cell5=row.insertCell(4);
	var cell6=row.insertCell(5);
	var cell7=row.insertCell(6);
	var cell8=row.insertCell(7);
	var cell9=row.insertCell(8);
	var cell10=row.insertCell(9);
	var		newInput1 = document.createElement('input'); newInput1.id = id+'0'; newInput1.name = 'id'; newInput1.size = '2'; newInput1.value = id;
	cell1.appendChild(newInput1);
	var		newInput2 = document.createElement('input'); newInput2.id = id+'1';	newInput2.name = 'name'; newInput2.size = '4'; newInput2.value = '';
	cell2.appendChild(newInput2);
	var		newInput3 = document.createElement('input'); newInput3.id = id+'2';	newInput3.name = 'surname'; newInput3.size = '4'; newInput3.value = '';
	cell3.appendChild(newInput3);
	var		newInput4 = document.createElement('input'); newInput4.id = id+'3';	newInput4.name = 'address'; newInput4.size = '24'; newInput4.value = '';
	cell4.appendChild(newInput4);
	var		newInput5 = document.createElement('input'); newInput5.id = id+'4';	newInput5.name = 'phone'; newInput5.size = '10'; newInput5.value = '';
	cell5.appendChild(newInput5);
	var		newInput6 = document.createElement('input'); newInput6.id = id+'5';	newInput6.name = 'email'; newInput6.size = '25'; newInput6.value = '';
	cell6.appendChild(newInput6);
	var		newInput7 = document.createElement('input'); newInput7.id = id+'6';	newInput7.name = 'dob'; newInput7.size = '8'; newInput7.value = '';
	cell7.appendChild(newInput7);
	var		newInput8 = document.createElement('input'); newInput8.id = id+'7';	newInput8.name = 'sex'; newInput8.size = '2'; newInput8.value = '';
	cell8.appendChild(newInput8);
	var		newInput9 = document.createElement('input'); newInput9.id = id+'8';	newInput9.name = 'previous_best'; newInput9.size = '7'; newInput9.value = '';
	cell9.appendChild(newInput9);
	cell10.innerHTML="<img id='"+id+"' style='cursor: pointer; cursor: hand' src='/images/delete-icon.png' onclick='confirm(id)' width='18' height='18' />";
	id = id+':hurdler';
	$.post("./hurdlerupdate.php",{variable: id},
	function(data)
	{
		generate(data,'success');
	});
}

function addWatt(id)
{
	var ids = id.split(':');
	tid =ids[0];
	id = ids[1];
	var table = document.getElementById('inner'+tid);
	var rowCount = table.rows.length;
	if(!id && rowCount < 3)
	{
		$.ajaxSetup({async:false});
		id = null;
		$.post("./getlastid.php",{variable: 'wattball_team_members'},function(data){id = data;});
		$.ajaxSetup({async:true});  //return to default setting
		console.log(id);
		console.log("BWAHWHWHWH");
	}

	if(rowCount <= 16)
	{	
		var lastid = $('#inner'+tid+' tr:last').prev().attr('id');
		console.log("lastid = "+lastid);
		if(lastid != undefined)
		{
			console.log("lastid = "+lastid + " id = "+ id );
			id = lastid.substring(1);
			id = parseInt(id) +1 ;
		}
	var row = table.insertRow(rowCount-1);
	var colCount = table.rows[0].cells.length;
	row.id = 't'+id;
	var cell1=row.insertCell(0);
	var cell2=row.insertCell(1);
	var cell3=row.insertCell(2);
	var cell4=row.insertCell(3);
	var cell5=row.insertCell(4);
	var cell6=row.insertCell(5);
	var cell7=row.insertCell(6);
	var cell8=row.insertCell(7);
	var cell9=row.insertCell(8);
	var cell10=row.insertCell(9);
	var		newInput1 = document.createElement('input'); newInput1.id = id+'0'; newInput1.name = 'member_id'; newInput1.size = '2'; newInput1.value = id;
	cell1.appendChild(newInput1);
	var		newInput2 = document.createElement('input'); newInput2.id = id+'1';	newInput2.name = 'name'; newInput2.size = '7'; newInput2.value = '';			
	cell2.appendChild(newInput2);
	var		newInput3 = document.createElement('input'); newInput3.id = id+'2';	newInput3.name = 'surname'; newInput3.size = '6'; newInput3.value = '';
	cell3.appendChild(newInput3);
	var		newInput4 = document.createElement('input'); newInput4.id = id+'3';	newInput4.name = 'address'; newInput4.size = '13'; newInput4.value = '';
	cell4.appendChild(newInput4);
	var		newInput5 = document.createElement('input'); newInput5.id = id+'4';	newInput5.name = 'dob'; newInput5.size = '7'; newInput5.value = '';
	cell5.appendChild(newInput5);
	var		newInput6 = document.createElement('input'); newInput6.id = id+'5';	newInput6.name = 'phone'; newInput6.size = '8'; newInput6.value = '';
	cell6.appendChild(newInput6);
	var		newInput7 = document.createElement('input'); newInput7.id = id+'6';	newInput7.name = 'email'; newInput7.size = '18'; newInput7.value = '';
	cell7.appendChild(newInput7);
	var		newInput8 = document.createElement('input'); newInput8.id = id+'7';	newInput8.name = 'position'; newInput8.size = '8'; newInput8.value = '';
	cell8.appendChild(newInput8);
	var		newInput9 = document.createElement('input'); newInput9.id = id+'8';	newInput9.name = 'position'; newInput9.size = '5'; newInput9.value = '';
	cell9.appendChild(newInput9);
	cell10.innerHTML="<img id='"+id+"' style='cursor: pointer; cursor: hand' src='/images/delete-icon.png' onclick='confirmW(id)' width='18' height='18' />";
	id = id+':watt';
	$.post("./hurdlerupdate.php",{variable: id, assoc: tid},
	function(data)
	{
		generate(data,'success');
	});

	}
}

function addTeam() {
	var table = document.getElementById('watt');
	var rowCount = table.rows.length;
	var lastid = $('#watt tr:last-of-type').attr('id');
	if (lastid == undefined){
	lastid = $('#watt tr:last').attr('id');
	}
	console.log(lastid);
	var id = lastid.substring(1);
	console.log(id);
	var row = table.insertRow(rowCount);
	var colCount = table.rows[0].cells.length;
	id = parseInt(id)+1;
	row.id = 't'+id;
	var cell1=row.insertCell(0);
	var cell2=row.insertCell(1);
	var cell3=row.insertCell(2);
	var cell4=row.insertCell(3);
	var cell5=row.insertCell(4);
	var cell6=row.insertCell(5);
	var cell7=row.insertCell(6);
	var cell8=row.insertCell(7);
	var cell9=row.insertCell(8);
	var cell10=row.insertCell(9);
	cell1.innerHTML="<img id='"+id+"' style='cursor: pointer; cursor: hand' src='/images/open.png' onclick='expand(id)' width='18' height='18' />";
	var		newInput1 = document.createElement('input'); newInput1.id = id+'0'; newInput1.name = 'assoc_id'; newInput1.size = '6'; newInput1.value = id;
	cell2.appendChild(newInput1);
	var		newInput2 = document.createElement('input'); newInput2.id = id+'1';	newInput2.name = 'team_name'; newInput2.size = '7'; newInput2.value = '';
	cell3.appendChild(newInput2);
	var		newInput3 = document.createElement('input'); newInput3.id = id+'2';	newInput3.name = 'mgr_name'; newInput3.size = '6'; newInput3.value = '';
	cell4.appendChild(newInput3);
	var		newInput4 = document.createElement('input'); newInput4.id = id+'3';	newInput4.name = 'mgr_surname'; newInput4.size = '9'; newInput4.value = '';
	cell5.appendChild(newInput4);
	var		newInput5 = document.createElement('input'); newInput5.id = id+'4';	newInput5.name = 'email'; newInput5.size = '16'; newInput5.value = '';
	cell6.appendChild(newInput5);
	var		newInput6 = document.createElement('input'); newInput6.id = id+'5';	newInput6.name = 'address'; newInput6.size = '20'; newInput6.value = '';
	cell7.appendChild(newInput6);
	var		newInput7 = document.createElement('input'); newInput7.id = id+'6';	newInput7.name = 'captain'; newInput7.size = '3'; newInput7.value = '';
	cell8.appendChild(newInput7);
	var		newInput8 = document.createElement('input'); newInput8.id = id+'7';	newInput8.name = 'badge'; newInput8.size = '16'; newInput8.value = '';
	cell9.appendChild(newInput8);
	cell10.innerHTML="<img id='"+id+"' style='cursor: pointer; cursor: hand' src='/images/delete-icon.png' onclick='confirmW(id)' width='18' height='18' />";
	id = id+':team';
	$.post("./hurdlerupdate.php",{variable: id},
	function(data)
	{
		generate(data,'success');
	});
}

function expand(id)
{
	expand:
	{
		var table = document.getElementById('watt');
		var row = document.getElementById('t'+id);
		var index = row.rowIndex + 1;
		if(row = document.getElementById('e'+id))
		{
			row.parentNode.removeChild( row );
			break expand;
		}
		var row = table.insertRow(index);
		var colCount = table.rows[0].cells.length;
		var id = parseInt(id);
		row.id = 'e'+id;
		var cell1=row.insertCell(0);
		console.log(id);
		cell1.colSpan='10';
		$.post("./expand.php",{variable: id},
		function(data)
		{
			if(data != '')
			{
				var pos = data.lastIndexOf("watt:member_id");
				var end = data.charAt(pos-8);
				var nid ='';
				var i = 10;
				var start = pos - i;
				var charA = data.charAt(pos-i);
				for(i; charA != "'"; i++)
				{
					charA = data.charAt(pos-i);
					console.log(charA);
					var nid = charA+nid;
				}
				nid = nid.substring(1);
				nid = parseInt(nid)+1;
				console.log(nid);
				cell1.innerHTML="<table class='inner' id='inner"+id+"' border=1px><tr><th>ID</th><th>Name</th><th>Surname</th><th>Address</th><th>DoB</th><th>Phone</th><th>Email</th><th>Position</th><th>Shirt Num</th></tr>"+data+"<tr><td><img id='"+id+":"+nid+"' style='cursor: pointer; cursor: hand' src='/images/add-icon.png' onclick='addWatt(id)' width='25px' height='25px' /></td></tr></table>";
			}
			else
			{
				cell1.innerHTML="<table class='inner' id='inner"+id+"' border=1px><tr><th>ID</th><th>Name</th><th>Surname</th><th>Address</th><th>DoB</th><th>Phone</th><th>Email</th><th>Position</th><th>Shirt Num</th></tr>"+data+"<tr><td><img id='"+id+":' style='cursor: pointer; cursor: hand' src='/images/add-icon.png' onclick='addWatt(id)' width='25px' height='25px' /></td></tr></table>";
			}
		}); 
	}
}



function validateDate( input )
{
	var bits = input.split( "-" );
	var phpdate = new Date( bits[0], --bits[1], bits[2] );
	if( phpdate.getFullYear( ) == bits[0] && phpdate.getMonth( ) == bits[1] )
	{
		return true;
	}
	return false;
}

function validateSex( input )
{
	if( input == 'm' || input =='f' )
	{
		return true;
	}
	return false;
}

function validatePhone( input )
{
	if( input > 0 && input.length == 11 && parseInt(input))
	{
		return true;
	}
	return false;
}

function validateAssoc( input )
{
	if( input > 0 && input.length == 9 && parseInt(input))
	{
		return true;
	}
	return false;
}

function validateId( input )
{
	if( input > 0 && parseInt(input) > 0)
	{
		return true;
	}
	return false;
}

function validateTime( input )
{
	if(input > 0 && parseFloat(input) == input)
	{
		return true;
	}
	return false;
}

function validateName( input )
{
	if(input.length > 2 && input.match(/^[A-Za-z]*$/))
	{
		return true;
	}
	return false;
}

function validatePos( input )
{
	if(input == 'GoalKeeper' || input == 'Defender' || input == 'Midfielder' || input =='Forward')
	{
		return true;
	}
	return false;
}

function validateEmail( input )
{
	if(input.length > 9 && input.match(/^([0-9a-zA-Z]([-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/))
	{
		return true;
	}
	return false;
}

