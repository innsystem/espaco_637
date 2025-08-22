(function ($) {
    "use strict";
    /*=================================
        JS Index Here
    ==================================*/
    /*
    01. On Load Function
    02. Preloader
    03. Mobile Menu
    04. Sticky fix
    05. Scroll To Top
    06. Set Background Image Color & Mask
    07. Global Slider
    08. Slider Tab
    09. Ajax Contact Form
    10. Popup Sidemenu
    11. Magnific Popup
    12. Section Position
    13. Filter
    14. Counter Up
    15. Hover Item
    16. Shape Mockup
    17. Progress Bar Animation
    18. Countdown
    19. Hero 2 Animation
    20. Overlay Direction
    00. Color Scheme
    00. Woocommerce Toggle
    00. Right Click Disable
    */
    /*=================================
        JS Index End
    ==================================*/
    /*

  /*---------- 01. On Load Function ----------*/
    $(window).on("load", function () {
        $(".preloader").fadeOut();
        $(".swiper-fade").addClass('fade-ani');
    });

    /*---------- 02. Preloader ----------*/
    if ($(".preloader").length > 0) {
        $(".preloaderCls").each(function () {
            $(this).on("click", function (e) {
                e.preventDefault();
                $(".preloader").css("display", "none");
            });
        });
    }

    // $('select').niceSelect(); 
    if ($('.nice-select').length) {
        $('.nice-select').niceSelect();
    }

    /*---------- 03. Mobile Menu ----------*/
    $.fn.thmobilemenu = function (options) {
        var opt = $.extend({
                menuToggleBtn: ".th-menu-toggle",
                bodyToggleClass: "th-body-visible",
                subMenuClass: "th-submenu",
                subMenuParent: "menu-item-has-children",
                thSubMenuParent: "th-item-has-children",
                subMenuParentToggle: "th-active",
                meanExpandClass: "th-mean-expand",
                appendElement: '<span class="th-mean-expand"></span>',
                subMenuToggleClass: "th-open",
                toggleSpeed: 400,
            },
            options
        );

        return this.each(function () {
            var menu = $(this); // Select menu

            // Menu Show & Hide
            function menuToggle() {
                menu.toggleClass(opt.bodyToggleClass);

                // collapse submenu on menu hide or show
                var subMenu = "." + opt.subMenuClass;
                $(subMenu).each(function () {
                    if ($(this).hasClass(opt.subMenuToggleClass)) {
                        $(this).removeClass(opt.subMenuToggleClass);
                        $(this).css("display", "none");
                        $(this).parent().removeClass(opt.subMenuParentToggle);
                    }
                });
            }

            // Class Set Up for every submenu
            menu.find("." + opt.subMenuParent).each(function () {
                var submenu = $(this).find("ul");
                submenu.addClass(opt.subMenuClass);
                submenu.css("display", "none");
                $(this).addClass(opt.subMenuParent);
                $(this).addClass(opt.thSubMenuParent); // Add th-item-has-children class
                $(this).children("a").append(opt.appendElement);
            });

            // Toggle Submenu
            function toggleDropDown($element) {
                var submenu = $element.children("ul");
                if (submenu.length > 0) {
                    $element.toggleClass(opt.subMenuParentToggle);
                    submenu.slideToggle(opt.toggleSpeed);
                    submenu.toggleClass(opt.subMenuToggleClass);
                }
            }

            // Submenu toggle Button
            var itemHasChildren = "." + opt.thSubMenuParent + " > a";
            $(itemHasChildren).each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    toggleDropDown($(this).parent());
                });
            });

            // Menu Show & Hide On Toggle Btn click
            $(opt.menuToggleBtn).each(function () {
                $(this).on("click", function () {
                    menuToggle();
                });
            });

            // Hide Menu On outside click
            menu.on("click", function (e) {
                e.stopPropagation();
                menuToggle();
            });

            // Stop Hide full menu on menu click
            menu.find("div").on("click", function (e) {
                e.stopPropagation();
            });
        });
    };

    $(".th-menu-wrapper").thmobilemenu();

    document.addEventListener("DOMContentLoaded", function () {
        let menuItems = document.querySelectorAll(".menu-item-has-children > a");

        menuItems.forEach((menuItem) => {
            menuItem.addEventListener("click", function (e) {
                e.preventDefault();

                let parent = this.parentElement;
                let submenu = parent.querySelector(".sub-menu");

                if (submenu) {
                    // Close other open submenus
                    document.querySelectorAll(".sub-menu").forEach((item) => {
                        if (item !== submenu) {
                            item.style.maxHeight = null;
                            item.parentElement.classList.remove("open");
                        }
                    });

                    // Toggle the clicked submenu
                    if (submenu.style.maxHeight) {
                        submenu.style.maxHeight = null;
                        parent.classList.remove("open");
                    } else {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                        parent.classList.add("open");
                    }
                }
            });
        });
    });

    /*---------- 04. Sticky fix ----------*/
    $(window).scroll(function () {
        var topPos = $(this).scrollTop();
        if (topPos > 500) {
            $('.sticky-wrapper').addClass('sticky');
            $('.category-menu').addClass('close-category');
        } else {
            $('.sticky-wrapper').removeClass('sticky')
            $('.category-menu').removeClass('close-category');
        }
    })

    /*----------- One Page Nav ----------*/
    function onePageNav(element) {
        if ($(element).length > 0) {
            $(element).each(function () {
                var link = $(this).find('a');
                $(this).find(link).each(function () {
                    $(this).on('click', function () {
                        var target = $(this.getAttribute('href'));
                        if (target.length) {
                            event.preventDefault();
                            $('html, body').stop().animate({
                                scrollTop: target.offset().top - 10
                            }, 1000);
                        };

                    });
                });
            })
        }
    };
    onePageNav('.onepage-nav');
    onePageNav('.scroll-down');

    /*---------- 05. Scroll To Top ----------*/
    if ($('.scroll-top').length > 0) {

        var scrollTopbtn = document.querySelector('.scroll-top');
        var progressPath = document.querySelector('.scroll-top path');
        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
        progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
        var updateProgress = function () {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength / height);
            progressPath.style.strokeDashoffset = progress;
        }
        updateProgress();
        $(window).scroll(updateProgress);
        var offset = 50;
        var duration = 750;
        jQuery(window).on('scroll', function () {
            if (jQuery(this).scrollTop() > offset) {
                jQuery(scrollTopbtn).addClass('show');
            } else {
                jQuery(scrollTopbtn).removeClass('show');
            }
        });
        jQuery(scrollTopbtn).on('click', function (event) {
            event.preventDefault();
            jQuery('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        })
    }

    /*---------- 06. Set Background Image Color & Mask ----------*/
    if ($("[data-bg-src]").length > 0) {
        $("[data-bg-src]").each(function () {
            var src = $(this).attr("data-bg-src");
            $(this).css("background-image", "url(" + src + ")");
            $(this).removeAttr("data-bg-src").addClass("background-image");
        });
    }

    if ($('[data-bg-color]').length > 0) {
        $('[data-bg-color]').each(function () {
            var color = $(this).attr('data-bg-color');
            $(this).css('background-color', color);
            $(this).removeAttr('data-bg-color');
        });
    };

    $('[data-border]').each(function () {
        var borderColor = $(this).data('border');
        $(this).css('--th-border-color', borderColor);
    });

    if ($('[data-mask-src]').length > 0) {
        $('[data-mask-src]').each(function () {
            var mask = $(this).attr('data-mask-src');
            $(this).css({
                'mask-image': 'url(' + mask + ')',
                '-webkit-mask-image': 'url(' + mask + ')'
            });
            $(this).addClass('bg-mask');
            $(this).removeAttr('data-mask-src');
        });
    };



    // Background image area start here ***
    $("[data-background").each(function () {
        $(this).css(
            "background-image",
            "url( " + $(this).attr("data-background") + "  )"
        );
    });
    // Background image area end here ***

    // Background image hover change area start here ***
    $(".hotel-card").hover(function () {
        let newBackground = $(this).data("bg");
        $(".hotel-area")
            .attr("data-background", newBackground)
            .css("background-image", "url(" + newBackground + ")");
    });
    // Background image hover change area end here ***
    // Background image hover change area start here ***
    $(".hotel-card2").hover(function () {
        let newBackground = $(this).data("bg");
        $(".hotel-area2")
            .attr("data-background", newBackground)
            .css("background-image", "url(" + newBackground + ")");
    });
    // Background image hover change area end here ***


    /*----------- 07. Global Slider ----------*/
    $('.th-slider').each(function () {
        var thSlider = $(this);
        var settings = $(this).data('slider-options');

        // Store references to navigation elements
        var prevArrow = thSlider.find('.slider-prev');
        var nextArrow = thSlider.find('.slider-next');
        var paginationElN = thSlider.find('.slider-pagination.pagi-number');
        var paginationExternel = thSlider.siblings('.slider-controller').find('.slider-pagination');
        var paginationEl = paginationExternel.length ? paginationExternel.get(0) : thSlider.find('.slider-pagination').get(0);
        var paginationType = settings['paginationType'] ? settings['paginationType'] : 'bullets';

        var autoplayCondition = settings['autoplay'];

        var sliderDefault = {
            slidesPerView: 1,
            spaceBetween: settings['spaceBetween'] ? settings['spaceBetween'] : 24,
            loop: settings['loop'] === false ? false : true,
            speed: settings['speed'] ? settings['speed'] : 1000,
            autoplay: autoplayCondition ? autoplayCondition : {
                delay: 6000,
                disableOnInteraction: false
            },
            navigation: {
                nextEl: nextArrow.get(0),
                prevEl: prevArrow.get(0),
            },
            pagination: {
                el: paginationEl,
                type: paginationType,
                clickable: true,
                renderBullet: function (index, className) {
                    var number = index + 1;
                    var formattedNumber = number < 10 ? '0' + number : number;
                    if (paginationElN.length) {
                        return '<span class="' + className + ' number">' + formattedNumber + '</span>';
                    } else {
                        return '<span class="' + className + '" aria-label="Go to Slide ' + formattedNumber + '"></span>';
                    }
                },
            },
            on: {
                init: function () {
                    setTimeout(() => updateNavBackground(this, thSlider), 100);
                },
                slideChange: function () {
                    setTimeout(() => updateNavBackground(this, thSlider), 100);
                }
            }
        };

        var options = $.extend({}, sliderDefault, settings);
        var swiperInstance = new Swiper(thSlider.get(0), options);

        // Apply panorama effect to slides with images
        thSlider.find('.swiper-slide').each(function () {
            var slide = $(this);
            var image = slide.find('img');

            if (image.length) {
                var panoramaImageSrc = image.attr('src');
                var viewerContainer = slide.find('.room-panorama-slide').get(0);

                if (viewerContainer) {
                    var panoramaImage = new PANOLENS.ImagePanorama(panoramaImageSrc);
                    var viewer = new PANOLENS.Viewer({
                        container: viewerContainer,
                        autoRotate: true,
                        autoRotateSpeed: 0.3,
                        controlBar: false,
                    });
                    viewer.add(panoramaImage);

                    // Disable Swiper interactions when viewing panorama
                    viewer.addEventListener('enter', function () {
                        swiperInstance.allowTouchMove = false;
                    });
                    viewer.addEventListener('exit', function () {
                        swiperInstance.allowTouchMove = true;
                    });
                }
            }
        });

        if ($('.slider-area').length > 0) {
            $('.slider-area').closest(".container").parent().addClass("arrow-wrap");
        }
    });

    // Function to update navigation background dynamically
    function updateNavBackground(swiperInstance, sliderElement) {
        const slides = sliderElement.find(".swiper-slide");
        const nextArrow = sliderElement.find(".slider-next-bg");
        const prevArrow = sliderElement.find(".slider-prev-bg");

        if (!nextArrow.length || !prevArrow.length || slides.length === 0) return;

        let activeIndex = swiperInstance.activeIndex;

        let nextSlide = slides.eq((activeIndex + 1) % slides.length);
        let prevSlide = slides.eq((activeIndex - 1 + slides.length) % slides.length);

        let nextBg = nextSlide.css("background-image");
        let prevBg = prevSlide.css("background-image");

        if (nextBg === "none") {
            let nextImg = nextSlide.find("img").attr("src");
            nextBg = nextImg ? `url(${nextImg})` : "";
        }
        if (prevBg === "none") {
            let prevImg = prevSlide.find("img").attr("src");
            prevBg = prevImg ? `url(${prevImg})` : "";
        }

        setTimeout(() => {
            nextArrow.css({
                "transition": "background 0.5s ease-in-out",
                "background-size": "cover",
                "background-position": "center",
                "background-repeat": "no-repeat",
                "background-image": nextBg
            });
            prevArrow.css({
                "transition": "background 0.5s ease-in-out",
                "background-size": "cover",
                "background-position": "center",
                "background-repeat": "no-repeat",
                "background-image": prevBg
            });
        }, 100);
    }

    // Function to add animation classes
    function animationProperties() {
        $('[data-ani]').each(function () {
            var animationName = $(this).data('ani');
            $(this).addClass(animationName);
        });

        $('[data-ani-delay]').each(function () {
            var delayTime = $(this).data('ani-delay');
            $(this).css('animation-delay', delayTime);
        });
    }
    animationProperties();

    // Add click event handlers for external slider arrows based on data attributes
    $('[data-slider-prev], [data-slider-next]').on('click', function () {
        var sliderSelector = $(this).data('slider-prev') || $(this).data('slider-next');
        var targetSlider = $(sliderSelector);

        if (targetSlider.length) {
            var swiper = targetSlider[0].swiper;

            if (swiper) {
                if ($(this).data('slider-prev')) {
                    swiper.slidePrev();
                } else {
                    swiper.slideNext();
                }
            }
        }
    });



    /*----------- 07. Global Slider ----------*/
    // $('.th-slider').each(function () {

    //     var thSlider = $(this);
    //     var settings = $(this).data('slider-options');

    //     // Store references to the navigation Slider
    //     var prevArrow = thSlider.find('.slider-prev');
    //     var nextArrow = thSlider.find('.slider-next');
    //     var paginationElN = thSlider.find('.slider-pagination.pagi-number');
    //     var paginationExternel = thSlider.siblings('.slider-controller').find('.slider-pagination');

    //     var paginationEl = paginationExternel.length ? paginationExternel.get(0) : thSlider.find('.slider-pagination').get(0);

    //     var paginationType = settings['paginationType'] ? settings['paginationType'] : 'bullets';

    //     var autoplayconditon = settings['autoplay'];

    //     var sliderDefault = {
    //         slidesPerView: 1,
    //         spaceBetween: settings['spaceBetween'] ? settings['spaceBetween'] : 24,
    //         loop: settings['loop'] == false ? false : true,
    //         speed: settings['speed'] ? settings['speed'] : 1000,
    //         autoplay: autoplayconditon ? autoplayconditon : {
    //             delay: 6000,
    //             disableOnInteraction: false
    //         },
    //         navigation: {
    //             nextEl: nextArrow.get(0),
    //             prevEl: prevArrow.get(0),
    //         },
    //         pagination: {
    //             el: paginationEl,
    //             type: paginationType,
    //             clickable: true,
    //             renderBullet: function (index, className) {
    //                 var number = index + 1;
    //                 var formattedNumber = number < 10 ? '0' + number : number;
    //                 if (paginationElN.length) {
    //                     return '<span class="' + className + ' number">' + formattedNumber + '</span>';
    //                 } else {
    //                     return '<span class="' + className + '" aria-label="Go to Slide ' + formattedNumber + '"></span>';
    //                 }
    //             },
    //             formatFractionCurrent: function (number) {
    //                 if (number < 10) {
    //                     return '0' + number;
    //                 } else {
    //                     return number;
    //                 }
    //             },
    //             formatFractionTotal: function (number) {
    //                 if (number < 10) {
    //                     return '0' + number;
    //                 } else {
    //                     return number;
    //                 }
    //             }
    //         },
    //         on: {
    //             slideChange: function () {
    //                 setTimeout(function () {
    //                     swiper.params.mousewheel.releaseOnEdges = false;
    //                 }, 500);
    //             },
    //             reachEnd: function () {
    //                 setTimeout(function () {
    //                     swiper.params.mousewheel.releaseOnEdges = true;
    //                 }, 750);
    //             }
    //         }
    //     };

    //     var options = JSON.parse(thSlider.attr('data-slider-options'));
    //     options = $.extend({}, sliderDefault, options);
    //     var swiper = new Swiper(thSlider.get(0), options); // Assign the swiper variable

    //     var swiper = new Swiper(thSlider.find('.swiper-container').get(0), options);

    //     // Apply panorama effect to slides with images
    //     thSlider.find('.swiper-slide').each(function () {
    //         var slide = $(this);
    //         var image = slide.find('img');

    //         if (image.length) {
    //             var panoramaImageSrc = image.attr('src');
    //             var viewerContainer = slide.find('.room-panorama-slide').get(0);

    //             if (viewerContainer) {
    //                 var panoramaImage = new PANOLENS.ImagePanorama(panoramaImageSrc);
    //                 var viewer = new PANOLENS.Viewer({
    //                     container: viewerContainer,
    //                     autoRotate: true,
    //                     autoRotateSpeed: 0.3,
    //                     controlBar: false,
    //                 });
    //                 viewer.add(panoramaImage);

    //                 // Disable Swiper interactions when viewing panorama
    //                 viewer.addEventListener('enter', function () {
    //                     swiper.allowTouchMove = false;
    //                 });
    //                 viewer.addEventListener('exit', function () {
    //                     swiper.allowTouchMove = true;
    //                 });
    //             }
    //         }
    //     });

    //     if ($('.slider-area').length > 0) {
    //         $('.slider-area').closest(".container").parent().addClass("arrow-wrap");
    //     }

    // });

    // // Function to add animation classes
    // function animationProperties() {
    //     $('[data-ani]').each(function () {
    //         var animationName = $(this).data('ani');
    //         $(this).addClass(animationName);
    //     });

    //     $('[data-ani-delay]').each(function () {
    //         var delayTime = $(this).data('ani-delay');
    //         $(this).css('animation-delay', delayTime);
    //     });
    // }
    // animationProperties();

    // // Add click event handlers for external slider arrows based on data attributes
    // $('[data-slider-prev], [data-slider-next]').on('click', function () {
    //     var sliderSelector = $(this).data('slider-prev') || $(this).data('slider-next');
    //     var targetSlider = $(sliderSelector);

    //     if (targetSlider.length) {
    //         var swiper = targetSlider[0].swiper;

    //         if (swiper) {
    //             if ($(this).data('slider-prev')) {
    //                 swiper.slidePrev();
    //             } else {
    //                 swiper.slideNext();
    //             }
    //         }
    //     }
    // });

    var swiper = new Swiper(".cubeSwiper", {
        effect: "cube",
        grabCursor: true,
        pauseOnMouseEnter: true,
        speed: 1000,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        cubeEffect: {
            shadow: false,
            slideShadows: true,
            shadowOffset: 20,
            shadowScale: 0.94,
        },
        pagination: {
            el: ".swiper-pagination",
        },
    });

    /*-------------- 08. Slider Tab -------------*/
    $.fn.activateSliderThumbs = function (options) {
        var opt = $.extend({
                sliderTab: false,
                tabButton: ".tab-btn",
            },
            options
        );

        return this.each(function () {
            var $container = $(this);
            var $thumbs = $container.find(opt.tabButton);
            var $line = $('<span class="indicator"></span>').appendTo($container);

            var sliderSelector = $container.data("slider-tab");
            var $slider = $(sliderSelector);

            var swiper = $slider[0].swiper;

            $thumbs.on("click", function (e) {
                e.preventDefault();
                var clickedThumb = $(this);

                clickedThumb.addClass("active").siblings().removeClass("active");
                linePos(clickedThumb, $container);

                clickedThumb.prevAll(opt.tabButton).addClass('list-active');
                clickedThumb.nextAll(opt.tabButton).removeClass('list-active');

                if (opt.sliderTab) {
                    var slideIndex = clickedThumb.index();
                    swiper.slideTo(slideIndex);
                }
            });

            if (opt.sliderTab) {
                swiper.on("slideChange", function () {
                    var activeIndex = swiper.realIndex;
                    var $activeThumb = $thumbs.eq(activeIndex);

                    $activeThumb.addClass("active").siblings().removeClass("active");
                    linePos($activeThumb, $container);

                    $activeThumb.prevAll(opt.tabButton).addClass('list-active');
                    $activeThumb.nextAll(opt.tabButton).removeClass('list-active');
                });

                var initialSlideIndex = swiper.activeIndex;
                var $initialThumb = $thumbs.eq(initialSlideIndex);
                $initialThumb.addClass("active").siblings().removeClass("active");
                linePos($initialThumb, $container);

                $initialThumb.prevAll(opt.tabButton).addClass('list-active');
                $initialThumb.nextAll(opt.tabButton).removeClass('list-active');
            }

            function linePos($activeThumb) {
                var thumbOffset = $activeThumb.position();

                var marginTop = parseInt($activeThumb.css('margin-top')) || 0;
                var marginLeft = parseInt($activeThumb.css('margin-left')) || 0;

                $line.css("--height-set", $activeThumb.outerHeight() + "px");
                $line.css("--width-set", $activeThumb.outerWidth() + "px");
                $line.css("--pos-y", thumbOffset.top + marginTop + "px");
                $line.css("--pos-x", thumbOffset.left + marginLeft + "px");
            }
        });
    };

    if ($(".testi-box-tab").length) {
        $(".testi-box-tab").activateSliderThumbs({
            sliderTab: true,
            tabButton: ".tab-btn",
        });
    }



    /*----------- 09. Ajax Contact Form ----------*/
    var form = ".ajax-contact";
    var invalidCls = "is-invalid";
    var $email = '[name="email"]';
    var $validation =
        '[name="name"],[name="email"],[name="subject"],[name="number"],[name="message"]'; // Must be use (,) without any space
    var formMessages = $(".form-messages");

    function sendContact() {
        var formData = $(form).serialize();
        var valid;
        valid = validateContact();
        if (valid) {
            jQuery
                .ajax({
                    url: $(form).attr("action"),
                    data: formData,
                    type: "POST",
                })
                .done(function (response) {
                    // Make sure that the formMessages div has the 'success' class.
                    formMessages.removeClass("error");
                    formMessages.addClass("success");
                    // Set the message text.
                    formMessages.text(response);
                    // Clear the form.
                    $(
                        form +
                        ' input:not([type="submit"]),' +
                        form +
                        " textarea"
                    ).val("");
                })
                .fail(function (data) {
                    // Make sure that the formMessages div has the 'error' class.
                    formMessages.removeClass("success");
                    formMessages.addClass("error");
                    // Set the message text.
                    if (data.responseText !== "") {
                        formMessages.html(data.responseText);
                    } else {
                        formMessages.html(
                            "Oops! An error occured and your message could not be sent."
                        );
                    }
                });
        }
    }

    function validateContact() {
        var valid = true;
        var formInput;

        function unvalid($validation) {
            $validation = $validation.split(",");
            for (var i = 0; i < $validation.length; i++) {
                formInput = form + " " + $validation[i];
                if (!$(formInput).val()) {
                    $(formInput).addClass(invalidCls);
                    valid = false;
                } else {
                    $(formInput).removeClass(invalidCls);
                    valid = true;
                }
            }
        }
        unvalid($validation);

        if (
            !$($email).val() ||
            !$($email)
            .val()
            .match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)
        ) {
            $($email).addClass(invalidCls);
            valid = false;
        } else {
            $($email).removeClass(invalidCls);
            valid = true;
        }
        return valid;
    }

    $(form).on("submit", function (element) {
        element.preventDefault();
        sendContact();
    });

    /*---------- 11. Popup Sidemenu ----------*/
    function popupSideMenu($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
        // Sidebar Popup
        $($sideMunuOpen).on('click', function (e) {
            e.preventDefault();
            $($sideMenu).addClass($toggleCls);
        });
        $($sideMenu).on('click', function (e) {
            e.stopPropagation();
            $($sideMenu).removeClass($toggleCls)
        });
        var sideMenuChild = $sideMenu + ' > div';
        $(sideMenuChild).on('click', function (e) {
            e.stopPropagation();
            $($sideMenu).addClass($toggleCls)
        });
        $($sideMenuCls).on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $($sideMenu).removeClass($toggleCls);
        });
    };
    popupSideMenu('.sidemenu-wrapper', '.sideMenuToggler', '.sideMenuCls', 'show');

    /*----------- 11. Magnific Popup ----------*/
    /* magnificPopup img view */
    $(".popup-image").magnificPopup({
        type: "image",
        mainClass: 'mfp-zoom-in',
        removalDelay: 260,
        gallery: {
            enabled: true,
        },
    });

    /* magnificPopup video view */
    $(".popup-video").magnificPopup({
        type: "iframe",
    });

    /* magnificPopup video view */
    $(".popup-content").magnificPopup({
        type: "inline",
        midClick: true,
    });


    /************lettering js***********/
    function injector(t, splitter, klass, after) {
        var a = t.text().split(splitter),
            inject = '';
        if (a.length) {
            $(a).each(function (i, item) {
                inject += '<span class="' + klass + (i + 1) + '">' + item + '</span>' + after;
            });
            t.empty().append(inject);
        }
    }

    var methods = {
        init: function () {

            return this.each(function () {
                injector($(this), '', 'char', '');
            });

        },

        words: function () {

            return this.each(function () {
                injector($(this), ' ', 'word', ' ');
            });

        },

        lines: function () {

            return this.each(function () {
                var r = "eefec303079ad17405c889e092e105b0";
                // Because it's hard to split a <br/> tag consistently across browsers,
                // (*ahem* IE *ahem*), we replaces all <br/> instances with an md5 hash 
                // (of the word "split").  If you're trying to use this plugin on that 
                // md5 hash string, it will fail because you're being ridiculous.
                injector($(this).children("br").replaceWith(r).end(), r, 'line', '');
            });

        }
    };

    $.fn.lettering = function (method) {
        // Method calling logic
        if (method && methods[method]) {
            return methods[method].apply(this, [].slice.call(arguments, 1));
        } else if (method === 'letters' || !method) {
            return methods.init.apply(this, [].slice.call(arguments, 0)); // always pass an array
        }
        $.error('Method ' + method + ' does not exist on jQuery.lettering');
        return this;
    };

    $(".discount-anime").lettering();

    /*---------- 12. Section Position ----------*/
    // Interger Converter
    function convertInteger(str) {
        return parseInt(str, 10);
    }

    $.fn.sectionPosition = function (mainAttr, posAttr) {
        $(this).each(function () {
            var section = $(this);

            function setPosition() {
                var sectionHeight = Math.floor(section.height() / 2), // Main Height of section
                    posData = section.attr(mainAttr), // where to position
                    posFor = section.attr(posAttr), // On Which section is for positioning
                    topMark = "top-half", // Pos top
                    bottomMark = "bottom-half", // Pos Bottom
                    parentPT = convertInteger($(posFor).css("padding-top")), // Default Padding of  parent
                    parentPB = convertInteger($(posFor).css("padding-bottom")); // Default Padding of  parent

                if (posData === topMark) {
                    $(posFor).css(
                        "padding-bottom",
                        parentPB + sectionHeight + "px"
                    );
                    section.css("margin-top", "-" + sectionHeight + "px");
                } else if (posData === bottomMark) {
                    $(posFor).css(
                        "padding-top",
                        parentPT + sectionHeight + "px"
                    );
                    section.css("margin-bottom", "-" + sectionHeight + "px");
                }
            }
            setPosition(); // Set Padding On Load
        });
    };

    var postionHandler = "[data-sec-pos]";
    if ($(postionHandler).length) {
        $(postionHandler).imagesLoaded(function () {
            $(postionHandler).sectionPosition("data-sec-pos", "data-pos-for");
        });
    }

    /*----------- 15. Filter ----------*/
    $(".filter-active").imagesLoaded(function () {
        var $filter = ".filter-active",
            $filterItem = ".filter-item",
            $filterMenu = ".filter-menu-active";

        if ($($filter).length > 0) {
            var $grid = $($filter).isotope({
                itemSelector: $filterItem,
                filter: "*",
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: 1,
                },
            });

            // filter items on button click
            $($filterMenu).on("click", "button", function () {
                var filterValue = $(this).attr("data-filter");
                $grid.isotope({
                    filter: filterValue,
                });
            });

            // Menu Active Class
            $($filterMenu).on("click", "button", function (event) {
                event.preventDefault();
                $(this).addClass("active");
                $(this).siblings(".active").removeClass("active");
            });
        }
    });

    $(".masonary-active, .woocommerce-Reviews .comment-list").imagesLoaded(function () {
        var $filter = ".masonary-active, .woocommerce-Reviews .comment-list",
            $filterItem = ".filter-item, .woocommerce-Reviews .comment-list li";

        if ($($filter).length > 0) {
            $($filter).isotope({
                itemSelector: $filterItem,
                filter: "*",
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: 1,
                },
            });
        }
        $('[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($filter).isotope({
                filter: "*",
            });
        });
    });




    /*----------- 14. Counter Up ----------*/
    $(".counter-number").counterUp({
        delay: 10,
        time: 1000,
    });

    /*----------- 15. Hover Item ----------*/
    $(".hover-item").hover(function () {
        $(this).addClass("item-active");
        $(this).siblings().removeClass("item-active");
    });

    /*----------- 16. Shape Mockup ----------*/
    $.fn.shapeMockup = function () {
        var $shape = $(this);
        $shape.each(function () {
            var $currentShape = $(this),
                shapeTop = $currentShape.data("top"),
                shapeRight = $currentShape.data("right"),
                shapeBottom = $currentShape.data("bottom"),
                shapeLeft = $currentShape.data("left");
            $currentShape
                .css({
                    top: shapeTop,
                    right: shapeRight,
                    bottom: shapeBottom,
                    left: shapeLeft,
                })
                .removeAttr("data-top")
                .removeAttr("data-right")
                .removeAttr("data-bottom")
                .removeAttr("data-left")
                .parent()
                .addClass("shape-mockup-wrap");
        });
    };

    if ($(".shape-mockup")) {
        $(".shape-mockup").shapeMockup();
    }


    /*----------- 16. Shape Mockup ----------*/
    $.fn.shapeMockup2 = function () {
        var $shape = $(this);
        $shape.each(function () {
            var $currentShape = $(this),
                shapeTop = $currentShape.data("top"),
                shapeRight = $currentShape.data("right"),
                shapeBottom = $currentShape.data("bottom"),
                shapeLeft = $currentShape.data("left");
            $currentShape
                .css({
                    top: shapeTop,
                    right: shapeRight,
                    bottom: shapeBottom,
                    left: shapeLeft,
                })
                .removeAttr("data-top")
                .removeAttr("data-right")
                .removeAttr("data-bottom")
                .removeAttr("data-left")
                .parent()
                .addClass("shape-mockup-wrap2");
        });
    };

    if ($(".shape-mockup2")) {
        $(".shape-mockup2").shapeMockup2();
    }

    /*----------- 17. Progress Bar Animation ----------*/
    $('.progress-bar').waypoint(function () {
        $('.progress-bar').css({
            animation: "animate-positive 1.8s",
            opacity: "1"
        });
    }, {
        offset: '75%'
    });

    /*----------- 18. Countdown ----------*/

    $.fn.countdown = function () {
        $(this).each(function () {
            var $counter = $(this),
                countDownDate = new Date($counter.data("offer-date")).getTime(), // Set the date we're counting down toz
                exprireCls = "expired";

            // Finding Function
            function s$(element) {
                return $counter.find(element);
            }

            // Update the count down every 1 second
            var counter = setInterval(function () {
                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                );
                var minutes = Math.floor(
                    (distance % (1000 * 60 * 60)) / (1000 * 60)
                );
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Check If value is lower than ten, so add zero before number
                days < 10 ? (days = "0" + days) : null;
                hours < 10 ? (hours = "0" + hours) : null;
                minutes < 10 ? (minutes = "0" + minutes) : null;
                seconds < 10 ? (seconds = "0" + seconds) : null;

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(counter);
                    $counter.addClass(exprireCls);
                    $counter.find(".message").css("display", "block");
                } else {
                    // Output the result in elements
                    s$(".day").html(days);
                    s$(".hour").html(hours);
                    s$(".minute").html(minutes);
                    s$(".seconds").html(seconds);
                }
            }, 1000);
        });
    };

    if ($(".counter-list").length) {
        $(".counter-list").countdown();
    }

    /*---------- 19. Hero 2 Animation ----------*/
    if ($('.hero-2').length > 0) {
        window.addEventListener('scroll', function () {
            let value = window.scrollY;
            $('.line').css('width', "calc(" + 'var(--size)' + " - " + value * 0.1 + 'px' + ")");
        })
    };

    /*----------- 21. Overlay Direction ----------*/
    if ($('.overlay-direction').length > 0) {
        if (window.innerWidth > 767) {
            const nodes = [].slice.call(document.querySelectorAll(".overlay-direction .filter-item"), 0);
            const directions = {
                0: "top",
                1: "right",
                2: "bottom",
                3: "left"
            };
            const classNames = ["in", "out"].map(p => Object.values(directions).map(d => `${p}-${d}`)).reduce((a, b) => a.concat(b));
            const getDirectionKey = (ev, node) => {
                const {
                    width,
                    height,
                    top,
                    left
                } = node.getBoundingClientRect();
                const l = ev.pageX - (left + window.pageXOffset);
                const t = ev.pageY - (top + window.pageYOffset);
                const x = l - width / 2 * (width > height ? height / width : 1);
                const y = t - height / 2 * (height > width ? width / height : 1);
                return Math.round(Math.atan2(y, x) / 1.57079633 + 5) % 4;
            };
            class Item {
                constructor(element) {
                    this.element = element;
                    this.element.addEventListener("mouseover", ev => this.update(ev, "in"));
                    this.element.addEventListener("mouseout", ev => this.update(ev, "out"));
                }
                update(ev, prefix) {
                    this.element.classList.remove(...classNames);
                    this.element.classList.add(`${prefix}-${directions[getDirectionKey(ev, this.element)]}`);
                }
            }
            nodes.forEach(node => new Item(node));
        }
    }

    /*----------- 22. Indicator ----------*/
    // Indicator
    $.fn.indicator = function () {
        // Loop through each .indicator-active element
        $(this).each(function () {
            var $menu = $(this),
                $linkBtn = $menu.find("a"),
                $btn = $menu.find("button");

            // Append indicator
            $menu.append('<span class="indicator"></span>');
            var $line = $menu.find(".indicator");

            // Check which type button is Available
            var $currentBtn;
            if ($linkBtn.length) {
                $currentBtn = $linkBtn;
            } else if ($btn.length) {
                $currentBtn = $btn;
            }

            // On Click Button Class Remove
            $currentBtn.on("click", function (e) {
                e.preventDefault();
                $(this).addClass("active");
                $(this).siblings(".active").removeClass("active");
                linePos();
            });

            // Indicator Position
            function linePos() {
                var $btnActive = $menu.find(".active"),
                    $height = $btnActive.css("height"),
                    $width = $btnActive.css("width"),
                    $top = $btnActive.position().top + "px",
                    $left = $btnActive.position().left + "px";

                $(window).on('resize', function () {
                    $top = $btnActive.position().top + "px",
                        $left = $btnActive.position().left + "px";
                });

                $line.get(0).style.setProperty("--height-set", $height);
                $line.get(0).style.setProperty("--width-set", $width);
                $line.get(0).style.setProperty("--pos-y", $top);
                $line.get(0).style.setProperty("--pos-x", $left);
            }

            linePos();
            $(window).on('resize', function () {
                linePos();
            });
        });
    };

    if ($(".indicator-active").length) {
        $(".indicator-active").indicator();
    }


    $(".slider-drag-wrap").hover(function() {
        $('.slider-drag-cursor').addClass('active');
    }, function() {
        $('.slider-drag-cursor').removeClass('active');
    });

    $(".slider-drag-wrap a").hover(function() {
        $('.slider-drag-cursor').removeClass('active');
    }, function() {
        $('.slider-drag-cursor').addClass('active');
    });



    // // /*----------- 00. Right Click Disable ----------*/ 
    //   window.addEventListener('contextmenu', function (e) {
    //     // do something here...
    //     e.preventDefault();  
    //   }, false);  

    // // /*----------- 00. Inspect Element Disable ----------*/   
    //   document.onkeydown = function (e) {   
    //     if (event.keyCode == 123) {  
    //       return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
    //       return false;
    //     }
    //     if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {  
    //       return false;
    //     } 
    //   }  




})(jQuery);