<div class="login-page" ng-app="AuthApp" ng-controller="AuthCtrl">
    <div class="section-overlay"></div>
    <div class="form-wrapper">
        <?php if (isset($message)): ?>
            <div class="form">
                <h2 class="h2 text-green"><?= $message ?></h2>
                <p class="message"><a href="/auth">Enter</a></p>
            </div>
        <?php else : ?>
            <div class="form">
                <h2 class="h2">Password recovery</h2>
                <form class="login-form" method="post" action="/recovery">
                    <input type="email" placeholder="email" name="email"/>
                    <?php if (isset($error)): ?>
                        <p style="color: red; font-size: medium"> <?= $error ?> </p>
                    <?php endif; ?>
                    <p class="p">Your email is needed to reset the password.</p>
                    <button>reset password</button>
                    <p class="message"><a href="/auth">Enter</a></p>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>
