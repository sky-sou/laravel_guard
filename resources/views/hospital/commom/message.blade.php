<?php if(session()->has('error_message')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?= session('error_message'); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= session('message'); ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>