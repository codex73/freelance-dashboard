<?php
/**
 * @package Freelance Dashboard
 * @version 1
 * @author Francis Suarez [@codex73]
 */
session_start();
if(!$_SESSION['logon']==true){
  header("Location: logon.php");
}

//Add your database settings here
mysql_connect('localhost','localuser','userlocal');
mysql_select_db('multido') or die(mysql_error());

//UserID
$uid = isset($_GET['uid'])? $_GET['uid'] : '';
//BoardID
$prj = isset($_GET['prj'])? $_GET['prj'] : '';

//Board Name
$thequery = mysql_query("select bname from boards where bid = '".$prj."';");
$thequery_rst = @mysql_result($thequery,0);
$_SESSION['bname'] = (empty($thequery_rst) ? 'undefined' : $thequery_rst);

//Displays Big Number Count - Tasks on Board Still Active
function board_health($prj,$status=1){
  $query = "select box.rname,count(box_cont.cid) from box join box_cont on box.id = box_cont.fkid and box.fbid = '".$prj."' and box_cont.status = '".$status."' group by box.id;";
  $result = mysql_query($query);
  $the_count = null;
  while($row = mysql_fetch_array($result)){
    $the_count = $the_count + $row[1];
  }
  if($the_count==0){$the_count = 0;}
  return $the_count;
}

//Fetches Boards Names & ID's for Menu
function fetch_boards(){
  $query = "select * from boards"; 
  $result = mysql_query($query);
  while($row = mysql_fetch_assoc($result)){
    echo '<a href="?uid=1&prj='.$row['bid'].'">'.$row['bname'].'</a><br/>';
  }
}

