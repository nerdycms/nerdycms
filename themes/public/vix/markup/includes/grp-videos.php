<?php     $ent = new video(["where"=>"sexuality='Straight' AND publish_status='Published'"]);
          $this->pdata['list'] = $ent->fetch("allfav",app::memberUser());
          $this->pdata['listsize'] = 8; ?>        

<div class="profile-info col-md-9">          
<div class="panel">
    <div class="bio-graph-heading">
                Favourite videos (<?=sizeof($this->pdata['list'])?>)
    </div>
    <div class="panel-body bio-graph-info">
        {{video-results|favourites}}
    </div>
</div>          
</div><br><br>