<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" 
            href="/index.php">
                <i class='fas  mr-2' style='font-size:30px'></i>
                HOME
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if (isset($_SESSION['role'])) {
                        if ($_SESSION['role'] == 1) {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/user/managestaff.php">
                                        QUẢN LÝ NHÂN VIÊN
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/department/index-department.php">
                                        QUẢN LÝ PHÒNG BAN
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/nghiphep/Admin/list-nghiphep.php">
                                        NGHỈ PHÉP
                                    </a>
                                </li>
                            <?php
                        }
                    }

                    if (isset($_SESSION['role'])) {
                        if ($_SESSION['role'] == 2 ) {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/Task/Manager/index-task.php">
                                        QUẢN LÝ SÁCH
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/nghiphep/Manager/index-nghiphep.php">
                                        NGHỈ PHÉP
                                    </a>
                                </li>
                            <?php
                        }
                    }

                    if (isset($_SESSION['role'])) {
                        if ($_SESSION['role'] == 3) {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/Task/Employee/index-task.php">
                                        TASK
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-light mr-4" href="/nghiphep/Employee/index-nghiphep.php">
                                        NGHỈ PHÉP
                                    </a>
                                </li>         
                            <?php
                        }
                    }

                    if (isset($_SESSION['user'])) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-light mr-4"
                                href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='fas fa-user-alt mr-1 text-light' style='font-size:20px;'></i>
                                    <?= $_SESSION['name']?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="/profile.php" class="dropdown-item" >
                                        <button class="btn btn-info" type="submit">THÔNG TIN</button> 
                                    </a>
                                    <a href="/changepassold.php" class="dropdown-item" >
                                        <button class="btn btn-danger" type="submit">ĐỔI MẬT KHẨU</button> 
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="/logout.php" class="btn btn-light text-info">
                                ĐĂNG XUẤT</a>
                            </li>
                        <?php
                    } else {
                        ?>
                            <li class="nav-item">
                                <a href="./login.php" class="btn btn-success">LOGIN</a>
                            </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>


<!-- Require Login Modal -->
    
<!-- <script>
    window.onload = function(e) {
        $('#btn-change-password').click(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "./changepassold.php",
                method: 'POST',
                data: $('#form-change-password').serialize(),
            }).done(function() {
                location.reload();
            })
        });
    }
</script> -->