<?php
use \Nubersoft\nForm as Form;
use \NubersoftCms\ContentPolicyManager\Model as Manager;

$plugin_id = 'admin_securitypolicy_editor';
$plugin_action = 'internal_editsecuritypolicy';

$Manager = new Manager();
$def = $Manager->def;
$defPolicyKey = [
    'ref_anchor' => 'content_security_policy'
];
if($this->getPost('action') == $plugin_action) {
    $args = $this->getPost('attr');
    $Manager->create((!empty($args))? $args : [], $this->getPost('page_live') == 'on');
}
$defPolicy = $Manager->get();

if($defPolicy->policies) {
    $def = $defPolicy->policies;
}
?>
<div class="pad-1">
    <h3>Edit Site Security Policy</h3>
    <p>Create/edit your sites security policy. Note that <code>frame-ancestors</code> must be set on the server. </p>
    <div id="security-tools" class="flexor mt-5">
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="default-src">+ Default</button>
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="frame-src">+ Frame</button>
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="img-src">+ Image</button>
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="script-src">+ Script</button>
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="font-src">+ Font</button>
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="style-src">+ Style</button>
        <button class="add-new-policy btn btn-secondary btn-sm" data-policytype="custom">+ Custom</button>
    </div>
    <?php echo Form::getOpen([ 'action' => '?load='.$plugin_id, 'id' => 'security-policy', 'enctype' => 'multipart/form-data' ]) ?>
        <?php echo Form::getFullhide([ 'name' => 'action', 'value' => $plugin_action ]) ?>
        <div id="policies-container">
            
        </div>
        <div>
            <?php echo Form::getSelect([ 'label' => 'Live', 'name' => 'page_live', 'options' => [
                [
                    'name' => 'Off',
                    'value' => 'off',
                    'selected' => !$defPolicy->active
                ],
                [
                    'name' => 'On',
                    'value' => 'on',
                    'selected' => $defPolicy->active
                ]
            ], 'class' => 'nbr' ]) ?>
        </div>
        <div class="align-middle mt-3">
            <?php echo Form::getSubmit([ 'name' => '', 'value' => 'SAVE', 'class' => 'nbr' ]) ?>
        </div>
    <?php echo Form::getClose() ?>

</div>

<script>
    const myPolicy = <?php echo (is_string($def))? $def : json_encode($def) ?>;

    function toPolicyInput(contentType, value)
    {
        if(typeof value === "undefined")
            value   =   '';

        return `
        <div class="policy col-count- gapped" style="grid-template: 1fr / auto 1fr auto;">
            <div class="type-placeholder align-middle"><input type="text" class="nbr input-policy" name="attr[policy][]" value="${contentType}" placeholder="" ${contentType != 'custom'? 'readonly' : ''} /></div>
            <div>
                <input type="text" class="nbr input-type" name="attr[type][]" value="${value}" placeholder="" />
            </div>
            <div>
                <i class="fas fa-minus-circle" role="button" title="Delete this policy"></i>
            </div>
        </div>
        `
    }
    
    function rebuildContent(policyContainer)
    {
        var sorted = {};
        var children = policyContainer.find('.policy');
        
        let rebuild = new Promise((success, fail) => {
            children.map(v => {

                let section = $(children[v]).find('.input-policy').val();
                let thisVal = $(children[v]).find('.input-type').val();

                if(typeof sorted[section] === "undefined")
                    sorted[section] =   [];

                sorted[section].push(toPolicyInput(section, thisVal));
            });



            success(sorted);

        });

        rebuild.then((success, fail) => {
            let layout = '';
            $.each(success, (k, v) => {
                layout += `<div><h6 class="margin-top-1"><strong class="uppercase">${k.replace(/-src/i, '')}</strong></h6>
                <div class="sortable-groupage">
                ${v.join("\r\n")}</div></div>`
            });
            policyContainer.html(layout);
            policyContainer.find('.sortable-groupage').sortable();
        });
    }
    $(function() {
        let policyContainer = $('#policies-container');
        $.each(myPolicy, (k, v) => {
            $.each(v, (sk, sv) => {
                policyContainer.append(toPolicyInput(k, sv));
            });
        });
        
        rebuildContent(policyContainer);

        $('.add-new-policy').on('click', function(){
            let thisObj = $(this);
            let contentType = thisObj.data('policytype');
            policyContainer.append(toPolicyInput(contentType, ''));
            rebuildContent(policyContainer);
        });

        policyContainer.find('.sortable-groupage').sortable();
        policyContainer.on('click', '.fa-minus-circle', function(){
            $(this).parents('.policy').replaceWith('');
            rebuildContent(policyContainer);
        });
    });
</script>

<style>
    input[readonly] {
        border: none !important;
        width: 0 !important;
        padding: 0 !important;
        min-width: initial !important;
    }
    #policies-container input {
        font-family: 'Courier New', Courier, monospace !important;
    }
</style>

<?php
$this->getHelper('DataNode')->addNode('admin_stop', true);