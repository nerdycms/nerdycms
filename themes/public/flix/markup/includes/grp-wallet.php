        <div class="profile-info col-md-9">          
          <div class="panel">
              <div class="bio-graph-heading">
                          Wallet balance $50
              </div>
              <div class="panel-body wallet-info">
                  <button onclick="walletAdd()" class="fund-button">$ Add funds</button>
                  {{member-trans}}
              </div>
          </div>          
        </div><br><br>
        <script>
        
        function walletAdd() {
            sshow('wallet');
            aspo();
            $('#signup').modal();
        }
        
        </script>