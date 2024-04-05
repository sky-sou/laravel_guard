    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid col-xs-12 col-md-9 ">
            <a class="navbar-brand" href="<?= env('APP_URL', '#'); ?>"><?= config('app.name'); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/announcement">公告</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/article">文章</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid col-3 hidden-xs">
            <form class="d-none d-md-flex" action="/global-search" method="get">
                <input class="form-control w-75" type="text" placeholder="Search" aria-label="Search" name="search" value="<?php if(isset($_GET['search']))echo $_GET['search']; ?>">
                <button class="btn btn-sm btn-outline-success" type="submit"><?= __('搜尋'); ?></button>
            </form>
            
            <form action="<?= config('url.user_root'); ?>/logout" method="POST">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <button type="submit" class="btn btn-primary"><?= __('登出'); ?></button>
            </form>
        </div>
    </nav>