<table class="chat-table">
    <tr>
        <td>
            <section class="users">
              <header>
                <div class="content">
                  <?php 
                    $ent = new member;
                    if(!($row = $ent->fetch("id",app::memberUser()))) app::redirect("/sign-in");
                    
                  ?>
                  <img src="<?php echo @$row['img']; ?>" alt="">
                  <div class="details">
                    <span><?php echo $row['username']; ?></span>
                    <p><?php echo @$row['status']; ?></p>
                  </div>
                </div>        
              </header>
              <div class="chat-search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fas fa-search"></i></button>
              </div>
              <div class="users-list">

              </div>
            </section>            
        </td>
        <td>    
            <?php 
                  if($user_id = app::request("_other")) {
                    $ent = new member;
                    $row = $ent->fetch("id",$user_id);          
                ?>
            <section class="chat-area">
              <header>
                
                <!--<a href="#" class="back-icon"><i class="fas fa-arrow-left"></i></a>-->
                <img src="<?php echo @$row['profile_img']; ?>" alt="">
                <div class="details">
                  <span><?php echo $row['username']; ?></span>
                  <p><?php echo @$row['status']; ?></p>
                </div>
              </header>
              <div class="chat-box">

              </div>
              <progress style="display: none;width:100%"></progress>
              <form action="#" class="typing-area" enctype="multipart/form-data">
                <input type="hidden" id="_other" value="<?=app::request("_other")?>" hidden>
                <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <div class="btn-upload active"><input name="file" type="file"><i class="fa fa-cloud-upload"></i></div>
                <button><i class="fab fa-telegram-plane"></i></button>
              </form>
            </section>
                  <?php } ?>
        </td>
    </tr>
</table>    
  

  <?=app::asset("assets/themes/flix/users.js")?>  
  <?=app::asset("assets/themes/flix/chat.js")?>

<script>
    $(()=>{
        $('input[type=file]').on('input',upImg);
    });
    function upImg() {        
         $.ajax({
            // Your server script to process the upload
            url: '?_action=upload&_other=' + $('#_other').val(),
            type: 'POST',

            // Form data
            data: new FormData($('form')[0]),

            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,

            // Custom XMLHttpRequest
            xhr: function () {
              var myXhr = $.ajaxSettings.xhr();
              if (myXhr.upload) {
                // For handling the progress of the upload
                myXhr.upload.addEventListener('progress', function (e) {
                  if (e.lengthComputable) {
                    $('progress').attr({
                      value: e.loaded,
                      max: e.total,
                    }).show();
                  }
                }, false);
              }
              return myXhr;
            }
          });        
    }
</script>