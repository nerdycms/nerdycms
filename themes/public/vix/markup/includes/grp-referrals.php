        <div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                          Referrrals (<?=sizeof($this->pdata['list'])?>)
              </div>
              <div class="panel-body">
                  <h5 class='h-mid'>Your link</h5>
                  <div class="input-group p-4">                     
                      <input class="form-control" value="<?=DOM.VDIR."?_from=".md5("mmm".app::memberUser())?>">
                      <button class="btn btn--only-icon"><i class='fa fa-copy'></i></button>
                  </div>                  
              </div>
              <div class="panel-body">
                  <div class="text-center p-4">
                  <h5 class='h-mid'>Your referrals</h5>
                  <?php if(sizeof($this->pdata['list'])==0) { ?>
                        <div class="user-heading round">
                  <a href="#">
                      <i class='fa fa-question fa-4x'></i>
                  </a>
                  <h5>Nothing yet!</h5>                  
              </div>
                  <?php } else foreach($this->pdata['list'] as $r) { ?>
                        <div class="user-heading round">
                  <a href="#">
                      <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="">
                  </a>
                  <h5><?=$r['username']?></h5>                  
              </div>    
                  <?php } ?>
              </div></div>
          </div>          
        </div><br><br>