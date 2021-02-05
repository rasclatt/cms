<?php 
use \Nubersoft\ {
    JWTFactory as JWT,
    JWT\Controller
};

if(!Controller::getJwtTokenSecret())
    return false
?><script>
var csrf    =   "<?php echo JWT::get()->create([
    'csrf' => md5(time()),
    'userId' => $this->userGet('ID')
]) ?>";
</script>