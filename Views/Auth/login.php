<div id = "frm">  
    <h1 style="text-align: center;">EduMatrix Login</h1>  
    <form name="f1" onsubmit = "return validation()" method = "POST">  
        <p>  
            <label> Gebruikersnaam: </label>  
            <input type = "text" id ="user" name  = "username" />  
        </p>  
        <p>  
            <label> Wachtwoord: </label>  
            <input type = "password" id ="pass" name  = "password" />  
        </p>  
        <p>     
            <input type =  "submit" id = "btn" value = "Login" />  
        </p>
        <p><?php echo $context->error ?></p>
    </form>  
</div>    
<script>
  function validation()  
  {  
      var id=document.f1.user.value;  
      var ps=document.f1.pass.value;  
      if(id.length=="" && ps.length=="") {  
          alert("De velden Gebruikersnaam en Wachtwoord zijn leeg.");  
          return false;  
      }  
      else  
      {  
          if(id.length=="") {  
              alert("Gebruikersnaam is leeg.");  
              return false;  
          }   
          if (ps.length=="") {  
          alert("Wachtwoord is leeg.");  
          return false;  
          }  
      }                             
  }  
</script>  