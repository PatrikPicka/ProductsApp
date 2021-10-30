<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení do administrace</title>
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
                            <h3>Přihlášení do administrace</h3>
                        </div>
                        <hr class="pt-0 mt-0">
                        <div class="signupFormErrors text-center" id="backEndError">
                            There was a problem logging you in.
                        </div>
                        <div class="card-body">
                            <form action="post" class="card-text" action="./app/LoginController.php" id="loginForm">
                                <h5 class="card-title">Username:</h5>
                                <input type="text" name="username" class="form-control" id="loginUsername">
                                <div id="noUsernameVal" class="signupFormErrors">
                                    Please enter your username.
                                </div>
                                <h5 class="card-title">Password:</h5>
                                <input type="password" name="password" class="form-control" id="loginPassword">
                                <div id="noPasswordVal" class="signupFormErrors">
                                    Please enter your username.
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-5">
                                    <a href="./signup" class="btn btn-dark" style="width: 30%; height: 40px;">Sign Up</a>
                                    <button type="submit" class="btn btn-success" style="width: 30%; padding: 0px; height:40px;">
                                        <h5>Login</h5>
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
        $("#loginForm").submit((e) => {
            e.preventDefault();

            let validation = true;
            if ($("#loginUsername").val() === "") {
                validation = false;
                $("#loginUsername").addClass("is-invalid");
                $("#noUsernameVal").css("display", "block");
            } else {
                validation = true;
                $("#loginUsername").removeClass("is-invalid");
                $("#noUsernameVal").css("display", "none");
            }
            if ($("#loginPassword").val() === "") {
                validation = false;
                $("#loginPassword").addClass("is-invalid");
                $("#noPasswordVal").css("display", "block");
            } else {
                validation = true;
                $("#loginPassword").removeClass("is-invalid");
                $("#noPasswordVal").css("display", "none");
            }

            if (validation) {
                let formData = $("#loginForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: '<?= REQUEST_URL ?>register/login',
                    data: JSON.stringify(formData),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(resp, textStatus, jqXHR) {
                        if (jqXHR.status === 200) {
                            var url = "products";
                            $(location).attr('href', url);
                        }
                    },
                    error: function(xhr, textStatus, error) {
                        if (xhr.status === 500) {
                            validation = false;
                            $("#backEndError").css("display", "block");
                        }
                    }
                })
            }
        })
    </script>
</body>

</html>