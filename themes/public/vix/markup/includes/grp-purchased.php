<?php     $ent = new video();
          $vl =  $ent->fetch("array");
          $wat = new walletTransaction;                              
          $mid = app::memberUser();
          $list = [];
          $pushed = [];
          foreach($vl as $vi) {
              if($wat->fetch("own",'video',$vi['id'],$mid)) {
                  if(!isset($pushed[$vi['id']])) {
                      $list []= $vi;
                      $pushed[$vi['id']] = true;
                  }
              }
          }
          $this->pdata['list'] = $list;
          $this->pdata['listsize'] = 9; ?>
<div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                          Purchased videos (<?=sizeof($this->pdata['list'])?>)
              </div>
              <div class="panel-body bio-graph-info">
                  {{video-results|favourites}}
              </div>
          </div>          
        </div><br><br>