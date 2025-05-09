        <div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                          Referrrals (10)
              </div>
              <div class="panel-body">
                  <h5>Your link</h5>
                  <div class="input-group">                     
                      <input class="form-control" value="<?=DOM.VDIR."?_from=".md5("mmm".app::memberUser())?>">
                      <button class="btn btn-primary m-1">Copy</button>
                  </div>                  
              </div>
              <div class="panel-body">
                  <h5>Your referrals</h5>
                  <?php foreach($this->pdata['list'] as $r) { ?>
                        <div class="user-heading round">
                  <a href="#">
                      <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="">
                  </a>
                  <h1><?=$r['username']?></h1>                  
              </div>    
                  <?php } ?>
              </div>
          </div>          
        </div><br><br>