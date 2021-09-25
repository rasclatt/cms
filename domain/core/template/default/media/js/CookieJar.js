class CookieJar
{
    static destroy(cname)
    {
        let d = new Date();
        d.setTime(d.getTime() - (1 * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=;" + expires + ";path=/";
    }
    
    static set(cname, cvalue, exdays)
    {
        if(typeof exdays === "undefined")
            exdays  =   1;
        if(typeof cvalue === "undefined")
            cvalue  =   false;
        let d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    static get(cname)
    {
        let c   =   {};
        var ca = document.cookie.split(';');
        
        for(var i = 0; i < ca.length; i++) {
            let sp  =   ca[i].split('=');
            c[sp[0].replace(/^\s|\s$/gi,'')]    =   sp[1].replace(/^\s|\s$/gi,'');
        }
        if(typeof cname != "undefined")
            return (typeof c[cname] !== "undefined")? c[cname] : false;
        
        return c;
    }
}
