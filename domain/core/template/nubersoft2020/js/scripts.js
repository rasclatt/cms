function loadSpinner()
{
    $('#loadspot-modal').html('loading...');
}

var autoTranslate;

function runTranslator()
{
    autoTranslate = setTimeout(() => {
        translatePage();
    }, 1500);
}

function stopTranslator()
{
    clearTimeout(autoTranslate);
}

function translatePage()
{
    var transfields =   $(document).find('.trans-cls');
    
    if(transfields.length > 0) {
        var trans   =   {}; 
        /*******************************************************/
        /******************* TRANSLATOR APP ********************/
        /*******************************************************/
        // Parse query string
        var queryStr    =   DomHelper.parse(window.location.search);
        // Fetch data language, set to cookie
        if(typeof queryStr.language !== "undefined")
            CookieJar.set('language', (queryStr.language).toLowerCase());
        // There may be a hardcoded lang
        if(typeof lang === "undefined") {
            // Fetch language
            var lang    =   CookieJar.get('language');
        }
        // Reset it if not exists
        if(typeof lang !== "string")
            var lang    =   'en';
        // Set key store
        var allKeys =   [];
        // Set generator store
        var allContents =   {};
        // Set all the keys that require translation
        $.each(transfields, (k,v) => {
            allKeys.push($(v).data('trans'));
            // Save the contents of a transkey
            allContents[$(v).data('trans')] =   $(v).html();
        });
        // Create instance of ajax
        var AjaxEngine  =   new nAjax($);
        // Set the translation domain
        if(typeof transDomain === "undefined")
            var transDomain  =   '/';
        // Fetch the translations remotely
        AjaxEngine.setUrl(transDomain).ajax({
            service: 'translation',
            keys: allKeys,
            lang: lang
        }, (response) => {
            var trans   =   response;
            // Create storage
            var storeNew    =   {};
            // Store keys that are not already generated
            $.each(allContents, function(k, v){
                try {
                    // See if there is an english or selected language key
                    let assemble    =   [
                        (typeof response[lang]['trans-cls'][k] === "undefined")? 1 : 0,
                        (typeof response.en['trans-cls'][k] === "undefined")? 1 : 0
                    ].join('');
                    // If there are neither key, create it
                    if(assemble == '11')
                        storeNew[k] =   v;
                }
                catch(Exception) {
                    console.log(Exception.message);
                }
            });
            // If there are translations, send them to generate new keys
            if(Object.keys(storeNew).length > 0) {
                AjaxEngine.setUrl(transDomain).ajax({
                    service: "translation",
                    subservice: "store",
                    generate: storeNew,
                    lang: lang
                }, function(r){
                });
            }
            if(typeof trans === "object") {
                var Trans  =   new Translator(lang);
                // Set the fetched translations
                Trans.setTransFile(trans);
                // Build a translator sentinel
                var TransObs  =   new TranslatorObserver(Trans);
                // Start the sentinel
                TransObs.sentinel();
            }
        });   
    }
}
$(function () {
	/**
	 *	@description	Starts the fancy fx sentinel and translates page
	 */
    setTimeout(() => {
        // Run visual fx
        (new FxEngine($('.fx'))).sentinel();
        // Translate the page
        translatePage();
    }, 1000);
	/**
	 *	@description	Displays the error blocks and allows for dismissal
	 */
    let errormsgs =   $('.dismiss-parent');
    $.each(errormsgs, function(k, v){
        if(!$(v).hasClass('stay')) {
            setTimeout(()=>{
                $(v).parents('.alert-dismissible').slideUp('fast');
            }, 10000);
        }
    });
    errormsgs.on('click', function(){
        $(this).parents('.alert-dismissible').slideUp('fast');
    });
	/**
	 *	@description	Changing of the language an country settings
	 */
    $('.locale-option').on('change', function(){
        let thisLocalOption =   $(this).attr('name');
        // Set the language
        CookieJar.set(thisLocalOption, $(this).val());
        let addr    =   new URL(document.location);
        let q   =   addr.searchParams;
        q   =   (q != '')? `?${q}` : '?';
        
        if(q.match(new RegExp(thisLocalOption + '=', 'gi'))) {
            q.replace(new RegExp(thisLocalOption + '=[^&]', 'gi'), `${thisLocalOption}=${$(this).val()}`);
        }
        else {
            q   +=  `&${thisLocalOption}=${$(this).val()}`;
        }
        
        window.location =   addr.pathname+q;
   });
});
