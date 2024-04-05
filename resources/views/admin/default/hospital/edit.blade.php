@include('admin.commom.head')
@include('admin.commom.nav')

<main>
    <section class="py-3 text-center container">
        @include('admin.commom.message')
        <div class="row">
        <form action="<?= config('url.admin_root'); ?>/hospital/<?php if(!empty($data->id))echo $data->id;else echo 'new'; ?>" method="post">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="col-sm-12">
                <label for="name" class="form-label"><?= __('姓名'); ?></label>
                <input type="text" class="form-control" name="name" id="name" value="<?= $data->name;?>">
            </div>
            <div class="col-sm-12">
                <label for="address" class="form-label"><?= __('地址'); ?></label>
                <input type="text" class="form-control" name="address" id="address" value="<?= $data->address;?>">
            </div>
            <div class="col-sm-12">
                <label for="tel" class="form-label"><?= __('電話'); ?></label>
                <input type="text" class="form-control" name="tel" id="tel" value="<?= $data->tel;?>">
            </div>
            <div class="col-sm-12">
                <label for="fax" class="form-label"><?= __('傳真'); ?></label>
                <input type="text" class="form-control" name="fax" id="fax" value="<?= $data->fax;?>">
            </div>
            <div class="col-sm-12">
                <label for="status" class="form-label"><?= __('狀態'); ?></label>
                <input type="checkbox" class="form-check-input" name="status" id="status" value="1" <?php if($data->status)echo 'checked'; ?>>
            </div>
            <div class="col-sm-12">
                <label for="email" class="form-label"><?= __('email'); ?></label>
                <input type="text" class="form-control" name="email" id="email" value="<?= $data->email;?>">
            </div>
            <div class="col-sm-12">
                <label for="desc" class="form-label"><?= __('備註'); ?></label>
                <textarea class="form-control" name="desc" id="desc" rows="3"><?= $data->desc; ?></textarea>
            </div>
            <input type="submit">
        </form>
        </div>
    </section>

</main>

@include('admin.commom.foot')