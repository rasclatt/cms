<?php
if($this->isLoggedIn())
	return false;
# Create instance of tokening
$Token		=	$this->getHelper('nToken');
# Set the login token if it doesn't exist
if(!$Token->tokenExists('login'))
    $Token->setToken('login');
# See if 2 factor authentication is turned on
$twoFactor	=	$this->useAuth2();
# Create the auth token if on or remove if not
$method	=	($twoFactor)? 'setToken' : 'removeToken';
# Set or remove token
$Token->{$method}('two_factor_auth');
# Start login form
$Form	=	$this->getHelper('nForm');
echo $Form->open(['action'=>$this->getPage('full_path')]);
echo $Form->fullhide(['name' => 'token[login]', 'value' => '']);
echo $Form->fullhide(['name' => 'action', 'value' => (($twoFactor)? 'two_factor_auth' : 'login'), 'class'=>'nbr']);
?>
    <div class="login-container login-signup-modal">
        <div class="col-count-3 c1em-c1fr-c1em">
            <div class="start2 <?php echo ($this->getPage('is_admin') == 1)? 'admin' : 'frontend' ?>-login-container">
                <?php if($this->getPage('is_admin') != 1): ?>
                <div class="align-middle pad-bottom-1 dialogue-header">
                    <h3 class="uppercase">Sign In</h3>
                </div>
                <?php endif ?>
                
                <?php if(!empty($this->getDataNode('_SESSION')['code_validate'])): ?>
                <div class="span-2">
                    <div class="nbr_success">A code has been sent your email address on file. Put that code in below to finalize your login.</div>
                    <?php echo $Form->text(['name' => 'code_validate', 'placeholder' => 'Your code here', 'class'=>'nbr']) ?>
                </div>
                <?php else: ?>
                
                <div><?php echo $Form->text(['label' => 'Email Address', 'name' => 'username', 'value' => '', 'class'=>'nbr required', 'other' => ['required="required"']]) ?></div>
                
                <div><?php echo $Form->password(['label' => 'Password', 'name' => 'password', 'value' => '', 'class'=>'nbr required', 'other' => ['required="required"']]) ?></div>
                
                <?php endif ?>
                
                <div><?php echo $Form->submit(['name' => 'submit', 'value' => 'submit', 'class'=>'nbr button green token_button', 'disabled'=>'disabled', 'other'=> ['data-token="login"']]) ?></div>

                <?php if($this->signUpAllowed() && ($this->getPage('is_admin') != 1)): ?>
                
                <div class="align-center margin-top-1">
                    <a href="#" class="canceller nTrigger pointer" data-instructions='{"FX":{"fx":["slideUp","slideDown"],"acton":[".login-signup-modal",".signup-container"]}}'>Create Account</a>
                </div>

                <?php endif ?>
            </div>
        </div>         
    </div>
<?php echo $Form->close() ?>
