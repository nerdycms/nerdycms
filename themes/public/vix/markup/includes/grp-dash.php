<?php 
    $ent = new member;
    $data = $ent->fetch("id",app::memberUser());
?>
    <div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                  Dashboard
              </div>
              <div class="panel-body bio-graph-info">
                  <h1>Overview</h1>
                  <div class="row">
                      <div class="bio-row">
                          <p><span>First Name </span>: <?=@$data['first_name']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Last Name </span>: <?=@$data['last_name']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Country </span>: <?=@$data['country']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Birthday</span>: <?=@$data['date_of_birth']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Occupation </span>: <?=@$data['occupation']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Email </span>: <?=@$data['email']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Mobile </span>: <?=@$data['mobile']?></p>
                      </div>
                      <div class="bio-row">
                          <p><span>Phone </span>: <?=@$data['phone']?></p>
                      </div>
                  </div>
              </div>
          </div>  
      
            <!--<div class="profile-widgets">
              <div class="row">
                  <div class="col-md-6">
                      <div class="panel">
                          <div class="panel-body">
                              <div class="bio-chart">
                                  <div class="inner"><small>membership</small><span data-count="65" class="red large">0</span><small>days</small></div>
                              </div>
                              <div class="bio-desk">
                                  <h4 class="red">Account status: active</h4>
                                  <p>Joined : 15 July</p>
                                  <p>Renews : 15 August</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="panel">
                          <div class="panel-body">
                              <div class="bio-chart">
                                  <div class="inner"><small>favourited</small><span data-count="32" class="terques large">0</span><small>videos</small></div>
                              </div>
                              <div class="bio-desk">
                                  <h4 class="terques">Favourite videos </h4>
                                  <p>First added : 15 July</p>
                                  <p>Last added : 15 August</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="panel">
                          <div class="panel-body">
                              <div class="bio-chart">
                                  <div class="inner"><small>sent</small><span data-count="137" class="green large">0</span><small>messages</small></div>
                              </div>
                              <div class="bio-desk">
                                  <h4 class="green">Messages sent</h4>
                                  <p>First message : 15 July</p>
                                  <p>Last message : 15 August</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="panel">
                          <div class="panel-body">
                              <div class="bio-chart">
                                  <div class="inner"><small>liked</small><span data-count="87" class="purple large">0</span><small>models</small></div>
                              </div>
                              <div class="bio-desk">
                                  <h4 class="purple">Favourite models</h4>
                                  <p>First added : 15 July</p>
                                  <p>Last added : 15 August</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>-->
                </div>