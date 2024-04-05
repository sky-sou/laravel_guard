@include('admin.commom.head')
@include('admin.commom.nav')

<main>
    <section class="py-3 text-center container">
        <div class="row">
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col"><?= __('ID'); ?></th>
                        <th scope="col"><?= __('登入帳號'); ?></th>
                        <th scope="col"><?= __('登入類型'); ?></th>
                        <th scope="col"><?= __('IP'); ?></th>
                        <th scope="col"><?= __('裝置'); ?></th>
                        <th scope="col"><?= __('瀏覽器'); ?></th>
                        <th scope="col"><?= __('登入日期'); ?></th>
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
                                    <?php if($row['type'] == 'user'): ?>
                                        <?= $row['user']['name']; ?>
                                    <?php elseif($row['type'] == 'admin'): ?>
                                        <?= $row['admin']['name']; ?>
                                    <?php elseif($row['type'] == 'hospital'): ?>
                                        <?= $row['hospital_admin']['name']; ?>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $row['type']; ?>
                                </td>
                                <td>
                                    <?= $row['ip']; ?>
                                </td>
                                <td>
                                    <?= $row['device']; ?>
                                </td>
                                <td>
                                    <?= $row['browser']; ?>
                                </td>
                                <td>
                                    <?= date("Y-d-m H:i:s", strtotime($row['logged_in_at'])); ?>
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