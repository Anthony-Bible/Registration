// Attach a submit handler to the form
$( "#postForm" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the p$age:
   var Loginform = $( "#postForm" );
   var content= Loginform.find( "textarea[name='content']" ).val();

   url = Loginform.attr( "action" );
 
  // Send the data using post
  var posting = $.post( url, {content:content}, function(data, status){
  	  	var xmlDoc = $.parseXML( data ); 

	var $xml = $(xmlDoc);

	var $person = $xml.find("response");

	  	$person.each(function(){

    	var name = $(this).find('errors').text();
      if (name == " No Errors"){
        window.location='wall.php';
      }else{
      $("#errors").css("visibility", "visible");        
    	$("#errors" ).html(name);
      $("loginPass").effect("shake");
      
    }

		});
    });
});
$(document).ready(function(){
  setInterval(requestNewMessages(),2000);
  var id = -1;


 function requestNewMessages() 
{ 
 // retrieve the username and color from the page 
//  var currentUser = document.getElementById("userName").value; 
  //  var currentColor = document.getElementById("color").value; 
   // only continue if xmlHttpGetMessages isn't void 
  id=1;
   
     try 
     {
      var posting = $.post( "messages.php", {id:id}, function(data, status){
          var xmlDoc = $.parseXML( data ); 

      var $xml = $(xmlDoc);

      var $person = $xml.find("wallMessage");
      var $messageDiv = $("#messages");
      $person.each(function(){

        var name = $(this).find('userId').text();
        var time = $(this).find('time').text();
        var content = $(this).find('content').text();
        var id = $(this).find('id').text();
        var response = '<div class="row"><div class="container"> '+ name +' '+ '<span class="float-right">' + time +'</span><br />'+ content + '</div></div>';
            $messageDiv.append(response);


        
     });
    });
            
            
     } 
     catch(e) 
     { 
     displayError(e.toString()); 
     } 
     } 
    
});
 
  