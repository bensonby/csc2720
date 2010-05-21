function signin_init(){
  var e = $('sign-in-box');
  if(e){
    $('sign-in-box').setStyle({display: 'none'});
    $('sign-in').observe('click', function(){
      $('sign-in-box').toggle();
      $('sign-in').toggleClassName('highlighted');
      return false;
    });

    $('sign-in').writeAttribute("href", "#");
  }
}

Event.observe(window, 'load', function(){
  signin_init();
});

function find_products(order_id){
  var e = $('ajax-popup');
  if(e){
    var e2 = $('ajax-order-id');
    e2.update(order_id);

    var e3 = $('ajax-loading');
    if(e3) e3.show();

    $('ajax-body').update();
    e.show();
    new Ajax.Updater('ajax-body', 'ajax_cart_products.php?id=' + order_id, { 
      method: 'get',
      onComplete: function(){ $('ajax-loading').hide()},
      onFailure: function(){ $('ajax-loading').hide()}
     });
  }else{
    alert('malformed page');
  }
}

function close_ajax(){
  var e = $('ajax-popup');
  if(e) e.hide();
}
