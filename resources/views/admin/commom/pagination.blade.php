<?php 
    unset($_GET['page']);
    $params = [];
    foreach($_GET as $key => $value){
        $params[] = $key.'='.$value;
    }
    $url = Request::url().'?'.implode('&', $params);
?>
<?php if($lastPage > 1): ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if($nowPage > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $url.'&page='.($nowPage-1); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(($nowPage-2) > 0): ?>
                <li class="page-item"><a class="page-link" href="<?= $url.'&page='.($nowPage-2); ?>"><?= $nowPage-2; ?></a></li>
            <?php endif; ?>
            <?php if(($nowPage-1) > 0): ?>
                <li class="page-item"><a class="page-link" href="<?= $url.'&page='.($nowPage-1); ?>"><?= $nowPage-1; ?></a></li>
            <?php endif; ?>
            <li class="page-item"><a class="page-link"><?= $nowPage; ?></a></li>
            <?php if($nowPage < $lastPage): ?>
                <li class="page-item"><a class="page-link" href="<?= $url.'&page='.($nowPage+1); ?>"><?= $nowPage+1; ?></a></li>
            <?php endif; ?>
            <?php if(($nowPage + 1) < $lastPage): ?>
                <li class="page-item"><a class="page-link" href="<?= $url.'&page='.($nowPage+2); ?>"><?= $nowPage+2; ?></a></li>
            <?php endif; ?>
            <?php if($nowPage < $lastPage): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $url.'&page='.($nowPage+1); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>