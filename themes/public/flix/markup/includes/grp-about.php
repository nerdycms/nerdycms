<?php 
    $ent = new member;
    $data = $ent->fetch("id",app::memberUser());
?>
    <div class="profile-info col-md-9">          
        
          <div class="panel">
              <div class="bio-graph-heading">
                  About me
              </div>              
              <div class="panel-body bio-graph-info">
                  <h1>Profile image</h1>
                  <div class="row">
                      <div class="col-md-12">
                          <form action="/file-upload"
                            class="dropzone"
                            id="my-awesome-dropzone"></form>
                      </div>
                  </div>
                  <br>
                  <form method="POST">        
                      <input type="hidden" value="about-save" name="_action">
                  <h1>About me</h1>
                  <div class="row">                      
                      <div class="bio-row">
                          <p><span>First Name </span> <input name="first_name" type="text" value="<?=$data['first_name']?>"></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Last Name </span> <input name="last_name" type="text" value="<?=$data['last_name']?>"></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Country </span> <input name="country" type="text" value="<?=$data['country']?>"></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Birthday</span> <input name="date_of_birth" type="text" value="<?=$data['date_of_birth']?>"></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Occupation </span> <input name="occupation" type="text" value="<?=$data['occupation']?>"></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Email </span> <input disabled name="email" type="text" value="<?=$data['email']?>" readonly=""></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Mobile </span> <input name="mobile" type="text" value="<?=$data['mobile']?>"></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Phone </span> <input name="phone" type="text" value="<?=$data['phone']?>"></p>
                      </div>
                  </div>
              </div>
      
      
            
            <br>
            
              <div class="panel-body bio-graph-info" style="">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Bio</h1>
                        <textarea name="bio"><?=$data['bio']?></textarea>
                        <p class="text-center p-1">
                        <button type="submit" class="submit-button">Save updates</button>
                        </p><br>
                    </div>
                </div>
              </div>
            </div>
            
              
          
            </form>
    </div></div><br><br>
            