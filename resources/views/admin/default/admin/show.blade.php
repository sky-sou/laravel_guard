@include('admin.commom.head')
@include('admin.commom.nav')

<main>
    <section class="py-3 text-center container">
        @include('admin.commom.message')
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <a href="<?= config('url.admin_root'); ?>/admin/edit/<?= $data->id ?>" class="btn btn-primary"><?= __('編輯'); ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="name" class="form-label"><?= __('姓名'); ?></label>
                <?= $data->name;?>
            </div>
            <div class="col-sm-12">
                <label for="account" class="form-label"><?= __('帳號'); ?></label>
                <?= $data->account;?>
            </div>
            <div class="col-sm-12">
                <label for="status" class="form-label"><?= __('狀態'); ?></label>
                <?php if($data->status) echo __('O');else echo __('X'); ?>
            </div>
            <div class="col-sm-12">
                <label for="email" class="form-label"><?= __('email'); ?></label>
                <?= $data->email;?>
            </div>
            <div class="col-sm-12">
                <label for="desc" class="form-label"><?= __('備註'); ?></label>
                <?= $data->desc; ?>
            </div>
        </div>
    </section>

</main>

@include('admin.commom.foot')