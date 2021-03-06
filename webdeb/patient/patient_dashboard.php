<?php
	session_start();
	if(!isset($_SESSION['patientemail']) && !isset($_SESSION['patientpassword']))
	{
		header('location: ../index.php');
	}

    $i = 0;

    $db = mysqli_connect("localhost","root","","medickare");

    $email = $_SESSION['patientemail'];

    $id = $db->prepare("SELECT * FROM patient WHERE patientEmail = ? limit 1");
    $id->bind_param('s', $email,);
    $id->execute();
    $resultid = $id->get_result();
    $value = $resultid->fetch_object();

    $patientid = $value->patientID;
    $firstname = $value->patientFirstName;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $query = "SELECT appointmentID, doctor.doctorLastName AS doctorLastName, doctor.doctorFirstName AS doctorFirstName, appointmentDate, appointmentTime, appointmentReason, appointmentStatus
    FROM appointment
    INNER JOIN doctor
    ON appointment.doctorID = doctor.doctorID AND appointment.patientID = '$patientid'
    ORDER BY appointmentID;";

    $data = mysqli_query($db, $query);

    if(isset($_POST['submit'])) {
        $doctorID = $_POST['doctorID'];
        $appointmentDate = $_POST['appointmentDate'];
        $appointmentTime = $_POST['appointmentTime'];
        $appointmentReason = $_POST['appointmentReason'];

        $sql = "INSERT INTO appointment (doctorID, patientID, appointmentDate, appointmentTime, appointmentReason, appointmentStatus) VALUES ('$doctorID', '$patientid', '$appointmentDate', '$appointmentTime', '$appointmentReason', 'Active')";
        
        if ($db->query($sql) === TRUE) {
            echo '<script>alert("Appointment is set");</script>';
            } else {
            echo "Error updating record: " . $db->error;
        }

        header("location: patient_dashboard.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="jquery-3.6.0.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="patient_dashboard.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="../pictures/logo.png" alt="" width="100px" height="100px" class="d-inline-block align-text-top">
                    <label>MedicKare Health Care</label>
                </a>
                <label style="font-size: 25px; margin: auto; margin-right: 10px;">
                    <?php
                        if (isset($firstname)) {
                            echo "Welcome, ".$firstname;
                        }
                    ?>
                </label>
                <div class="dropdown-menu">
                    <button class="menu-btn"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg></button>
                    <div class="menu-content">
                    <a class="links-hidden" href="patient_dashboard.php">Dashboard</a>
                        <a class="links-hidden" href="patient_viewprofile.php">View Profile</a>
                        <a class="links-hidden" href="patient_editprofile.php">Edit Profile</a>
                        <a class="links-hidden" href="patient_logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <br><br><br><br>
        <div class="mytabs">
            <input type="radio" id="tabset" name="mytabs" checked="checked">
            <label for="tabset">Set Appointment</label>
            <div class="tab">
                <br>
                <form method="POST" class="needs-validation row g-4" novalidate>
                    <div class="col-md-1"></div>

                    <div class="col-md-5">
                        <label for="validationCustom" class="form-label">Doctor Specialization</label>
                        <select name="doctorSpecialization" class="form-control" id="validationCustom" required>
                            <option selected hidden value=""></option>
                            <option value="Pediatrician">Pediatrician</option>
                            <option value="Neurology">Neurology</option>
                        </select>
                        <div class="invalid-feedback">
                            Please enter doctor specialization.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="validationCustom" class="form-label">Doctor Name</label>
                        <select name="doctorID" class="form-control" id="validationCustom" required>
                            <option selected hidden value=""></option>
                            <option value="2">Dr. Chastin Alarcon</option>
                            <option value="1">Dr. Juan Carlo Lintag</option>
                        </select>
                        <div class="invalid-feedback">
                            Please enter doctor name.
                        </div>
                    </div>

                    <div class="col-md-1"></div>

                    <div class="col-md-1"></div>

                    <div class="col-md-5">
                        <label for="validationCustom" class="form-label">Appointment Date</label>
                        <select name="appointmentDate" class="form-control" id="validationCustom" required>
                            <option selected hidden value=""></option>
                            <option value="2022-06-12">2022-06-12</option>
                            <option value="2022-06-14">2022-06-14</option>
                        </select>
                        <div class="invalid-feedback">
                            Please enter appointment date.
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="validationCustom" class="form-label">Appointment Time</label>
                        <select name="appointmentTime" class="form-control" id="validationCustom" required>
                            <option selected hidden value=""></option>
                            <option value="15:04:00">15:04:00</option>
                            <option value="09:55:00">09:55:00</option>
                        </select>
                        <div class="invalid-feedback">
                            Please enter appointment time.
                        </div>
                    </div>

                    <div class="col-md-1"></div>

                    <div class="col-md-1"></div>

                    <div class="col-md-10">
                        <label for="validationCustom" class="form-label">Reason for Appointment</label>
                        <input type="text" class="form-control" id="validationCustom" name="appointmentReason" value=""required>
                        <div class="invalid-feedback">
                            Please enter the reason for your appointment.
                        </div>
                    </div>

                    <div class="col-md-1"></div>
                    <br><br><br><br><br>
                    <div class="container d-flex justify-content-center">
                        <input type="submit" value="SET APPOINTMENT" name="submit" class="btn mt-4" style="margin-right: 30px;">
                        <input type="reset" value="RESET" class="btn mt-4">
                    </div>
                </form>
                <br>
            </div>

            <input type="radio" id="tabview" name="mytabs">
            <label for="tabview">View Appointment</label>
            <div class="tab">
                <table>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Doctor</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Appointment Reason</th>
                        <th>Appointment Status</th>
                        <th>Action</th>
                    </tr>
                    
                    <form method="POST">
                    <?php 
                    while($row = $data->fetch_assoc()) {
                    echo '<tr>
                            <td id="ID">'.$row['appointmentID'].'</td>
                            <td> Dr. '.$row['doctorFirstName'].' '.$row['doctorLastName'].'</td>
                            <td>'.$row['appointmentDate'].'</td>
                            <td>'.$row['appointmentTime'].'</td>
                            <td>'.$row['appointmentReason'].'</td>
                            <td>'.$row['appointmentStatus'].'</td>
                            <td><input onclick="selectedButton(this)" id="cancel" type="button" value="Cancel" name = "Cancel" class="cancelbtn" style="background-color: red; border-color: transparent; color: white; border-radius: 5px; padding:5px;" data-bs-toggle="modal" data-bs-target="#exampleModal"></td>
                        </tr>';
                    }
                    ?>
                    </form>
                </table>
            </div>
        </div>
    
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to cancel this appointment?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: gray; border-color: transparent; color: white; border-radius: 5px; padding:10px;">Close</button>
                    <button onclick="cancel()" type="button" class="btn btn-primary" style="background-color: rgb(255, 70, 70); border-color: transparent; color: white; border-radius: 5px; padding:10px;">Yes</button>
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

           var appointID;

            function selectedButton(e) {
                const selectedElement = e.parentElement.parentElement.querySelector('#ID');

                appointID = {'appointmentID': selectedElement.textContent};

                console.log(appointID);
            }

            function cancel() {
                $.ajax({
                    type:'POST',
                    url:'ajax.php',
                    data: appointID,
                    success: function(response){
                        console.log(response);
                    }
                });

                $('#cancelmodal').modal('hide');
                self.location = "http://localhost/webdeb/patient/patient_dashboard.php";
                alert("Appointment is cancelled");
            }
        </script>
    </body>
</html>