<div class="login-page" ng-app="AuthApp" ng-controller="AuthCtrl">
    <div class="section-overlay"></div>
    <div class="form-wrapper">
        <div class="form">
            <form class="register-form" method="post" action="/reg" name="signUpForm">
                <input type="email" placeholder="E-Mail" name="email" ng-model="user.email" required/>
                <input type="text" placeholder="Name" name="first_name" ng-model="user.first_name" required/>
                <input type="text" placeholder="Surname" name="last_name" ng-model="user.last_name" required/>
                <input type="password" placeholder="Password" name="password" ng-model="user.password" required/>
                <sup> password must contain at least 6 characters</sup>
                <input type="tel" placeholder="Contact phone" name="phone" ng-model="user.phone" required/>

                <div class="g-recaptcha" data-callback="enableBtn"
                     data-sitekey="6Le_TAwUAAAAADlS9cv7s1ECFlo3QS2-fDRLyDL5"></div>
                <p style="color: red; font-size: medium">{{signup_error}}</p>

                <button id="signupbutton" type="button" ng-click="signup()">Sign Up</button>
                <p class="message">Registered? <a href="#">Enter</a></p>

            </form>
            <form class="login-form" method="post" action="/auth">
                <input type="email" placeholder="email" name="email"/>
                <input type="password" placeholder="Пароль" name="password"/>
                <p style="color: red; font-size: medium">{{signin_error}}</p>
                <?php if (isset($error)): ?>
                    <p style="color: red; font-size: medium"> <?= $error ?> </p>
                <?php endif; ?>
                <button>Увійти</button>
                <p class="message">Not registered? <a href="#">New account</a></p>
            </form>

            <div class="social">
                    <a href="<?= $fb_login ?>" class="btn btn-primary" >
                        <i class="fa fa-facebook" style="color: white"></i> Log in with your Facebook account
                    </a>
                    <a href="<?= $gl_login ?>" class="btn btn-danger" >
                        <i class="fa fa-google" style="color: white"></i>Log in with your Google account
                    </a>
            </div>
            <p><span class="small text-muted">Lost password? </span><a href="/recovery">Recover your password</a></p>
        </div>
    </div>
</div>
<script src="/js/authCTRL.js"></script>
