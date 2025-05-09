        <div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                          Support
              </div>
              <div class="panel-body bio-graph-info">
                  <p class="text-center">
                      Fill in the form below to send a support request. A member of our team will reply within 48 hours.
                  </p>
                  <?=@$this->pdata['error']?"<div class='error'>{$this->pdata['error']}</div>":""?>
                  <form method="post" id="rsform" action="<?=$this->hook?>?_action=support">
                    <input type="hidden" name="_rtkn" value="<?=app::request("_rtkn")?>">
                    <table width="100%">                                           
                          <tbody><tr>                            
                            <td>
                              <input type="text" name="ms_subject" placeholder="subject" required="">                      
                            </td>    
                            </tr><tr>
                            <td>
                                <textarea name="ms_message" placeholder="message" required=""></textarea>
                            </td>    
                          </tr>                                                                                      
                        </tbody>
                    </table>                    
                    <p class="text-center">
                        <button type="submit" class="submit-button">Send</button><br>                                             
                    </p>
                  </form>
              </div>
          </div>          
        </div><br><br>