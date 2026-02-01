(function ($) {

  function initGeissSlider($root) {
    if (!$root || !$root.length) return;
    if ($root.data('geissInit')) return;
    $root.data('geissInit', true);

    var autoplay = String($root.data('autoplay')) === 'true';
    var delay = parseInt($root.data('delay') || 5000, 10);

    var $viewport = $root.find('.geiss-ts__viewport');
    var $track = $root.find('.geiss-ts__track');
    var $slides = $root.find('.geiss-ts__slide');
    var $prev = $root.find('.geiss-ts__prev');
    var $next = $root.find('.geiss-ts__next');

    var index = 0;
    var timer = null;

    function goTo(i) {
      index = (i + $slides.length) % $slides.length;
      $track.css('transform', 'translateX(' + (-(index * 100)) + '%)');
    }
    function next(){ goTo(index + 1); }
    function prev(){ goTo(index - 1); }

    function stop(){
      if (timer){ clearInterval(timer); timer = null; }
    }
    function start(){
      if (!autoplay || $slides.length <= 1) return;
      stop();
      timer = setInterval(next, delay);
    }

    // Hide nav if only 1 slide
    if ($slides.length <= 1) {
      $prev.hide();
      $next.hide();
      return;
    }

    // Buttons
    $prev.on('click', function(){ stop(); prev(); start(); });
    $next.on('click', function(){ stop(); next(); start(); });

    // Pause on hover (desktop)
    $root.on('mouseenter', stop).on('mouseleave', start);

    // ---- Swipe / Drag Support (mobile + desktop touch) ----
    var dragging = false;
    var startX = 0;
    var currentX = 0;
    var thresholdPx = 50; // swipe distance to trigger slide change

    function pointerX(e){
      if (e.originalEvent.touches && e.originalEvent.touches.length) {
        return e.originalEvent.touches[0].clientX;
      }
      return e.clientX;
    }

    $viewport.on('touchstart mousedown', function(e){
      // only left click for mouse
      if (e.type === 'mousedown' && e.which !== 1) return;

      dragging = true;
      startX = pointerX(e);
      currentX = startX;

      stop();

      // disable transition while dragging
      $track.css('transition', 'none');
    });

    $(document).on('touchmove mousemove', function(e){
      if (!dragging) return;
      currentX = pointerX(e);

      var dx = currentX - startX;
      // move track with finger a bit (rubberband)
      var base = -(index * $viewport.outerWidth());
      $track.css('transform', 'translateX(' + (base + dx) + 'px)');
    });

    $(document).on('touchend mouseup', function(){
      if (!dragging) return;
      dragging = false;

      // restore transition (use CSS variable speed)
      $track.css('transition', '');

      var dx = currentX - startX;

      if (Math.abs(dx) > thresholdPx) {
        if (dx < 0) next(); else prev();
      } else {
        // snap back
        goTo(index);
      }

      start();
    });

    // Init
    goTo(0);
    start();
  }

  // Normal frontend load
  $(document).ready(function () {
    $('.geiss-ts').each(function () {
      initGeissSlider($(this));
    });
  });

  // Elementor editor render
  $(window).on('elementor/frontend/init', function () {
    if (window.elementorFrontend && elementorFrontend.hooks) {
      elementorFrontend.hooks.addAction(
        'frontend/element_ready/geiss_testimonial_slider.default',
        function ($scope) {
          initGeissSlider($scope.find('.geiss-ts'));
        }
      );
    }
  });

})(jQuery);
