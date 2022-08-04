class QuickFx
{
    constructor()
    {
        this.innerObj = '';
    }
    
    check(acton)
    {
        if (!empty(acton))
            this.innerObj = this.getJQObj;

        (this.innerObj).prop('checked', true);

        return this;
    };

    unCheck(acton)
    {
        if (!empty(acton))
            this.innerObj = this.getJQObj;

        (this.innerObj).prop('checked', unCheck);

        return this;
    }

    getJQObj(acton)
    {
        return (is_object(acton)) ? acton : $(acton);
    }

    checkToggle(acton)
    {
        if (!empty(acton))
            this.innerObj = this.getJQObj;

        (this.innerObj).prop('checked', (this.innerObj.is(":checked")) ? false : true);
        return this;
    }

    doAction(data)
    {
        if (isset(data, 'quickfx'))
            data = data.quickfx;

        if (!isset(data.FX))
            return false;

        var fxAction = data.FX;

        $.each(fxAction.acton, (k, v) => {
            switch (fxAction.acton.fx[k]) {
                case ('check'):
                    this.check(v);
                    break;
                case ('unCheck'):
                    this.check(v);
                    break;
                default:
                    this.checkToggle(v);
                    break;
            }
        });
    }
}