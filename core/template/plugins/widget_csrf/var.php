<?php 
use \Nubersoft\ {
    JWTFactory as JWT,
    JWT\Controller
};
# Create a jwttoken if not already done
if(!Controller::getJwtTokenSecret()) {
    file_put_contents(NBR_CLIENT_DIR.DS.'settings'.DS.'.jwttoken', md5(rand()));
}
?><script>
var csrf    =   "<?php echo JWT::get()->create([
    'csrf' => md5(time()),
    'userId' => $this->userGet('ID')
]) ?>";
</script>
