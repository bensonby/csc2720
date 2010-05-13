function index_signin_init(){
  $('index-sign-in').observe('click', function(){
    $('index-sign-in-box').toggle();
    return false;
  });

  $('index-sign-in').writeAttribute("href", "#");
}
