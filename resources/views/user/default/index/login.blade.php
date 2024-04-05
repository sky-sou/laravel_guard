@include('user.commom.head')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @include('user.commom.message')
            <div class="card m-auto" style="max-width: 450px;">
                <div class="card-body">
                    <form action="<?= config('url.user_root'); ?>/login" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="col-sm-12">
                            <label for="account" class="form-label"><?= __('帳號'); ?></label>
                            <input type="text" class="form-control" name="account" id="account">
                        </div>
                        <div class="col-sm-12">
                            <label for="password" class="form-label"><?= __('密碼'); ?></label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="col-sm-12 form-check">
                            <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me">
                            <label class="form-check-label" for="remember_me"><?= __('記住我'); ?></label>
                        </div>
                        <button type="submit" class="btn btn-primary"><?= __('登入'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('user.commom.foot')