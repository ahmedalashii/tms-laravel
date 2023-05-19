<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src=" {{ asset('js/scripts.js') }} "></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<link href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<script>
    @if (session('success'))
        Swal.fire({
            title: "{{ session('success') }}",
            toast: true,
            showConfirmButton: false,
            position: "bottom-end",
            icon: "{{ session('type') }}",
        });
    @elseif (session('fail'))
        Swal.fire({
            title: "{{ session('fail') }}",
            toast: true,
            showConfirmButton: false,
            position: "bottom-end",
            icon: "{{ session('type') }}",
        });
    @endif
</script>
