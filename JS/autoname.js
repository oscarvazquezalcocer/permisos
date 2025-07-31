 function autocompletarUsuario() {
            var email = document.getElementById('email').value;
            
            var username = email.split('@')[0];

            document.getElementById('username').value = username;
        }