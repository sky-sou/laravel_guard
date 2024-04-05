@include('admin.commom.head')
@include('admin.commom.nav')

<main>
    <section class="py-3 text-center container">
        <div class="row">
            <div class="col-lg-6 col-md-8 mx-auto">
                <a href="<?= config('url.admin_root'); ?>/hospital/new" class="btn btn-primary"><?= __('新增'); ?></a>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col"><?= __('ID'); ?></th>
                        <th scope="col"><?= __('標題'); ?></th>
                        <th scope="col"><?= __('備註'); ?></th>
                        <th scope="col"><?= __('狀態'); ?></th>
                        <th scope="col"><?= __('修改日期'); ?></th>
                        <th scope="col"><?= __('修改者'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($data)): ?>
                        <?php foreach($data as $row): ?>
                            <tr>
                                <td>
                                <?= $row['id']; ?>
                                </td>
                                <td>
                                    <a href="<?= config('url.admin_root'); ?>/hospital/<?= $row['id']; ?>"><?= $row['name']; ?></a>
                                </td>
                                <td>
                                    <?= mb_substr($row['desc'], 0, 80); ?><?php if(mb_strlen($row['desc']) > 20) echo '...'; ?>
                                </td>
                                <td>
                                    <a href="<?= config('url.admin_root'); ?>/hospital/status/<?= $row['id'].'/';if($row['status']) echo 0;else echo 1; ?>">
                                        <?php if($row['status']) echo __('O');else echo __('X'); ?>
                                    </a>
                                </td>
                                <td>
                                    <?= date("Y-d-m H:i:s", strtotime($row['updated_at'])); ?>
                                </td>
                                <td>
                                    <?= '('.__($row['updated_type']).')'.$row['updated_user']['name']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        @include('admin.commom.pagination', ['nowPage' => $listInfo['currentPage'], 'lastPage' => $listInfo['lastPage']])
                    <?php else: ?>
                        <tr><td colspan="12" style="text-align: center;" ><?= __('無數據') ?></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

@include('admin.commom.foot')