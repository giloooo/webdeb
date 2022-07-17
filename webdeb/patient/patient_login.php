<?php
    session_start();

    $db = mysqli_connect("localhost","root","","medickare");

    if(isset($_POST['submit'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $_SESSION['email'] = $email;
        $_SESSION['$password'] = $password;

        $checklogin = mysqli_query($db, "SELECT * FROM patient WHERE patientEmail = '$email' AND patientPassword = '$password'");
        if(mysqli_num_rows($checklogin) > 0) {
            $stmt = $db->prepare("SELECT * FROM patient WHERE patientEmail = ? AND patientPassword = ? limit 1");
            $stmt->bind_param('ss', $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            $value = $result->fetch_object();

            $_SESSION['firstname'] = $value->patientFirstName;
            $_SESSION['lastname'] = $value->patientLastName;
            $_SESSION['address'] = $value->patientAddress;
            $_SESSION['birthday'] = $value->patientBirthday;
            $_SESSION['sex'] = $value->patientSex;
            $_SESSION['phonenumber'] = $value->patientPhoneNumber;
            header("location: patient_dashboard.php");
        }

        else {
            echo '<div class="alert alert-danger " role="alert">
                Wrong email or password
                </div>';
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="style_patient_login_register.css">
    </head>
    <body>
        <div class="container-fluid d-absolute" id="back">
            <div class="d-xl-none"><br><br><br><br><br><br><br><br><br><br><br></div>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z"/>\
            </svg>
            <a href="../index.php">BACK</a>
        </div>

        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="index.php">
                <img src="../pictures/logo.png" alt="" width="100px" height="100px" class="d-inline-block align-text-top justify-content-center">
                <label>MedicKare Health Care</label>
            </a>
        </div>

        <div class="container d-flex justify-content-center">
            <div class="row">
                <div>
                    <br><br>
                    <center class="display-6" style="font-weight: 500;">LOGIN FORM</center>
                    <br>
                    <form method="POST" class="needs-validation" novalidate>
                        <label for="email" class="">Email <Address></Address></label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <div class="invalid-feedback">
                            Please enter email address.
                        </div>

                        <label for="password" class="">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <div class="invalid-feedback">
                            Please enter password.
                        </div>

                        <div class="container d-flex justify-content-center">
                            <input type="submit" value="LOG IN" name="submit" class="btn mt-4">
                        </div>
                    </form>
                    <br>
                    <div class="text-center">
                        <label class="mt-3">Not registered yet?</label>
                        <a href="patient_register.php">Click here.</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script>
            (() => {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')

                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>
    </body>
</html>