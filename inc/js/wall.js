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
  id = 1;

 var run= setInterval( function requestNewMessages() 
{ 
 // retrieve the username and color from the page 
//  var currentUser = document.getElementById("userName").value; 
  //  var currentColor = document.getElementById("color").value; 
   // only continue if xmlHttpGetMessages isn't void 
  // id=id;
  // id=1;
   
     try 
     {
       posting = $.post( "messages.php", {id:id}, function(data, status){
          var xmlDoc = $.parseXML( data ); 

      $xml = $(xmlDoc);

       $person = $xml.find("wallMessage");
       $messageDiv = $("#messages");
       $person.each(function(){
        // alert(id);

            name = $(this).find('user_id').text();
            time = $(this).find('time').text();
            content = $(this).find('content').text();
            id = $(this).find('id').text();

            response = '<div class="row"><div class="container"> <div class="Messagecontainer "><div class="id" hidden>'+id+'</div><div class="username col-sm-6"> '+ name +' </div>'+ '<span class="float-right"><div class="time col-sm-6">' + time +'</div></span><br /><div class="content">'+ content + 
                                                      '</div><div class="icons"><i class="likeIcon glyphicon glyphicon-heart" /> <div class="faveCount"></div><i class="retweetsIcon glyphicon glyphicon-retweet" /></div></div></div></div>';
            $messageDiv.append(response);
        
     });
    });
            
            
     } 
     catch(e) 
     { 
     $("#messages").append(e); 
     }
    return id; 
     } 
    ,5000);
 $(document).on('click', '.likeIcon', function(){ 
  /* body... */
  //get the message container of the like clicked
  likeParent =$(this).parents(".Messagecontainer");

  //get the id of the "tweet" that was liked
  likeId = likeParent.find("div.id").text();
  try 
     {
       posting = $.post( "addLike.php", {id:likeId}, function(data, status){
          var xmlDoc = $.parseXML( data ); 

      $xml = $(xmlDoc);

       $person = $xml.find("response");
       $messageDiv = $("#messages");
       $person.each(function(){
        // alert(id);

           likes = $(this).find('totalLikes').text();
           likeParent.find("div.faveCount").html(likes);            
           
        
     });
    });
            
            
     } 
     catch(e) 
     { 
     $("#messages").append(e); 
     }
});



