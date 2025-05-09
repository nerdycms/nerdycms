<?php
    $ent = new model(["where"=>"gender='Female'"]);
    $this->pdata['list'] = $ent->fetch("allfav",app::memberUser());
    $this->pdata['listsize'] = 9; ?>


<div class="profile-info col-md-9">          
  <div class="panel">
      <div class="bio-graph-heading">
                  Favourite models (<?=sizeof($this->pdata['list'])?>)
      </div>
      <div class="panel-body bio-graph-info">
          
            {{model-results|favourites}}
          
      </div>
  </div>          
</div><br><br>