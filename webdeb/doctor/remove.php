<html>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</html>
<?php
    $db = mysqli_connect("localhost","root","","medickare");

    if(isset($_POST['doctorSchedID'])){
        $doctorSchedID = $_POST['doctorSchedID'];
        echo $doctorSchedID;

        $sql = "DELETE FROM schedule WHERE doctorSchedID = $doctorSchedID";

        if ($db->query($sql) === TRUE) {
            header("location: doctor_dashboard.php");
            } else {
            echo "Error updating record: " . $db->error;
        }
    }
?>