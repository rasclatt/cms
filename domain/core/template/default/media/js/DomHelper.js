class DomHelper
{
    static parse(str)
    {
        return DomHelper.parseStr(str);
    }
    
    static parseStr(str)
    {
        let base    =   str.replace(/^\?/gi,'').split('&');
        
        if(base.length == 0)
            return false;

        // Create storage
        let n   =   {};
        // Loop key
        let store   =   base.map(x => {
            // Split the key/values
            let sp = x.split('=');
            // See if there is a subarray
            if(sp[0].match(/\[/gi)) {
                // Split out the subarray
                let sub =   sp[0].replace(/\]/gi,'').split('[');
                // Create new array
                if(!isset(n, sub[0])) {
                    n[sub[0]]   =   {};
                }
                // Assign new value
                n[sub[0]][sub[1]]   =   (isset(sp,1))? sp[1] : false;
            }
            else
                // Store standard key
                n[sp[0]]   =   (isset(sp,1))? sp[1] : false;
            // Send results back
            return n;
        });
        
        return n;
    }    
}