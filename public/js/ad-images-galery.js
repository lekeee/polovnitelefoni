$(document).ready(function() {
    var totalSlides = $('.slides img').length;
    var currentSlide = 0;

    function showSlide(index) {
        $('.slides').css('transform', 'translateX(' + (-index * 100) + '%)');
        $('.thumbnail').removeClass('selected');
        $('.thumbnail[data-index="' + index + '"]').addClass('selected');
        currentSlide = index;
    }

    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            showSlide(currentSlide + 1);
        } else {
            showSlide(0);
            var scrollLeft = $('.thumbnails-container').scrollLeft();
            var thumbnailWidth = $('.thumbnail').outerWidth(true);
            $('.thumbnails-container').scrollLeft(0);
        }
    
        if (currentSlide >= Math.floor(3)) {
            var scrollLeft = $('.thumbnails-container').scrollLeft();
            var thumbnailWidth = $('.thumbnail').outerWidth(true);
            $('.thumbnails-container').scrollLeft(scrollLeft + thumbnailWidth);
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            if(currentSlide == 1){
                var scrollLeft = $('.thumbnails-container').scrollLeft();
                var thumbnailWidth = $('.thumbnail').outerWidth(true);
                $('.thumbnails-container').scrollLeft(0);
            }
            showSlide(currentSlide - 1);
        } else {
            showSlide(totalSlides - 1);
            $('.thumbnails-container').scrollLeft($('.thumbnails-container')[0].scrollWidth);
        }
        if (currentSlide <= totalSlides - Math.ceil(3) && currentSlide > 0) {
            var scrollLeft = $('.thumbnails-container').scrollLeft();
            var thumbnailWidth = $('.thumbnail').outerWidth(true);
            $('.thumbnails-container').scrollLeft(scrollLeft - thumbnailWidth);
        }
    }
    

    $('.next').click(nextSlide);

    $('.prev').click(prevSlide);

    $('.thumbnail').click(function() {
        var index = $(this).data('index');
        showSlide(index);
    });

    var initialX = null;

    $('.slider').on('mousedown touchstart', function(e) {
        initialX = e.pageX || e.originalEvent.touches[0].pageX;
    });

    $('.slider').on('mouseup touchend', function(e) {
        var finalX = e.pageX || e.originalEvent.changedTouches[0].pageX;

        if (initialX > finalX) {
            nextSlide();
        } else if (initialX < finalX) {
            prevSlide();
        }

        initialX = null;
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const thumbnailsContainer = document.querySelector('.thumbnails-container');
  
    if (!thumbnailsContainer) {
      console.error("Element with class 'thumbnails-container' not found.");
      return;
    }
  
    let isMouseDown = false;
    let startX;
    let scrollLeft;
  
    thumbnailsContainer.addEventListener('mousedown', (e) => {
      isMouseDown = true;
      startX = e.pageX - thumbnailsContainer.offsetLeft;
      scrollLeft = thumbnailsContainer.scrollLeft;
      e.preventDefault();
    });
  
    thumbnailsContainer.addEventListener('mouseleave', () => {
      isMouseDown = false;
    });
  
    thumbnailsContainer.addEventListener('mouseup', () => {
      isMouseDown = false;
    });
  
    thumbnailsContainer.addEventListener('mousemove', (e) => {
      if (!isMouseDown) return;
      e.preventDefault();
      const x = e.pageX - thumbnailsContainer.offsetLeft;
      const walk = (x - startX) * 1;
      thumbnailsContainer.scrollLeft = (scrollLeft - walk);
    });
  });
