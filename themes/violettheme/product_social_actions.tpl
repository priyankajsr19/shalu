<div id="fb-root"></div>
{literal}
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
{/literal}