<div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                          Wallet balance $<?=$this->pdata['u']['wallet_balance']?>
              </div>
              <div class="panel-body wallet-info text-center p-4">
                  <button onclick="walletAdd()" class="hotbutton">+$ Add funds to wallet now!</button>
                  {{member-trans}}
              </div>
          </div>          
        </div><br><br>
        <script>
        
        function walletAdd() {
            sshow('wallet');
            aspo();            
        }
        
        </script>