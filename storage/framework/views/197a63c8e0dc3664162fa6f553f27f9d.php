

<?php $__env->startSection('MainContent'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Upload</h1>

            <form action="./upload-files" method="post" enctype="multipart/form-data" class="mt-3">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-upload me-1"></i>
                        Upload New File
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input class="form-control" type="file" name="file" id="file">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">File Description</label>
                            <input class="form-control" type="text" name="description" id="description"
                                placeholder="File Description">
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>

            <section>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-history me-1"></i>
                        Previous uploaded files
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href="./download/file1.pdf" class="list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">File1.pdf</h5>
                                        <small class="text-muted">100 KB</small>
                                    </div>
                                    <small class="text-muted">2023-05-16</small>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="./download/file2.docx" class="list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">File2.docx</h5>
                                        <small class="text-muted">200 KB</small>
                                    </div>
                                    <small class="text-muted">2023-05-15</small>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="./download/file2.docx" class="list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">File2.docx</h5>
                                        <small class="text-muted">200 KB</small>
                                    </div>
                                    <small class="text-muted">2023-05-15</small>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.traineeLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/trainee/upload.blade.php ENDPATH**/ ?>