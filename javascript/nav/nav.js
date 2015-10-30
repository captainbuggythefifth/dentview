function create_menu(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write
	(
		'<link href="'+base+'css/userguide.css" rel="stylesheet" type="text/css"/>' +
		'<link href="'+base+'css/style.css" rel="stylesheet" type="text/css"/>' +
		'<div class="td" valign="top">' +
		'<form method="POST" action="'+base+'confirm-customer-login">' +
		'<h2> LOG IN <div align="right"> <a href="'+base+'customer-signup"> Sign Up</a></div> </h2>' +
		'<h3><div class="form-row"><span class="label"> Email Address:</span><input type="text" name="email_add"/></div>' +
		'<div class="form-row"><span class="label"> Password:</span><input type="password" name="password"/></div>' +
		'<div class="form-row"><span class="label" align="right"> <input type="submit" name="submit" value="Log In"/> </span></div>' +
		'</h3>' +
		'</form>' +
		'</div><br/>'			 
	);
}

function create_menu2(basepath)
{
	var base = (basepath == 'null') ? '' : basepath;

	document.write
	(
		'<link href="'+base+'css/userguide.css" rel="stylesheet" type="text/css"/>' +
		
		'<div align="right"><h2><a href="'+base+'customer-logout"> Log Out</a></h2></div>' 
				 
	);
}