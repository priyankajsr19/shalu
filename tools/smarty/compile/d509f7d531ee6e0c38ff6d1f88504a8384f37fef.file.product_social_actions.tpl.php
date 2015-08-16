<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 19:49:36
         compiled from "/var/www/html/indusdiva/themes/violettheme/./product_social_actions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:193452224455b39af8e867c1-16864852%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd509f7d531ee6e0c38ff6d1f88504a8384f37fef' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/./product_social_actions.tpl',
      1 => 1436950700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193452224455b39af8e867c1-16864852',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="fb-root"></div>

<script>
    function plusClick(response ) {
        var datastring;
        if( response.state == "on")
            datastring = 'ajax=true&plus_click=1&pid=' + id_product;
        else
            datastring = 'ajax=true&plus_click=2&pid=' + id_product;
        $.ajax({
            type: 'POST',
            url: baseDir + 'feedback.php',
            data: datastring,
            dataType: 'json',
            success: function(result){
                if(result.feedback_status === 'succeeded') {}
            }
        });
    }
  window.fbAsyncInit = function() {
    FB.init({
      appId  : '285166361588635',
      xfbml  : true,
      oauth : true
    });
    FB.Event.subscribe('edge.create',function(response) {
        var datastring = 'ajax=true&fb_like=1&pid=' + id_product;
        $.ajax({
            type: 'POST',
            url: baseDir + 'feedback.php',
            data: datastring,
            dataType: 'json',
            success: function(result){
                if(result.feedback_status === 'succeeded') {}
            }
        });
    });
    FB.Event.subscribe('edge.remove',function(response) {
        var datastring = 'ajax=true&fb_like=2&pid=' + id_product;
        $.ajax({
            type: 'POST',
            url: baseDir + 'feedback.php',
            data: datastring,
            dataType: 'json',
            success: function(result){
                if(result.feedback_status === 'succeeded'){}
            }
        });
    });
  };
 
  (function(d){
    var js, id = 'facebook-jssdk'; 
    if (d.getElementById(id)) {
      return; // already loaded, no need to load again
    }
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
  }(document));

</script>
