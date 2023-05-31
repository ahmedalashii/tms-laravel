<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src=" {{ asset('js/scripts.js') }} "></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<link href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    @if (session('success'))
        Swal.fire({
            title: "{{ session('success') }}",
            toast: true,
            width: 400,
            showConfirmButton: false,
            position: "bottom-end",
            icon: "{{ session('type') }}",
        });
    @elseif (session('fail'))
        Swal.fire({
            title: "{{ session('fail') }}",
            toast: true,
            width: 400,
            showConfirmButton: false,
            position: "bottom-end",
            icon: "{{ session('type') }}",
        });
    @endif
</script>
<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-analytics.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries
  
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
      apiKey: "AIzaSyClhGqWIu1LK9wqSF20MIwhlcAo0mmPdLs",
      authDomain: "laraveltms-b022f.firebaseapp.com",
      databaseURL: "https://laraveltms-b022f-default-rtdb.firebaseio.com",
      projectId: "laraveltms-b022f",
      storageBucket: "laraveltms-b022f.appspot.com",
      messagingSenderId: "535725536461",
      appId: "1:535725536461:web:e876f3f0aaec6af738e584",
      measurementId: "G-B1XS1PP0R6"
    };
  
    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
    console.log("app", app);
    console.log("analytics", analytics);
</script>
