<div class="login-page" ng-app="AuthApp" ng-controller="AuthCtrl">
    <div class="section-overlay"></div>
    <div class="form-wrapper">
        <div class="form">
            <h2 class="h2">Введіть новий пароль</h2>
            <form class="login-form" method="post">
                <input placeholder="Новий пароль" name="password"/>
                <?php if(isset($error)):?>
                    <p style="color: red; font-size: medium"> <?=$error?> </p>
                <?php endif;?>
                <button>Скинути пароль</button>
            </form>
        </div>
    </div>
</div>
