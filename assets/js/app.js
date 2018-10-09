/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
//var $ = require('jquery');
var imagesLoaded = require('imagesloaded');
imagesLoaded.makeJQueryPlugin($);

$(document).ready(function() {

  $('#login-button').click(function() {



  });


  $('.animated-bg').imagesLoaded({
    background: true
  }, function() {
    console.log('Loaded successful');
    $('#loader').remove();
    $('.content-body').fadeIn();
    $('.logo-anim').animateCss('bounce').css({ 'animation-delay' : '1s','animation-iteration-count' : 'infinite' });
    $('.score-anim').animateCss('jello').css({ 'animation-delay' : '1s','animation-iteration-count' : 'infinite' });

                      var slideUp = {
                            distance: '110%',
                            origin: 'bottom',
                            opacity: 0,
                            interval: 100
                      };

                      ScrollReveal().reveal('.slide-up-appear', slideUp);
  });





});


// Animate css

$.fn.extend({
  animateCss: function(animationName, callback) {
    var animationEnd = (function(el) {
      var animations = {
        animation: 'animationend',
        OAnimation: 'oAnimationEnd',
        MozAnimation: 'mozAnimationEnd',
        WebkitAnimation: 'webkitAnimationEnd',
      };

      for (var t in animations) {
        if (el.style[t] !== undefined) {
          return animations[t];
        }
      }
    })(document.createElement('div'));

    this.addClass('animated ' + animationName).one(animationEnd, function() {
      $(this).removeClass('animated ' + animationName);

      if (typeof callback === 'function') callback();
    });

    return this;
  },
});
