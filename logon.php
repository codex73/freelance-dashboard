<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Freelance Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">


      body {
        margin-top: 30px;
        padding-bottom: 40px;
      }      
      
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

  </head>
<body>
  	<div class="container">
  		<div class="row">
  			<div class="offset2 span8">
  				<form class="form-horizontal" id="authen">
				  <fieldset>
				    <legend>Logon</legend>
				    <div class="control-group">
				      <label class="control-label" for="input01">Username/Email</label>
				      <div class="controls">
				        <input name="username" type="text" class="input-xlarge" id="input01">
				      </div>
				    </div>
				    <div class="control-group">
				      <label class="control-label" for="input02">Password</label>
				      <div class="controls">
				        <input name="password" type="password" class="input-xlarge" id="input02">				        
				      </div>
				    </div>
				    <div class="form-actions">
			            <button type="submit" class="btn btn-primary">Login</button>
			          </div>
				  </fieldset>
				</form>
  			</div>  			
  		</div>
  	</div>
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery-1.7.1.min.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/jquery.fittext.js"></script>

<script type="text/javascript">
$(function () {
	$("#authen").submit(function(){
		var form_data = $(this).serialize();

    var input01 = $(this).find('#input01').val();
    var input02 = $(this).find('#input02').val();

    if(input01.length==0){
      $("#input01").closest('.control-group').addClass('error');
    }else if(input02.length==0){
      $("#input02").closest('.control-group').addClass('error');
    }else{
      $.ajax({
          type:'post',
          url: 'auth.php',
          dataType: "json",
          data: form_data,
          success: function(data){
            var username = data[0], password = data[1], access = data[2], uid = data[3];
            if(access==false){$(".control-group").addClass('error');}else{
              window.location = "multido.php?uid="+uid;
            }
            console.log(data);
          }
        });
    }
    return false;	
	});
});
</script>
</body>
</html>