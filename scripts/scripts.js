function signin_init(){
  var e = $('sign-in-box');
  if(e){
    $('sign-in-box').setStyle({display: 'none'});
    $('sign-in').observe('mouseover', showLogin);
    $('logo').observe('click', hideLogin);
    $('content').observe('click', hideLogin);
    var e2 = $('message-box');
    if(e2) $('message-box').observe('click', hideLogin);
    $('sign-in').writeAttribute("href", "#");
  }
}

function showLogin(){
  $('sign-in-box').show();
  $('sign-in').addClassName('highlighted');
  $('username_field').focus();
}

function hideLogin(){
      $('sign-in-box').hide();
      $('sign-in').removeClassName('highlighted');
}


Event.observe(window, 'load', function(){
  signin_init();
});

function find_cart(cart_id){
  request_cart("cus_product_id", cart_id);
}

function find_products(order_id){
  request_cart("order_id", order_id);
}

function request_cart(key, value){
  if(key!="cus_product_id" && key!="order_id") return false;
  var e = $('ajax-popup');
  if(e){
    var e2 = $('ajax-id');
    e2.update(value);

    var e3 = $('ajax-loading');
    if(e3) e3.show();

    $('ajax-body').update();
    set_position(e);
    e.show();
    new Ajax.Updater('ajax-body', 'ajax_cart_products.php?' + key + '=' + value, { 
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

function set_position(el){
  var positions = document.viewport.getScrollOffsets();
  var y = positions[1] + 20;
  el.setStyle({top: y + 'px'});
}
