const submit = document.getElementById("submit");
let valid_name = true;
let valid_username = true;
let valid_mail = true;
let valid_password = true;

const name_message = document.getElementById("name_message");
const name = document.getElementById('name');
name.addEventListener("input", function(e){
   if (/^[A-Za-z ]+$/.test(e.target.value) == false)
   {
     name_message.innerHTML = "Votre nom doit contenir uniquement des lettres.";
     submit.style.visibility = "hidden";
     valid_name = false;
  }
  else
  {
     name_message.innerHTML = "";
     valid_name = true;
     if (valid_username == true && valid_mail == true && valid_password == true) 
     {
           submit.style.visibility = "visible";
     }

  }
});

const pass_message = document.getElementById("password_message");
const password = document.getElementById("password");
const check = document.getElementById("password_check");
check.addEventListener('input', function(e){
  if (password.value != password_check.value) {
     pass_message.innerHTML = "Les mots de passe saisis ne correpondent pas.";
     submit.style.visibility = "hidden";
     valid_password = false;
  }
  else
  {
     pass_message.innerHTML = "";
     valid_password = true;
     if (valid_username == true && valid_mail == true && valid_name == true) 
     {
           submit.style.visibility = "visible";
     }

  }
});

const username_message = document.getElementById("username_message");
const username = document.getElementById('username');
username.addEventListener('input', function(e) 
{
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = ()=>
   {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         var check = xmlhttp.responseText;
         if (check == 0) 
         {
            username_message.innerHTML = "";
            valid_username = true;
              if (valid_name == true && valid_mail == true && valid_password == true) 
              {
                    submit.style.visibility = "visible";
              }
         }
         else
         {
            username_message.innerHTML = "Ce nom d'utilisateur est déjà pris.";
            submit.style.visibility = "hidden";
            valid_username = false;
         }
    }
   };
   xmlhttp.open("GET", "../../scripts/check.php?field=username&text=" + e.target.value, true);
   xmlhttp.send();
});


const mail_message = document.getElementById("mail_message");
const mail = document.getElementById('mail');
mail.addEventListener('input', function(e) 
{
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = ()=>
   {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
         var check = xmlhttp.responseText;
         console.log(check);
         if (check == 0) 
         {
            mail_message.innerHTML = "";
            valid_mail = true;
           if (valid_username == true && valid_name == true && valid_password == true) 
           {
                 submit.style.visibility = "visible";
           }
         }
         else
         {
            mail_message.innerHTML = "Cette adresse mail est déjà utilisée par un autre utilisateur.";
            submit.style.visibility = "hidden";
            valid_mail = false;
         }
    }
   };
   xmlhttp.open("GET", "../../scripts/check.php?field=mail&text=" + e.target.value, true);
   xmlhttp.send();
});