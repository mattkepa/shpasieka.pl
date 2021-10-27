document.addEventListener('DOMContentLoaded', function() {
    $('.news-container').masonry({
        itemSelectior: '.news-card',
        columnWidth: '.news-card',
        horizontalOrder: true
    });
})