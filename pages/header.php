<header class="container-xxl">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <div class="logo">
                    <img src="../../assets/images/logotype.png" alt="" href="<?php echo BASE_URL ?>">
                </div>
            </div>
            <nav class="col-6">
                <ul>
                    <li><a href="<?php echo BASE_URL . 'pages/main/main.php' ?>">Главная</a></li>
                    <li><a href="<?php echo BASE_URL . 'pages/catalog/catalog.php' ?>">Каталог</a></li>
                    <li><a href="<?php echo BASE_URL . 'pages/about_me/about_me.php' ?>">Обо мне</a></li>
                    <li><a href="<?php echo BASE_URL . 'pages/contacts/contacts.php' ?>">Контакты</a></li>
                </ul>
            </nav>
            <div class="col-2">
                <div class="icons">
                    <a href="#"><img src="../../assets/images/basket.png" alt=""></a>
                    <?php if (isset($_SESSION['Id'])) : ?>
                        <!-- Если пользователь авторизован -->
                        <a href="#"><img src="../../assets/images/user.png" alt="">
                            <?php
                            /* echo $_SESSION['Name']; */
                            if (isset($_SESSION['Name'])) {
                                echo $_SESSION['Name'];
                            } else {
                            }
                            ?>
                        </a>

                        <ul class="submenu">
                            <?php
                            /* if ($_SESSION['Role']) : */
                            if (isset($_SESSION['Role']) && $_SESSION['Role']) :
                            ?>
                                <li> <a href="#">админка</a> </li>
                            <?php endif; ?>
                            <!-- <li> <a href="<?php echo BASE_URL . 'logout.php'; ?>">выход</a> </li> -->
                        </ul>
                    <?php else : ?>

                        <!-- Если пользователь не авторизован -->
                        <a href="#">
                            <img src="../../assets/images/user.png" alt="" data-bs-toggle="modal" id="authorization">
                        </a>
                        <!-- Окно авторизации -->
                        <div id="authModal" class="modal">
                            <div class="window">
                                <div class="form">
                                    <div class="close-span">
                                        <span class="close-auth">×</span>
                                    </div>
                                    <h2>Вход</h2>
                                    <div class="error">
                                        <p><?= $errMassage ?></p>
                                    </div>
                                    <form action="main.php" name="f1" method="post">
                                        <input type="email" placeholder="Почта" name="email" class="input">
                                        <input type="password" placeholder="Пароль" name="password" class="input">
                                        <div class="button-auth">
                                            <button type="submit" value="Войти" name="button_aut" class="input">Войти</button>
                                        </div>
                                        <div class="button-reg">
                                            <button href="registrations.php" type="submit" class="input">Регистрация</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            var authModal = document.getElementById('authModal');
                            var span = document.getElementsByClassName("close-auth")[0];
                            span.onclick = function() {
                                authModal.style.display = "none";
                            }
                            document.getElementById('authorization').addEventListener('click', function() {
                                authModal.style.display = "block";
                            });
                        </script>
                    <?php endif; ?>

                    <!-- Окно регистрации -->
                    <div id="regModal" class="modal">
                        <div class="window">
                            <div class="form">
                                <div class="close-span">
                                    <span class="close-reg">×</span>
                                </div>
                                <h2>Регистрация</h2>
                                <div class="error">
                                    <p><?= $errMassage ?></p>
                                </div>
                                <form action="main.php" name="f1" method="post">
                                    <input type="text" value="<?= $name ?>" placeholder="Имя" name="name" class="input">
                                    <input type="text" value="<?= $surname ?>" placeholder="Фамилия" name="surname" class="input">
                                    <input type="phone" value="<?= $phone ?>" placeholder="Мобильный телефон" name="phone" class="input">
                                    <input type="email" value="<?= $mail ?>" placeholder="Почта" name="email" class="input">
                                    <input type="email" placeholder="Подтвердите адрес электронной почты" name="email_replay" class="input">
                                    <input type="password" placeholder="Пароль" name="password" class="input">
                                    <input type="password" placeholder="Подтвердите пароль" name="password_replay" class="input">
                                    <div class="button-zareg">
                                        <button value="Войти" type="submit" class="input" name="sub_button">Зарегистрироваться</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        var regModal = document.getElementById('regModal');
                        var closeReg = document.getElementsByClassName("close-reg")[0];
                        closeReg.onclick = function() {
                            regModal.style.display = "none";
                        }
                        var regButton = document.querySelector(".button-reg button");
                        regButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            authModal.style.display = "none";
                            regModal.style.display = "block";
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</header>