<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace pro přístup do administrace</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <div class="container" style="height: 100vh;">
        <div class="d-flex align-items-center" style="height: 100%; width: 100%;">
            <div class="row" style="width: 100%;">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card" style="width: 100%;">
                        <div class="card-title text-center mt-2">
                            <h3>Registrace pro přístup do administrace</h3>
                        </div>
                        <hr class="pt-0 mt-0">
                        <div class="card-body">
                            <form action="post" class="card-text" id="signupForm">
                                <h5 class="card-title">Username:</h5>
                                <input type="text" name="username" class="form-control" id="signupUsername">
                                <div id="noValForUsername" style="color: red;" class="signupFormErrors">
                                    Please choose a username.
                                </div>
                                <div id="usernameExists" style="color: red;" class="signupFormErrors">
                                    User with these credentials already exists.
                                </div>
                                <h5 class="card-title">Password:</h5>
                                <input type="password" name="password" class="form-control" id="signupPassword">
                                <div id="noValForPassword" style="color: red;" class="signupFormErrors">
                                    Please enter a password.
                                </div>
                                <h5 class="card-title">Password again:</h5>
                                <input type="password" name="pwd_check" class="form-control" id="signupPWDCheck">
                                <div id="noValPWDCheck" style="color: red;" class="signupFormErrors">
                                    Please enter your password again.
                                </div>
                                <div id="PWDCheck" style="color: red;" class="signupFormErrors">
                                    Your passwords does not match.
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-5">
                                    <a href="./login" class="btn btn-dark mt-5 signup-btn">
                                        <h5>Login</h5>
                                    </a>
                                    <button class="btn btn-success mt-5 signup-btn" type="submit">
                                        <h5>Signup</h5>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>


    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        $("#signupForm").submit((e) => {
            e.preventDefault();

            let validation = true;
            if ($("#signupUsername").val() === "") {
                validation = false;
                $("#signupUsername").addClass("is-invalid");
                $("#noValForUsername").css("display", "block");
            } else {
                validation = true;
                $("#signupUsername").removeClass("is-invalid");
                $("#noValForUsername").css("display", "none");
            }
            if ($("#signupPassword").val() === "") {
                validation = false;
                $("#signupPassword").addClass("is-invalid");
                $("#noValForPassword").css("display", "block");
            } else {
                validation = true;
                $("#signupPassword").removeClass("is-invalid");
                $("#noValForPassword").css("display", "none");
            }
            if ($("#signupPWDCheck").val() === "") {
                validation = false;
                $("#signupPWDCheck").addClass("is-invalid");
                $("#noValPWDCheck").css("display", "block");
            } else {
                validation = true;
                $("#signupPWDCheck").removeClass("is-invalid");
                $("#noValPWDCheck").css("display", "none");

                if ($("#signupPWDCheck").val() !== $("#signupPassword").val()) {
                    validation = false;
                    $("#signupPWDCheck").addClass("is-invalid");
                    $("#PWDCheck").css("display", "block");
                } else {
                    validation = true;
                    $("#signupPWDCheck").removeClass("is-invalid");
                    $("#PWDCheck").css("display", "none");
                }

            }


            if (validation) {
                let formData = $("#signupForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: '<?= REQUEST_URL ?>register/register',
                    data: JSON.stringify(formData),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(resp, textStatus, jqXHR) {
                        if (jqXHR.status === 201) {
                            var url = "login";
                            $(location).attr('href', url);
                        }
                    },
                    error: function(xhr, textStatus, error) {
                        if (xhr.status === 500) {
                            validation = false;
                            $("#signupUsername").addClass("is-invalid");
                            $("#usernameExists").css("display", "block");
                        }
                    }
                })
            }
        })
    </script>
</body>

</html>