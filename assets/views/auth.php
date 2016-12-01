<div class="login-page" ng-app="AuthApp" ng-controller="AuthCtrl">
    <div class="section-overlay"></div>
    <div class="form-wrapper">
        <div class="form">
            <form class="register-form" method="post" action="/reg" name="signUpForm">
                <input type="email" placeholder="E-Mail" name="email" ng-model="user.email" required/>
                <input type="text" placeholder="Ім'я" name="first_name" ng-model="user.first_name" required/>
                <input type="text" placeholder="Прізвище" name="last_name" ng-model="user.last_name" required/>
                <input type="password" placeholder="Пароль" name="password" ng-model="user.password" required/>
                <sup> мінімальна довжина паролю 6 символів</sup>
                <input type="tel" placeholder="Контактний номер" name="phone" ng-model="user.phone" required/>

                <div class="g-recaptcha" data-callback="enableBtn"
                     data-sitekey="6Le_TAwUAAAAADlS9cv7s1ECFlo3QS2-fDRLyDL5"></div>
                <p style="color: red; font-size: medium">{{signup_error}}</p>

                <button id="signupbutton" type="button" ng-click="signup()">Зареєструватися</button>
                <p class="message">Вже зареєстровані? <a href="#">Увійти</a></p>

            </form>
            <form class="login-form" method="post" action="/auth">
                <input type="email" placeholder="email" name="email"/>
                <input type="password" placeholder="Пароль" name="password"/>
                <p style="color: red; font-size: medium">{{signin_error}}</p>
                <?php if (isset($error)): ?>
                    <p style="color: red; font-size: medium"> <?= $error ?> </p>
                <?php endif; ?>
                <button>Увійти</button>
                <p class="message">Не зареєстровані? <a href="#">Створити акаунт</a></p>
            </form>

            <div class="social">
                    <a href="<?= $fb_login ?>" class="btn btn-primary" >
                        <i class="fa fa-facebook" style="color: white"></i> Увійти за допомогою facebook
                    </a>
                    <a href="<?= $gl_login ?>" class="btn btn-danger" >
                        <i class="fa fa-google" style="color: white"></i> Увійти за допомогою google
                    </a>
            </div>
            <small><span class="small text-muted">Забули пароль? </span><a href="/recovery">Відновити</a></small>
        </div>
    </div>
</div>
<script src="/js/authCTRL.js"></script>