/*!
    * Training management system - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Training management system
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
// 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }    
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

// change avatar image
const avatarImage = document.getElementById("user_avatar");
const avatarInput = document.getElementById("avatar_input");
if (avatarImage && avatarInput) {
    avatarInput.addEventListener('change', (e) => {
        const reader = new FileReader();

        reader.onload = () => {
            const base64 = reader.result;
            avatarImage.src = base64;
        };

        reader.readAsDataURL(avatarInput.files[0]);
    })
}
