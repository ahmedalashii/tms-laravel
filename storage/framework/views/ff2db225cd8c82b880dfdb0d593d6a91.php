<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src=" <?php echo e(asset('js/scripts.js')); ?> "></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<link href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<script>
    <?php if(session('success')): ?>
        Swal.fire({
            title: "<?php echo e(session('success')); ?>",
            toast: true,
            showConfirmButton: false,
            position: "bottom-end",
            icon: "<?php echo e(session('type')); ?>",
        });
    <?php elseif(session('fail')): ?>
        Swal.fire({
            title: "<?php echo e(session('fail')); ?>",
            toast: true,
            showConfirmButton: false,
            position: "bottom-end",
            icon: "<?php echo e(session('type')); ?>",
        });
    <?php endif; ?>
</script>
<?php /**PATH /home/vagrant/laravel/tms-laravel/resources/views/includes/js/allJS.blade.php ENDPATH**/ ?>