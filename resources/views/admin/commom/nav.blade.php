    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid col-xs-12 col-md-9 ">
            <a class="navbar-brand" href="<?= env('APP_URL', '#'); ?>"><?= config('app.name'); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">帳號</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/admin"><?= __('管理者帳號'); ?></a></li>
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/hospital"><?= __('醫院帳號'); ?></a></li>
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/user"><?= __('使用者帳號'); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">權限</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/admin-authority"><?= __('管理者權限'); ?></a></li>
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/hospital-authority"><?= __('醫院權限'); ?></a></li>
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/user-authority"><?= __('使用者權限'); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">紀錄</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= config('url.admin_root'); ?>/login-log"><?= __('登入紀錄'); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= config('url.admin_root'); ?>/article"><?= __('文章'); ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid col-3 hidden-xs">
            <form action="<?= config('url.admin_root'); ?>/logout" method="POST">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <button type="submit" class="btn btn-primary"><?= __('登出'); ?></button>
            </form>
        </div>
    </nav>