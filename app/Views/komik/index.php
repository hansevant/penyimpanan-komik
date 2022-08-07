<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <h1 class="mt-5 mb-4 text-center">Daftar Komik</h1>
    <div style="width: 150px; margin:auto;">
        <a href="/komik/create" class="btn btn-primary mb-3 d-block">Tambah Komik</a>
    </div>
    <?php if (session()->getFlashdata('pesantambah')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><?= session()->getFlashdata('pesantambah'); ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('pesanhapus')) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?= session()->getFlashdata('pesanhapus'); ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <?php foreach ($komik as $k) : ?>
            <div class="col-md-3 my-4">
                <div class="card-komik">
                    <img src="/img/<?= $k['sampul']; ?>" class="sampul" alt="gambar">
                    <h4 class="judul"><?= $k['judul']; ?></h4>
                    <a href="/komik/<?= $k['slug']; ?>" class="card-next"><span>➡️</span></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection(); ?>