$(function () {
    // Create a contextual menu
    var RightClick  =   new ContextMenus();
    RightClick.addElements({
        toggleEdit: [
            '<a href="?action=set_edit_mode&active=on" class="white">TOGGLE EDIT MODE</a>',
            'button'
        ],
        clearCache: [
            '<a href="?action=clear_cache" class="white">CLEAR CACHE</a>',
            'button'
        ],
        toggleMast: [
            `<a class="canceller nTrigger" data-instructions='{"FX":{"fx":["fadeToggle"],"acton":["header.header-area"],"fxspeed":["fast"]}}' href="#" class="white">TOGGLE MAST</a>`,
            'button'
        ],
        adminToggle: [
            `<a class="canceller nTrigger" data-instructions='{"FX":{"fx":["fadeToggle"],"acton":["#admin-menubar"],"fxspeed":["fast"]}}' href="#" class="white">TOGGLE ADMIN BAR</a>`,
            'button'
        ]
    });
    // Listen for clicks on the component in render mode
    RightClick.addEvent('editComponent', (e, ContextMenusObj) => {
        
        var editBtn =   $(e.target).parents('.csm-tool-item').find('.edit-btn-tools');
        
        if($('.component-add-new').length == 0 && editBtn.length == 0)
            return false;
        
        let counter =   [
            $(e.target).parents('.csm-tool-item').length,
            $(e.target).parents('#admintools').length,
            $(e.target).hasClass('component-library-container')? 1 : 0
        ];
        
        if(counter.reduce((total, i) => {
            return total + i;
        }) == 0)
            return false;
        
        var bts =   '';
        
        if(editBtn.length > 0) {
            ContextMenusObj.addButton('editComponent', function() {
                return editBtn[0].outerHTML.replace('edit-btn-tools hide', 'white fx opacity-hover').replace('EDIT', '<a href="#" class="canceller">EDIT COMPONENT</a>')
            });
            btns    =   ContextMenusObj.assemble('button');
        }
        else {
            ContextMenusObj.addButton('addComp', `${$('.component-add-new').html().replace('<i class="far fa-file pointer"></i>','ADD NEW COMPONENT').replace('background-color: #333; font-size: 1rem; color: #FFF; border: none; border-radius: 3px; min-width: 2rem; margin: 0; border: 1px solid #666; padding: 0.2rem','')}`);
            
            btns    =   ContextMenusObj.assemble('button', 'default', ['toggleMast', 'toggleEdit']);
        }
        
        let pos =   ContextMenus.getMousePosition(e);
        $('#loadspot-modal').html(ContextMenus.toMenu(btns, `left: ${pos.x}px; top: ${pos.y}px;`));

        $('#loadspot-modal').on('click', '.load-spinner', ()=>{
            loadSpinner();
        });
        
        $('.draggable').draggable({
            cancel: ".nodrag"
        });
        return true;
    });
    
    
    window.oncontextmenu = function(e)
    {
        var exit    =   RightClick.sentinel(e);
        $('#loadspot-modal').addClass('active-contextual');
        if(exit)
            return false;
        
    }
    // Start fx
    setTimeout(function(){
        // Run visual fx
        (new FxEngine($('.fx'))).sentinel();
    }, 2000);
    
    if(typeof contextSettings === "undefined") {
        var contextSettings =   {
            translationAdmin: "/admintools/translator/"
        };
    }
    
    $('body').on('click', '.trans-cls', function(e){
        if($(this).parents('.csm-tool-item').length != 0) {
            e.preventDefault();
            let language    =   CookieJar.get('language');
            let lang    =   (language)? language.toLowerCase() : 'en';
            let isEng    =   (lang == 'en' || lang == '');
            let pos =   ContextMenus.getMousePosition(e);
            let btns    =   [
                `<a class="white nodrag" href="${contextSettings.translationAdmin}?subaction=&load=&max=10&table=&search=${$(this).data('trans')}" target="_blank">${$(this).data('trans')}</a>`,
                !isEng? `<span class="nodrag white saver${$(this).data('trans')}us${lang}"></span><form class="nodrag quicktranslator"><input type="hidden" name="action" value="create_translator" /><input type="hidden" name="transkey" value="${$(this).data('trans')}" /><textarea name="description" class="nbr translator-replace">${$(this).html()}</textarea><button class="btn-mini">SAVE</button></form>` : '',
                
                (typeof $(this).attr('href') !== "undefined")? `<a class="uppercase" href="${$(this).attr('href')}">Go To Link</a>` : ''
            ];
            $('#loadspot-modal').html(ContextMenus.toMenu(btns, `background-color: rgba(58,87,99,1.00); left: ${pos.x}px; top: ${pos.y}px;`));
            
        
            $('.draggable').draggable({
                cancel: ".nodrag"
            });
        }
    });
    
    $('body').on('keyup', '.translator-replace', function(e){
        let thisVal =   $(this).val();
        let trans   =   $(this).prev().val();
        $('*[data-trans="'+trans+'"]').html(thisVal);
    });
    
    $(document).on('submit', '.quicktranslator', function(e){
        e.preventDefault();
        $(this).append(`<input type="hidden" name="jwtToken" value="${csrf}">`);
        
        AjaxEngine.ajax($(this).serialize(), (r)=>{
            default_action($(this), r);
        });
    });
    
    $('#loadspot-modal').on('click', '.close-contextual', function(){
        $('#loadspot-modal').removeClass('active-contextual');
    });
});
