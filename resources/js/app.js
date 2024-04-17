function redirect(url) {
    window.location.href = url;
}

window.addEventListener('load', () => {
    AOS.init({
        offset: 1,
    });
});