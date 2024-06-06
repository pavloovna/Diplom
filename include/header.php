<header class="container-xxl">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="logo">
                    <img src="../../assets/images/logotype.png" alt="" onclick="window.location.href='<?php echo BASE_URL . '/pages/main/main.php'; ?>'">
                </div>
            </div>
            <nav class="col-6">
                <div class="menu">
                    <ul>
                        <li>
                            <!-- <a>Картины</a>
                            <ul class="submenu"> -->
                                <li> <a href="../../admin/posts/create-post.php">Добавление</a> </li>
                                <li> <a href="../../admin/posts/index-post.php">Управление</a> </li>
                            <!-- </ul> -->
                        </li>
                        <!-- <li>
                            <a>Пользователи</a>
                            <ul class="submenu">
                                <li> <a href="../../admin/users/create-user.php">Добавление</a> </li>
                                <li> <a href="../../admin/users/index-user.php">Управление</a> </li>
                            </ul>
                        </li>
                        <li>
                            <a>Категории</a>
                            <ul class="submenu">
                                <li> <a href="../../admin/topics/create-topic.php">Добавление</a> </li>
                                <li> <a href="../../admin/topics/index-topic.php">Управление</a> </li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
            </nav>
            <div class="col-2">
                <div class="icons">
                    <a href="#"><img src="../../assets/images/user.png" alt="">
                        <?php echo $_SESSION['Name']; ?>
                    </a>
                    <ul class="submenu">                       
                        <li> <a href="<?php echo BASE_URL . 'logout.php'; ?>">Выход</a> </li>                        
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</header>