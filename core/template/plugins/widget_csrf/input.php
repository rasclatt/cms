<?php 
use \Nubersoft\ {
    JWTFactory as JWT,
    JWT\Controller
};

if(!Controller::getJwtTokenSecret())
    return false
?><input type="hidden" name="jwtToken" class="jwtToken" value="<?php echo JWT::get()->create([
    'csrf' => md5(time()),
    'userId' => $this->userGet('ID')
]) ?>" />