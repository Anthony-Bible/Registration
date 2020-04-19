// Attach a submit handler to the form
$( "#loginForm" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the p$age:
   var Loginform = $( "#loginForm" );
   var Formusername= Loginform.find( "input[name='username']" ).val();
   var password = Loginform.find( "input[name='password']" ).val();
   url = Loginform.attr( "action" );
 
  // Send the data using post
  var posting = $.post( url, { username: Formusername, password: password,submit:'' }, function(data, status){
  	  	var xmlDoc = $.parseXML( data ); 

	var $xml = $(xmlDoc);

	var $person = $xml.find("response");

	  	$person.each(function(){

    	var name = $(this).find('errors').text();
      if (name == " No Errors"){
        window.location='inc/wall.php';
      }else{
      $("#errors").css("visibility", "visible");        
    	$("#errors" ).html(name);
      $("loginPass").effect("shake");
      
    }

		});
    });
});
 
  