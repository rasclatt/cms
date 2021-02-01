class StringWorks
{
    braceReplace(str, obj)
    {
        let keys    =   Object.keys(obj);
        $.each(keys, function(k, v){
            str =   str.replace('{{' + v + '}}', obj[v]);
        });
        
        return str;
    }
	/**
	 *	@description	
	 */
    toString(elem)
	{
        if(typeof elem === "object")
            return JSON.parse(elem);
        
        return elem.toString();
	}
}