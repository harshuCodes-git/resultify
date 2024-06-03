<?php
$status = "";
require 'connect.php';

if (isset($_GET['usn'])) {
    $usn = $conn->real_escape_string($_GET['usn']);  // Prevent SQL injection
    $sql = "SELECT * FROM students WHERE usn='$usn'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $usn = $row["usn"];
        $name = $row["name"];
        $dept_id = $row["dept_id"];
        $sem_id = $row["sem_id"];
        $sub1 = $row["sub1"];
        $sub2 = $row["sub2"];
        $sub3 = $row["sub3"];
        $sub4 = $row["sub4"];
        $sub5 = $row["sub5"];
        $sub6 = $row["sub6"];
        $lab1 = $row["lab1"];
        $lab2 = $row["lab2"];

        $total = $sub1 + $sub2 + $sub3 + $sub4 + $sub5 + $sub6 + $lab1 + $lab2;
        $status = ($total > 280) ? "Promoted" : "Demoted";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <title>Results</title>
    <style>
        .heading { font-size: 22px; font-weight: 600; }
        nav button { background-color: transparent; border: none; outline: none; }
        @media print {
            nav { display: none; }
            .res_top .row { background-color: transparent !important; }
            .student_name { background-color: transparent !important; }
            .student_details h4 { color: rgba(0, 0, 0, 0.8) !important; }
            tr { color: black !important; }
        }
    </style>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
    <?php include 'header.php'; ?>
    
    <section class="index" id="index">
        <div class="container" style="padding-bottom:45px;">
            <div class="row" style="padding-top:25px"></div>
            <div class="row" style="padding-top:25px">
                <div class="col-md-12 res_top" style="padding:20px; border:1px solid #8762a3">
                    <div class="row" style="background-color:#000000 ;">
                        <div class="col-md-6 student_name"
                            style="background-color:#8762a3;  border-right:0.5px solid #8762a3; color: white; display:flex; align-items:center;">
                            <h3 style="color:black; font-weight:600">Student's Name: <?php echo htmlspecialchars($name); ?></h3>
                        </div>
                        <div class="col-md-6 student_details">
                            <h4 style="font-weight:600; color:rgba(255,255,255,0.6);">USN: <?php echo htmlspecialchars($usn); ?></h4>
                            <h4 style="font-weight:600; color:rgba(255,255,255,0.6);">Department: 
                                <?php 
                                $sql = "SELECT department FROM departments WHERE id='$dept_id'";
                                $result = $conn->query($sql);
                                if ($result->num_rows == 1) {
                                    $row = $result->fetch_assoc();
                                    echo htmlspecialchars($row["department"]);
                                }
                                ?>
                            </h4>
                            <h4 style="font-weight:600; color:rgba(255,255,255,0.6);">Semester: 
                                <?php 
                                $sql = "SELECT semester FROM semesters WHERE id='$sem_id'";
                                $result = $conn->query($sql);
                                if ($result->num_rows == 1) {
                                    $row = $result->fetch_assoc();
                                    echo htmlspecialchars($row["semester"]);
                                }
                                ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top:50px;">
                <div class="col-md-12" style=" padding-left:0px; padding-right:0px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="background-color: black; color: white;">
                                <th scope="col">Subject</th>
                                <th scope="col">Marks Scored</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subjects = ["sub1_name", "sub2_name", "sub3_name", "sub4_name", "sub5_name", "sub6_name", "lab1_name", "lab2_name"];
                            $marks = [$sub1, $sub2, $sub3, $sub4, $sub5, $sub6, $lab1, $lab2];
                            for ($i = 0; $i < count($subjects); $i++) {
                                $sql = "SELECT {$subjects[$i]} FROM subjects WHERE dept_id='$dept_id' AND sem_id='$sem_id'";
                                $result = $conn->query($sql);
                                if ($result->num_rows == 1) {
                                    $row = $result->fetch_assoc();
                                    echo "<tr><th scope='row'>" . htmlspecialchars($row[$subjects[$i]]) . "</th><td>" . htmlspecialchars($marks[$i]) . "</td></tr>";
                                }
                            }
                            ?>
                            <tr class="table-success">
                                <th scope="row">Total</th>
                                <td><?php echo htmlspecialchars($total); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="padding-top:20px;">
                <div class="col-md-12">
                    <h3 style="font-weight:600; text-align:right">RESULT : <?php echo htmlspecialchars($status); ?></h3>
                </div>
            </div>
            <div class="row" style="padding-top:25px"></div>
    </section>
</body>
</html>
