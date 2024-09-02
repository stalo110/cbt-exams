<?php include "includes/header.php"?>
<?php
    $active_exam_query = "SELECT * FROM courses WHERE active = 1";
    $select_exam_query = mysqli_query($connection, $active_exam_query);
    $total_active_exams = $select_exam_query->num_rows;
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="row ">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-primary">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">All Students</h5>
                                    <h2 class="mb-3 font-18"><?php echo total('students') ?></h2>
                                    <p class="mb-0"><a href="students.php" class="btn btn-md btn-outline-primary">View More <span><i data-feather="chevron-right"></i></span></a></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/1.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-info">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15"> Teachers</h5>
                                    <h2 class="mb-3 font-18"><?php echo total('teachers') ?></h2>
                                    <p class="mb-0"><a href="javascript:void()" class="btn btn-md btn-outline-info">View More <span><i data-feather="chevron-right"></i></span></a></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-dark">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">All Subjects</h5>
                                    <h2 class="mb-3 font-18"><?php echo total('subjects') ?></h2>
                                    <p class="mb-0"><a href="subjects.php" class="btn btn-md btn-outline-dark">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/3.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-warning">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Student Score</h5><br><br>
                                    <p class="mb-0"><a href="scores.php" class="btn btn-md btn-outline-warning">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-secondary">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Active Students</h5>
                                    <h2 class="mb-3 font-18"><?php echo total('current_students') ?></h2>
                                    <p class="mb-0"><a href="active-students.php" class="btn btn-md btn-outline-secondary">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-success">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Active Exams</h5>
                                    <h2 class="mb-3 font-18"><?php echo $total_active_exams ?></h2>
                                    <p class="mb-0"><a href="subjects.php" class="btn btn-md btn-outline-success">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-danger">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Total Class</h5>
                                    <h2 class="mb-3 font-18"><?php echo total('class') ?></h2>
                                    <p class="mb-0"><a href="class.php" class="btn btn-md btn-outline-danger">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-primary">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Set Exam</h5><br><br>
                                    <p class="mb-0"><a href="subjects.php" class="btn btn-md btn-outline-primary">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-light">
                <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                <div class="card-content">
                                    <h5 class="font-15">Settings</h5><br><br>
                                    <p class="mb-0"><a href="javascript:void()" class="btn btn-md btn-outline-light">View More <span><i data-feather="chevron-right"></i></span></a href="a"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                <div class="banner-img">
                                    <img src="assets/img/banner/4.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    
    
</section>
        <?php include "includes/footer.php"?>