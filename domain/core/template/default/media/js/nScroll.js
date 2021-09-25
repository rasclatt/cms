// Create a smooth scroller applet
class nScroll
{
    constructor()
    {
        this.scrollClass = '.scroll-top';
        this.toggleClass = 'add-scroll';
        this.startVal = 100;
        this.useData = {};
    }

    init(data)
    {
        if (empty(data))
            data = {};

        this.scrollClass = (isset(data, 'class') && !empty(data.class)) ? data.class : this.scrollClass;
        this.toggleClass = (isset(data, 'toggle') && !empty(data.toggle)) ? data.toggle : this.toggleClass;
        this.startVal = (isset(data, 'start') && !empty(data.start)) ? data.start : this.startVal;
        this.useData = (isset(data, 'data') && !empty(data.data)) ? data.data : {};

        return this;
    }

    getData()
    {
        return this.useData;
    }

    defAnimation(useFunction)
    {
        if (empty(useFunction)) {
            // Scroll to top of page.
            $(window).scroll(function () {
                if ($(this).scrollTop() > this.startVal) {
                    $(this.scrollClass).fadeIn('slow');
                    $(this.scrollClass).addClass(this.toggleClass);
                }
                else {
                    $(this.scrollClass).css({ "display": "none" });
                    $(this.scrollClass).removeClass(this.toggleClass);
                }
            });
        }
        else {
            useFunction();
        }

        return this;
    };

    clickScroller(obj, speed)
    {
        speed = (speed !== undefined) ? speed : 'slow';

        // scroll-to-top animate
        $(obj).click(function (e) {
            $("html, body").animate({ scrollTop: 0 }, speed);
            e.preventDefault();
        });
    };

    clickScroll(obj, speed)
    {
        if (empty(speed))
            speed = 'fast';
        $("html, body").animate({ scrollTop: $(obj).offset().top }, speed);
    };
};