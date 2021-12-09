<?php
use \Nubersoft\{
    Currency,
    nToken,
    nForm as Form
};

if ($this->isLoggedIn())
    return false;
elseif ($this->getPage()->is_admin == 1)
    return false;
elseif (!$this->signUpAllowed())
    return false;

$Token = new nToken;
$locale = strtoupper((!empty($this->getSession('locale'))) ? $this->getSession('locale') : 'us');
if (!$Token->tokenExists('sign_up'))
    $Token->setToken('sign_up');
$Form = new Form;
echo $Form->open(['action' => $this->getPage()->full_path]);
echo $Form->fullhide(['name' => 'token[login]', 'value' => '']);
echo $Form->fullhide(['name' => 'action', 'value' => 'sign_up', 'class' => 'nbr']);
?>
<div class="signup-container pad-1 login-signup-modal" style="display: none;">
    <div class="align-middle dialogue-header">
        <h3 class="uppercase">Create Account</h3>
        <div class="align-center margin-top-1">
            <a href="#" class="canceller nTrigger pointer" data-instructions='{"FX":{"fx":["slideUp","slideDown"],"acton":[".login-signup-modal",".login-container"]}}'>Already have an account? Login.</a>
        </div>
    </div>
    <div><?php echo $Form->text(['label' => 'Email Address', 'name' => 'username', 'value' => $this->getPost('username'), 'class' => 'nbr required', 'other' => ['required="required"']]) ?></div>
    <div><?php echo $Form->password(['label' => 'Password', 'name' => 'password', 'value' => $this->getPost('password'), 'class' => 'nbr required', 'other' => ['required="required"']]) ?></div>
    <div><?php echo $Form->text(['label' => 'First Name', 'name' => 'first_name', 'value' => $this->getPost('first_name'), 'placeholder' => 'First name', 'class' => 'nbr required', 'other' => ['required="required"']]) ?></div>
    <div><?php echo $Form->text(['label' => 'Last Name', 'name' => 'last_name', 'value' => $this->getPost('last_name'), 'placeholder' => 'Last name', 'class' => 'nbr required', 'other' => ['required="required"']]) ?></div>

    <div><?php echo $Form->select(['label' => 'Country', 'name' => 'country', 'options' => array_map(function ($v) use ($locale) {
                return [
                    'name' => $v['title'],
                    'value' => $v['abbr2'],
                    'selected' => ($locale == $v['abbr2'])
                ];
            }, (new Currency())->getLocaleList()), 'class' => 'nbr required', 'other' => ['required="required"']]) ?></div>

    <div><?php echo $Form->submit(['name' => 'sign_up', 'value' => 'Create Account', 'class' => 'nbr button green token_button', 'disabled' => 'disabled', 'other' => ['data-token="login"']]) ?></div>
</div>
<?php echo $Form->close() ?>