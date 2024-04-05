@include('admin.commom.head')
@include('admin.commom.nav')

<main>
    <section class="py-3 text-center container">
        @include('admin.commom.message')
        <div class="row">
        <form method="post">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="col-sm-12">
                <label for="id" class="form-label"><?= __('醫院ID'); ?></label>
                <label for="id" class="form-label"><?= $data->id;?></label>
            </div>
            <div class="col-sm-12">
                <label for="name" class="form-label"><?= __('醫院名稱'); ?></label>
                <label for="name" class="form-label"><?= $data->name;?></label>
            </div>
            <div class="col-sm-12">
                <label for="status" class="form-label"><?= __('狀態'); ?></label>
                <label for="status" class="form-label"><?php if($data->status) echo __('O');else echo __('X'); ?></label>
            </div>
            <div class="col-sm-12">
                <label for="permission" class="form-label"><?= __('權限'); ?></label>
            </div>
            <?php foreach($authority as $authority_name): ?>
                <div class="col-sm-12">
                    <label for="permission" class="form-label"><?= __($authority_name); ?></label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="authority[<?= $authority_name ?>]" id="<?= $authority_name ?>_all" value="all" <?php if(isset($data->permission->{$authority_name}) && $data->permission->{$authority_name} == 'all') echo 'checked'; ?>>
                        <label class="form-check-label" for="<?= $authority_name ?>_all">
                            <?= __('全部'); ?>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="authority[<?= $authority_name ?>]" id="<?= $authority_name ?>_store" value="store" <?php if(isset($data->permission->{$authority_name}) && $data->permission->{$authority_name} == 'store') echo 'checked'; ?>>
                        <label class="form-check-label" for="<?= $authority_name ?>_store">
                            <?= __('只可新增'); ?>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="authority[<?= $authority_name ?>]" id="<?= $authority_name ?>_update" value="update" <?php if(isset($data->permission->{$authority_name}) && $data->permission->{$authority_name} == 'update') echo 'checked'; ?>>
                        <label class="form-check-label" for="<?= $authority_name ?>_update">
                            <?= __('只可更新'); ?>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="authority[<?= $authority_name ?>]" id="<?= $authority_name ?>_readonly" value="readonly" <?php if(isset($data->permission->{$authority_name}) && $data->permission->{$authority_name} == 'readonly') echo 'checked'; ?>>
                        <label class="form-check-label" for="<?= $authority_name ?>_readonly">
                            <?= __('唯獨'); ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
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