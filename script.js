document.addEventListener('DOMContentLoaded', (event) => {
    const links = document.querySelectorAll('.navbar a');

    links.forEach(link => {
        link.addEventListener('click', function() {
            links.forEach(link => link.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Check if a link should be marked active on page load
    const currentUrl = window.location.href;
    links.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
        }
    });
});
