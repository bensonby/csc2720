function signin_init(){
  $('sign-in').observe('click', function(){
    $('sign-in-box').toggle();
    $('sign-in').toggleClassName('highlighted');
    return false;
  });

  $('sign-in').writeAttribute("href", "#");
}

Event.observe(window, 'load', function(){
  signin_init();
});