function out_boxes($uid,$prj){
  $query = "select * from box,box_perm,boards where box_perm.fkuid = '".$uid."' and box.fbid = '".$prj."' ";
  $query .= "and box.id = box_perm.fkbox group by id;";
  $result = mysql_query($query);
  $opened_todos_counter = 0; 

  while($row = mysql_fetch_assoc($result)){

    $query3 = "select status from box_cont where fkid = '".$row['id']."' and status='1';";
    $result3 = mysql_query($query3);
    $opened_todos = mysql_num_rows($result3);
    if($opened_todos==0){$color = 'style="color: #ccc;"';}else{$color = '';}

    //Find Box Containers
    $rname = $row['rname'];
    $id = $row['id']; 

    $html = <<<YIU
      <table class="table table-bordered span3" $color>
            <thead>
              <tr>
                <th id="bid_$id">$rname</th>           
              </tr>
            </thead>
            <tbody>
YIU;

    echo $html;

    //Find Tasks for Each
    
    $query2 = "select * from box_cont where fkid = '".$id."';";
    $result2 = mysql_query($query2);

    if(mysql_num_rows($result2)>0){

      while($row = mysql_fetch_assoc($result2)){
        $cname = $row['cname'];
        $cid = $row['cid'];
        $status = $row['status']; 

        if($status==1){
          $cont = '<!--<i class="icon-eye-open"></i>-->'.$cname;
        }else{
          $cont = '<del style="color: #ccc"> '.$cname.'</del>';
        }

        $html = <<<YIU
        <tr>
                  <td class="box_cont tk" id="cid_$cid">$cont</td>
                </tr>
YIU;

        echo $html;
      }

    }else{

      $html = <<<YIU
        <tr>
                  <td class="box_cont_empty">-no entry exists-</td>
                </tr>
YIU;

      echo $html;

    }
    

$end_table = <<<OOO
<tr class="end_table">
<td>
<i class="icon-plus" style="cursor: pointer;opacity: 0.3;margin: 5px;"></i>
<i class="icon-trash rem_box" style="cursor: pointer;opacity: 0.3;margin: 5px;"></i>
</td>
</tr>
</tbody>
</table>
OOO;
    echo $end_table;
  }
}
?>
<!DOCTYPE html>
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
        margin-top: 10px;
        padding-bottom: 40px;
      }

      .box_cont{cursor: pointer;}

      h1.bigger{
      text-align: center;
      color:#ccc;
      font: 95px/1 "Impact";
      text-transform: uppercase;
      display: block;
      margin: 5% auto 5%;
    }

    .topper {
      padding: 10px;
      margin-bottom: 20px;
      background-color: #eeeeee;
      -webkit-border-radius: 6px;
      -moz-border-radius: 6px;
      border-radius: 6px;
    }

    .topper h1 {
      margin-bottom: 0;
      font-size: 60px;
      line-height: 1;
      color: #ccc;
      letter-spacing: -1px;      
    }

    #overlay{
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #000;
      filter:alpha(opacity=50);
      -moz-opacity:0.5;
      -khtml-opacity: 0.5;
      opacity: 0.5;
      z-index: 10000;
      text-align: center;
      display: none;
    }

    #formed{
      /* for IE */
      filter:alpha(opacity=100);
      /* CSS3 standard */
      opacity:1;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      background-color: white;
      width:280px;
      height:100px;
      position: absolute;
      left:50%;
      top:50%;
      margin:-100px 0 0 -150px;
      padding: 10px;
      z-index: 12000;
      border: 2px solid #eee;
      display: none;
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
  
    <br/>
    <div class="container-fluid">
        <div class="row">          
          <div class="span12">            
            <h1>Freelance Dashboard</h1>
            
          </div>
        </div>
        <div class="row-fluid">
          <div class="span2">
            <h1 class="bigger"><?= board_health($prj); ?></h1>
            <hr>
            <!-- Add links to the boards here -->
            <?php fetch_boards(); ?>
            <hr>
            <a href="#" id="trigger_add" class="btn btn-mini" style="margin-bottom:3px;">Add Box</a><br/>
            <a href="#" id="trigger_add_box" class="btn btn-mini" style="margin-bottom:3px;">Add Board</a><br/>
            <!--buttons Not in use yet -->
            <a href="?uid=1&prj=3" class="btn btn-mini" style="margin-bottom:3px;">Share this board</a><br/>
            <a href="?uid=1&prj=3" class="btn btn-mini" style="margin-bottom:3px;">Permissions</a><br/>
            <a href="auth.php?logoff=true" class="btn btn-mini" style="margin-bottom:3px;">Log Off</a><br/>
          </div>        
          <div class="span10" id="board_content">
            <br/>
            <h3 style="margin-left: 20px;"><?php echo $_SESSION['bname']; ?></h3>
            <br/>
            <?php out_boxes($uid,$prj); ?>
          </div>          
        </div>      
    </div> <!-- /container -->

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
$(function(){
  var prj = "<?php echo $prj;?>", uid = "<?php echo $uid;?>";

  var overlay_txt =
  '<div id="overlay"></div><div id="formed">'+
  '<h2>Give the box a name</h2>'+
  '<input type="text" name="new_box" style="width:80%" style="float: right;"> '+
  '<button class="btn add_con" style="float: right;">Save</button></div>';

  var overlay_txt2 =
  '<div id="overlay"></div><div id="formed">'+
  '<h2>Give the board a name</h2>'+
  '<input type="text" name="new_board" style="width:80%" style="float: right;"> '+
  '<button class="btn add_con" style="float: right;">Save</button></div>';  

  //Add Box
  $("#trigger_add").on('click',function(event){
    $(overlay_txt).appendTo(document.body);
    $("#overlay,#formed").show();
    event.preventDefault();
  });

  $("body").on('click','#overlay',function(){
    $("#overlay,#formed").hide();
  });

  //Add Board
  $("#trigger_add_box").on('click',function(event){
    $(overlay_txt2).appendTo(document.body);
    $("#overlay,#formed").show();
    event.preventDefault();
  });

  $("body").on('click','#overlay',function(){
    $("#overlay,#formed").hide();
  });

  //Adds New Box To Board
  $("body").on('click','.add_con',function(){
    var new_entry = $(this).prev().val(),action = 'new_asset',
        typerec = $(this).prev().attr('name');

    $.ajax({
          type:'post',
          url: 'posts_in.php',
          dataType: "json",
          data: { action: action, content: new_entry, prj: prj, uid: uid, typerec: typerec},
          success: function(data){
              var action = data[0],cid= data[1], content = data[2];
              var box_frame = 
                '<table class="table table-bordered span3">'+
                  '<thead>'+
                    '<tr>'+
                      '<th id="bid_'+cid+'">'+content+'</th>'+
                    '</tr>'+
                  '</thead>'+
                '<tbody>'+
                '<tr>'+
                      '<td class="box_cont_empty"><span>-no entry exists</span></td>'+
                    '</tr>'+
              '<tr class="end_table">'+
                '<td>'+
                '<i class="icon-plus" style="cursor: pointer;opacity: 0.3;margin: 5px;"></i>'+
                '<i class="icon-trash rem_box" style="cursor: pointer;opacity: 0.3;margin: 5px;"></i>'+
                '</td>'+
                '</tr>'+
                '</tbody>'+
              '</table>';
              if(typerec=='new_box'){
                $("#board_content").append(box_frame);  
              }              
          }
      });

    $("#overlay,#formed").hide();
  });

  //Sidebar Big Fonts
  $("h1.bigger").fitText({ minFontSize: 50, maxFontSize: '75px' });       
  $("#counter_total_items").fitText({ minFontSize: 20, maxFontSize: '40px' });

  //Add New Task
  $("body").on('click','.icon-plus',function(event){
    $(this).parents('table').find('tbody').find('.box_cont_empty').remove();
    $(this).parents('table').find('tbody').find('.end_table')
    .before('<tr><td class="box_cont"><input type="text" style="width:80%"> <i class="icon-facetime-video save_entry"></i></td></tr>');
  });

  //Save New Task
  $("body").on('click','.save_entry',function(event){
    var new_entry = $(this).prev().val(),
        thebid = $(this).parents('tbody').prev().find('th').attr('id').split('_')[1],
        therow = $(this).parent();
    $(this).parents('table').css('color','');
    $(this).parent().addClass('tk').html(new_entry);
    update_entry('new_tk',new_entry,thebid, function(cid){
      $(therow).attr('id','cid_'+cid);
    });    
  });

  function update_entry(typeofupdate,new_entry,thebid,callback){
    switch(typeofupdate){
      case 'new_tk': var action = 'new_tk';
      break;}

    $.ajax({
          type:'post',
          url: 'posts_in.php',
          dataType: "json",
          data: {cid : thebid, action: action, content: new_entry},
          success: function(data){
              var action = data[0],cid= data[1];
              callback( cid );
          }
      });
  }

  //Hover Tasks
  $("body .tk").hover(function(){    
    $(this).append('<i class="icon-trash del_tsk" style="cursor: pointer;opacity: 0.3;float:right;"></i>');
  },function(){
    $(this).find('i').remove();
  });

  //Remove Task
  $("body").on('click','.del_tsk',function(){
    var cid = $(this).closest('td').attr('id').split('_')[1];
    $.ajax({
          type:'post',
          url: 'posts_in.php',
          dataType: "json",
          data: {cid : cid, action: 'rem_tsk'},
          success: function(data){
              var action = data[0],cid= data[1];
              $('#cid_'+cid).remove();
          }
    });    
  });

  //Remove Box
  $("body").on('click','.rem_box',function(){


    var bid = $(this).parents('tbody').prev().find('th').attr('id').split('_')[1];

    $.ajax({
          type:'post',
          url: 'posts_in.php',
          dataType: "json",
          data: {bid : bid, action: 'rem_box'},
          success: function(data){
              var action = data[0],bid= data[3];
              $('#bid_'+bid).closest('table').remove();
          }
    });    
  });

  //Change Task Status
  $("body").on('click','.tk',function(event){
      var parentguy = $(this).closest('tbody'),
          i = $(this).find('del'),//Check if status off
          t = $(this).hasClass('box_cont_empty'), //Check if empty
          n_box_count = $(this).closest('tbody').children('tr').not('.end_table').length;

      if(!i.length){
        $(this).wrapInner('<del>').css('color','#ccc');
        var altstatus = 0;
      }else if(t==false){
        var thevalue = $(this).find('del').text();
        //console.log(thevalue);
        $(this).css('color','').html(thevalue);
        var altstatus = 1;
      }

      var tun = $(this).closest('tbody').find('del').length;

      if(tun==n_box_count){
        $(this).closest('table').css('color','#ccc');
      }else{
        $(this).closest('table').css('color','');}

      var cid = $(this).attr('id').split('_')[1];

      $.ajax({
          type:'post',
          url: 'posts_in.php',
          dataType: "json",
          data: {cid : cid, action: 'status_up', altstatus: altstatus},
          success: function(data){
              var action = data[0],cid= data[1];
              //console.dir(data);
          }
      });

  });

});
</script>

  </body>
</html>
