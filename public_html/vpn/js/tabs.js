


function showtabs()
{

		var $marginLefty = $('#tabs');
		console.log($marginLefty);
	

		$marginLefty.animate({
		  marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ? 
		  -$marginLefty.outerWidth() :	0
		 
		});
		
		if(document.getElementById('toggle').style.marginLeft == '-197px')
		{
		
	
			document.getElementById('toggle').style.backgroundImage="url('http://vpn.wattsports.co.uk/images/toggle-open.png')";
		}
		else{
		
			document.getElementById('toggle').style.backgroundImage="url('http://vpn.wattsports.co.uk/images/toggle-shut.png')";
		}

		var $marginLefty = $('#toggle');

		$marginLefty.animate({
		  marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ? 
		  -$marginLefty.outerWidth() :	0

		});
		
		
	  
} 
