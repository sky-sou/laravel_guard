<div class="row">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">

            <?php foreach($items as $item): ?>
                <?php if(isset($item['href'])): ?>
                    <li class="breadcrumb-item"><a href="<?= $item['href']; ?>"><?= $item['name']; ?></a></li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= $item['name']; ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
            
        </ol>
    </nav>
</div>