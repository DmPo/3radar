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
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
            <form class="login-form" method="post" action="/auth">
                <input type="email" placeholder="email" name="email"/>
                <input type="password" placeholder="password" name="password"/>
                <p style="color: red; font-size: medium">{{signin_error}}</p>
                <button>login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
        </div>
    </div>
</div>
<script src="/js/authCTRL.js"></script>