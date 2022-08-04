class nCountDown
{
    constructor(timezone = 'America/Los_Angeles', locale = 'en-US')
    {
        this.poll = 1000;
        this.timezone = timezone;
        this.locale = locale;
        this.countDownDate = false;
    }

    setFutureDate(DateTime, locale = null, timezone = null)
    {
        this.locale = (typeof locale == null) ? this.locale : locale;
        this.timezone = (typeof timezone == null) ? this.timezone : timezone;
        // Set the date we're counting down to
        // DateTime needs to be formatted as Jan 2, 2018 16:47:58
        this.countDownDate = new Date(new Date(DateTime).toLocaleString(this.locale, { timeZone: this.timezone }));
        return this;
    };

    createClock(elemId, doneMessage, locale, timezone)
    {
        this.locale = (typeof locale == "undefined") ? this.locale : locale;
        this.timezone = (typeof timezone == "undefined") ? this.timezone : timezone;

        // Update the count down every 1 second
        var x = setInterval(() => {
            var now = new Date(new Date().toLocaleString(this.locale, { timeZone: this.timezone }));
            // Find the distance between now an the count down date
            var distance = this.countDownDate - now;
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            if (typeof elemId == "function") {
                elemId(x, self, days, hours, minutes, seconds);
            }
            else {
                // Display the result in the element with id="demo"
                $(elemId).html(
                    `<div class="cd-wrap">
                        <div class="cd-large-num">${(days.toString()).padStart(2, 0)}</div>
                        <div class="cd-small-num">Days</div>
                    </div>
                    <div class="cd-wrap">
                        <div class="cd-large-num">${(hours.toString()).padStart(2, 0)}</div>
                        <div class="cd-small-num">Hrs</div>
                    </div>
                    <div class="cd-wrap">
                        <div class="cd-large-num">${(minutes.toString()).padStart(2, 0)}</div>
                        <div class="cd-small-num">Mins</div>
                    </div>
                    <div class="cd-wrap">
                        <div class="cd-large-num">${(seconds.toString()).padStart(2, 0)}</div>
                        <div class="cd-small-num">Secs</div>
                    </div>`
                );
            }
            // If the count down is finished, write some text 
            if (distance < 0) {
                clearInterval(x);
                if (typeof doneMessage == "function")
                    doneMessage(self);
                else
                    $(elemId).html(doneMessage).addClass('col-1 span-');
            }
        }, this.poll);
    };
}