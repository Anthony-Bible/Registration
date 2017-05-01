// Attach a submit handler to the form
$( "#registerForm" ).submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the p$age:
   var registerForm = $( "#registerForm" );
   var Formusername= registerForm.find( "input[name='username']" ).val();
   var password = registerForm.find( "input[name='password']" ).val();
   var firstName = registerForm.find("input[name='firstName']").val();
   var lastName = registerForm.find("input[name='lastName']").val();
   var username = registerForm.find("input[name='username']").val();
   var email = registerForm.find("input[name='email']").val();
   var phone = registerForm.find("input[name='phone']").val();
   var date = registerForm.find("input[name='date']").val();
   var password = registerForm.find("input[name='password']").val();
   url = registerForm.attr( "action" );
 
  // Send the data using post
  var posting = $.post( url, { username: Formusername, password: password,firstName: firstName, lastName:lastName, username:username,email:email,phone:phone, date:date,password:password,submit:'' }, function(data, status){
    var xmlDoc = $.parseXML( data ); 

    var $xml = $(xmlDoc);

    var $person = $xml.find("response");

    $person.each(function(){

    var name = $(this).find('errors').text();
        // if there are errors display them if not redirect
    if (name == " No Errors"){
        window.location='wall.php';
    }else{
        // alert(name);
        $("#errors").css("visibility", "visible");        
        $("#errors" ).html(name);
        $("loginPass").effect("shake");
        
      }
 


    });
    });
});
 
 function checkPass() {
      var firstPssword= document.getElementById("password");
      var secondPassword= document.getElementById("retype_password");
      var passwordMessage = document.getElementById("passwords");
      var goodColor = "#66cc66";
      var badColor = "#ff6666";
  if(firstPssword.value==secondPassword.value)
  {
      secondPassword.style.backgroundColor = goodColor;
      passwordMessage.style.color = goodColor;
      passwordMessage.innerHTML = "Passwords Match!";
  } 
  else{
    secondPassword.backgroundColor = badColor;
    passwordMessage.style.color = badColor;
    passwordMessage.innerHTML = "Passwords DO NOT Match!";
  } 
}


function isDateSelected(){ 
      var today =new Date();
      var inputDate = new Date(document.getElementById('date').value);
      if (inputDate.value == " "){
         document.getElementById('dates').innerHTML ='<p class="errors"> Invalid Date Format </p>';
         document.getElementById("registerSubmit").disabled = true;
         document.getElementById('date').focus();
      
      } else if (inputDate > today) {
          document.getElementById('dates').innerHTML ='<p class="errors"> Invalid Date Format </p>';
          document.getElementById("registerSubmit").disabled = true;
          document.getElementById('date').focus();
      } else {            
          document.getElementById('dates').innerHTML ='';
          document.getElementById("registerSubmit").disabled = false;

      }
  }
  


