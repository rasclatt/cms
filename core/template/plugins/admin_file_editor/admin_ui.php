<?php
$plugin_id = basename(__DIR__);
if($this->getGet('load') != $plugin_id)
    return false;
?>

<div class="pad-1">
    <h3>File Editing</h3>
    <p>For quick edits, use this system.</p>
    <div class="flexor"><?php echo $this->setPluginContent('btn_name', 'Root')->getPlugin($plugin_id, 'admin_ui_button.php') ?></div>
    <div id="file-window" class="pad-1 tinted-superlight"></div>
</div>

<style>
    .filenav {
        width: 100%;
    }
    .filenav td {
        padding: 0.35em;
        border-bottom: 1px solid #CCC;
        white-space: nowrap;
    }
    .filenav tr:hover td {
        background-color: #EBEBEB;
    }
    .filenav td:first-child {
        width: 100%;
    }
    .filenav td:not(:first-child) {
        text-align: right;
    }
    .type-folder  {
        color: rgba(99,165,200,1.00);
    }
    .filenav td:not(:first-child) {
        font-size: 0.8em !important;
    }
</style>

<script>
    function fetchItem(arr)
    {
        AjaxEngine.ajax(arr, function(response){
            let data    =   response;
            
            if(typeof data.msg !== "undefined") {
                alert(data.msg);
                $('#file-window').find('textarea[name="file_edit"]').replaceWith('');
                return false;
            }
            
            var arr =   [
                '<table class="filenav" cellpadding="0" cellspacing="0" border="0">'
            ];
            var back    =   false;
            var isFile  =   false;
            if(typeof data[0] !== "undefined") {
                $.each(data, function(k, v) {
                    
                    if(!back)
                        back    =   v.path.replace(new RegExp('/' + v.full_name, 'gi'), '');
                    
                    arr.push(
                        '<tr class="type-' + v.type + ' gapped pointer" data-path="' + v.path + '" data-kind="' + v.type + '" data-created="' + v.created + '" data-modified="' + v.modified + '">' +
                            '<td class="pointer"><i class="fa' + ((v.type == 'folder')? 's' : 'r') + ' fa-' + v.type + '"></i>&nbsp;&nbsp;' + v.full_name + '</td>' +
                            '<td class="pointer">' + v.created + '</td>' +
                            '<td class="pointer">' + v.modified + '</td>' +
                            '<td class="pointer">' + ((v.type == 'file')? v.size : v.size + '&nbsp;<i class="far fa-copy"></i>') + '</td>' +
                        '</tr>');
                });
            }
            else {
                if(!back)
                    back    =   (typeof data.path !== "undefined")? data.path.replace(new RegExp('/' + data.full_name, 'gi'), '') : '';
                
                isFile  =   true;
                arr.push(data.contents);
            }
            arr.push('</table>');
            
            let backbutton  =   '';
            
            if(data.type != 'folder'){
                if(typeof data.full_name !== "undefined") {
                    backbutton  =   `<div style="display: inline-flex;"><p class="margin-right-1"><input class="nbr" type="text" name="file_name" value="${data.full_name}" /></p><div class="align-middle"><a href="#" class="nbr small update-file">SAVE</a></div><?php echo $this->setPluginContent('check_id', 'check-delete-file')->setPluginContent('check_name', 'file_delete')->getPlugin('widget_html', 'delete_checkbox.php') ?>
                    </div>`;
                }
            }
            
            if(back) {
                if(!back.match(/vhosts$/gi) || isFile){
                    let goback = (!isFile)? `${back}/../` : back;
                    backbutton  +=   `<div class="margin-bottom-half"><div class="type-folder backbutton pointer" id="back-path" data-kind="folder" data-path="${goback}" ><i class="fas fa-step-backward"></i></div></div>`;
                }
            }
            
            $('#file-window').html(backbutton + arr.join(''));
        });
    }
    
    
    $(function(){
        fetchItem({
            "action": "system_navigation",
            "path": "<?php echo NBR_ROOT_DIR ?>"
        });
        
        $('#file-window').on('click', '.type-folder,.type-file', function(){
            var arr =   {};
            $.each($(this).data(), function(k, v){
                arr[k]  =   v;
            });
            arr.action   =   "system_navigation";
            arr.subaction   =   "view";
            
            fetchItem(arr);
        });
        
        $('#file-window').on('click', 'input[name="file_delete"]', function(e){
            if($('input[name="file_delete"]').is(':checked')) {
                let conf =   confirm('Are you sure you want to delete this item?');
                if(!conf)
                    e.preventDefault();
            }
        });
        
        $('body').on('click', '.update-file', function(){
            fetchItem({
                action: "system_navigation",
                subaction: "update",
                data: $('textarea[name="file_edit"]').val(),
                delete: ($('input[name="file_delete"]').is(':checked'))? 'on' : '',
                path: $('textarea[name="file_edit"]').data('path'),
                fname: $('input[name="file_name"]').val()
            });
        });
    });
</script>

<?php 
$this->getHelper('DataNode')->addNode('admin_stop', true);