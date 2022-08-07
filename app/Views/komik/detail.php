<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5 d-flex justify-content-center">
    <div class="row mt-5">
        <div class="col">
            <h2 class="p-2 d-inline-block mt-5 bg-light shadow-sm">Detail Komik</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $komik['sampul']; ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komik['judul']; ?></h5>
                            <p class="card-text"><b>Penulis : </b><?= $komik['penulis']; ?></p>
                            <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $komik['penerbit']; ?></small></p>

                            <a href="/komik/edit/<?= $komik['slug']; ?>" class="btn btn-warning">Ubah</a>

                            <form class="d-inline" action="/komik/delete/<?= $komik['id']; ?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>

                            <br><br>
                            <p class="float-start">Added : <?= $time; ?></p>
                            <a class="float-end" href="/komik">kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>