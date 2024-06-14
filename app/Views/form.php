<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="form_process" method="POST" name="form_1" style="display:flex; align-items:center; flex-direction: column;">
        <table style="margin: 0 auto;width:350px;">
            <tr>
                <td style="text-align: right;">Username</td>
                <td><input type="text" name="username" id="username" /></td>
            </tr>

            <tr>
                <td style="text-align: right;">Password</td>
                <td><input type="password" name="password" id="password" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">Confirm password</td>
                <td> <input type="password" name="confirm_password" id="confirm_password" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">Firstname</td>
                <td><input type="text" name="f_name" id="f_name" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">Lastname</td>
                <td> <input type="text" name="l_name" id="l_name" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">Phone</td>
                <td> <input type="tel" name="phone" id="phone" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">Email</td>
                <td><input type="text" name="email" id="email" /></td>
            </tr>
            <tr>
                <td style="text-align: right;">ID</td>
                <td> <input type="text" name="user_id" id="user_id" /></td>
            </tr>

            <tr>
                <td></td>
                <td><button type="submit" id="submit" name="submit" onclick="return validate_input()">submit</button></td>
            </tr>
        </table>

        <p id="invalid_msg" style="color: red;"></p>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            console.log("ready!");
        })

        function validate_input() {
            // event.preventDefault()
            const username = $("#username").val()
            const password = $("#password").val()
            const confirm_password = $("#confirm_password").val()
            const email = $("#email").val()
            const f_name = $("#f_name").val()
            const l_name = $("#l_name").val()
            const phone = $("#phone").val()
            const user_id = $("#user_id").val()

            const rex_password = /[a-zA-Z0-9]{6}/;
            const rex_username = /[a-zA-Z0-9]{4,12}/;
            const rex_character = /^[a-zA-Z]+$/;
            const rex_number = /^[0-9]+$/;
            const rex_email = /^[a-zA-Z0-9]+@/;
            const rex_user_id = /^[0-9]{13}$/;

            if (checkempty(username)) {
                ErrorEmptyMsg("username")
                $("#username").focus()
                return false;
            }

            if (rex_username.test(username) == false) {
                $("#invalid_msg").text("username is invaid pattern!!")
                $("#username").focus()
                return false;
            }

            if (checkempty(password)) {
                ErrorEmptyMsg("password")
                $("#password").focus()
                return false;
            }
            if (rex_password.test(password) == false) {
                $("#invalid_msg").text("password needs to be at lest 6 characters or number !!")
                $("#password").focus()
                return false;
            }

            if (checkempty(confirm_password)) {
                ErrorEmptyMsg("Confirm password")
                $("#confirm_password").focus()
                return false;
            }
            if (rex_password.test(confirm_password) == false) {
                $("#invalid_msg").text("confirm password needs to be at lest 6 characters or number !!")
                $("#confirm_password").focus()
                return false;
            }

            if (password != confirm_password) {
                ErrorPasswordNotMatchMsg()
                $("#confirm_password").focus()
                return false;
            }

            if (checkempty(f_name)) {
                ErrorEmptyMsg("Firstname")
                $("#f_name").focus()
                return false;
            }
            if (rex_character.test(f_name) == false) {
                $("#invalid_msg").text("Firstname is invaid pattern!!")
                $("#f_name").focus()
                return false;
            }
            if (checkempty(l_name)) {
                ErrorEmptyMsg("Lastname")
                $("#l_name").focus()
                return false;
            }
            if (rex_character.test(l_name) == false) {
                $("#invalid_msg").text("Lastname is invaid pattern!!")
                $("#l_name").focus()
                return false;
            }
            if (checkempty(phone)) {
                ErrorEmptyMsg("phone")
                $("#phone").focus()
                return false;
            }
            if (rex_number.test(phone) == false) {
                $("#invalid_msg").text("Phone is invaid pattern!!")
                $("#phone").focus()
                return false;
            }
            if (checkempty(email)) {
                ErrorEmptyMsg("email")
                $("#email").focus()
                return false;
            }
            if (rex_email.test(email) == false) {
                $("#invalid_msg").text("email is invaid pattern!!")
                $("#email").focus()
                return false;
            }
            if (checkempty(user_id)) {
                ErrorEmptyMsg("ID")
                $("#user_id").focus()
                return false;
            }
            if (rex_user_id.test(user_id) == false) {
                $("#invalid_msg").text("ID is invaid pattern!!")
                $("#user_id").focus()
                return false;
            }
        }

        function checkempty(data) {
            if (data == "") {
                return true
            }
            return false
        }

        function ErrorPasswordNotMatchAlert() {
            alert("password is not match!!")
        }


        function ErrorPasswordNotMatchMsg() {
            $("#invalid_msg").text("password is not match!!")
            return
        }

        function ErrorEmptyAlert(fieldName) {
            alert(fieldName + " " + "field can not be empty!!")
            return
        }

        function ErrorEmptyMsg(fieldName) {
            $("#invalid_msg").text(fieldName + " " + "field can not be empty!!")
        }
    </script>
</body>

</html>