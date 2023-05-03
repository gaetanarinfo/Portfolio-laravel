$(function () {

    // Nice select
    $('.vg-select').niceSelect();

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Page animation initialize
    new WOW().init();

    // Back to top
    var backTop = $(".btn-back_to_top");

    $(window).scroll(function () {
        if ($(document).scrollTop() > 400) {
            backTop.css('visibility', 'visible');
        }
        else if ($(document).scrollTop() < 400) {
            backTop.css('visibility', 'hidden');
        }
    });

    backTop.click(function () {
        $('html').animate({
            scrollTop: 0
        }, 1000);
        return false;
    });

    $.fn.toggleSelected = function (options) {
        var defaults = $.extend({
            classes: 'selected',
            itemSelector: this.children(),
        });

        return this.each(function () {
            var o = defaults;
            var sel = o.itemSelector;

            sel.click(function () {
                var self = $(this);
                self.addClass(o.classes);
                self.siblings().removeClass(o.classes);
            });
        });
    };

    $('[data-toggle="selected"]').toggleSelected();
});

$(document).ready(function () {

    /* Sticky nvigation */

    var sticky = {
        $sticky: $('.sticky'),
        offsets: [],
        targets: [],
        stickyTop: null,

        set: function () {
            var self = this;

            var windowTop = Math.floor($(window).scrollTop());

            self.offsets = [];
            self.targets = [];

            // Get current top position of sticky element
            self.stickyTop = self.$sticky.data('offset') ? self.$sticky.css('position', 'absolute').data('offset') : self.$sticky.css('position', 'absolute').offset().top;

            // Cache all targets and their top positions
            self.$sticky.find('a').map(function () {
                var $el = $(this),
                    href = $el.data('target') || $el.attr('href'),
                    $href = /^#./.test(href) && $(href);

                return $href && $href.length && $href.is(':visible') ? [[$href[0].getBoundingClientRect().top + windowTop, href]] : null;
            })
                .sort(function (a, b) { return a[0] - b[0] })
                .each(function () {
                    self.offsets.push(this[0]);
                    self.targets.push(this[1]);
                });
        },

        update: function () {
            var self = this;

            var windowTop = Math.floor($(window).scrollTop());
            var $stickyLinks = self.$sticky.find('.navbar-nav .nav-item').removeClass('active');
            var stickyPosition = 'fixed';
            var currentIndex = 0;

            // Toggle fixed position depending on visibility
            if ($(window).width() < 800 || $(window).height() < 500 || self.stickyTop > windowTop) {
                stickyPosition = 'absolute';
                self.$sticky.removeClass('floating');

            }

            self.$sticky.css({ 'position': stickyPosition });

            if (stickyPosition == 'absolute') {
                self.$sticky.removeClass('floating');
            }
            else {
                self.$sticky.addClass('floating');
            }

        },

        init: function () {
            var self = this;

            $(window).on('resize', function () {
                self.set();

                self.update();
            });

            $(window).on('scroll', function () {
                self.update();
            });

            $(window).trigger('resize');
        }
    }

    if ($('.navbar').hasClass('sticky')) {
        sticky.init();
    }

});

$(document).ready(function () {

    $('#paramsR').click(function () {
        console.log('test');
        $(this).parents('.config').toggleClass('active');
    });

    $('.color-item').click(function () {
        var cls = $(this).data('class');

        $('body').attr('class', $('body').data('bodyClassList'));
        $('body').removeAttr('class').addClass(cls);
    });

    $('#change-page').on('change', function () {
        var url = $(this).val();

        if ($(this).val()) {
            window.location.assign(url);
        }
    });

    $('[data-animate="scrolling"]').each(function () {
        var self = $(this);
        var target = $(this).data('target') ? $(this).data('target') : $(this).attr('href');

        self.click(function (e) {
            $('body, html').animate({ scrollTop: $(target).offset().top }, 1000);
            return false;
        });
    });

});


/*
 *  Counter
 *
 *  Require(" jquery.animateNumber.min.js ", " jquery.waypoints.min.js ")
 */
$(document).ready(function () {
    var counterInit = function () {
        if ($('.section-counter').length > 0) {
            $('.section-counter').waypoint(function (direction) {

                if (direction === 'down' && !$(this.element).hasClass('ftco-animated')) {

                    var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
                    $('.number').each(function () {
                        var $this = $(this),
                            num = $this.data('number');
                        $this.animateNumber(
                            {
                                number: num,
                                numberStep: comma_separator_number_step
                            }, 5000
                        );
                    });

                }

            }, { offset: '95%' });
        }

    }
    counterInit();
});
