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
