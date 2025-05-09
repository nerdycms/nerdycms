{{doc}}
    <head>
        {{head-main}}
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.css" integrity="sha512-7uSoC3grlnRktCWoO4LjHMjotq8gf9XDFQerPuaph+cqR7JC9XKGdvN+UwZMC14aAaBDItdRj3DcSDs4kMWUgg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="nav-offset text-center"> 
        {{back-to-top}}        
        {{nav}}       
        <div style="height:100vh">       
        <div class="widget-r"> 
                <h2>Customer service</h2> 
                <?=@$this->pdata['error']?"<div class='error'>{$this->pdata['error']}</div>":""?>
                <form method="post" id="rsform" action="<?=$this->hook?>?_action=service">
                    <input type="hidden" name="_rtkn" value="<?=app::request("_rtkn")?>">
                    <div class="flex-h2">
                        <table width="100%">                                           
                          <tbody><tr>
                            <td>
                              <input type="text" name="cs_funame" placeholder="full name" required="">                      
                            </td>    
                              </tr><tr>
                            <td>
                              <input name="cs_email" placeholder="email" required="" type="email">                      
                            </td>                                            
                            </tr><tr>
                            <td>
                                <select name="cs_subject" required="">                                    
                                    <option>Subject: Customer support</option>
                                    <option>Subject: Become a model</option>
                                    <option>Other subject</option>                                    
                                </select>
                            </td>    
                            </tr><tr>
                            <td>
                                <textarea name="cs_message" placeholder="message" required=""></textarea>
                            </td>    
                          </tr>                                                                                      
                        </tbody></table>
                        <div class="v-submit text-center">
                           <button type="submit" class="p-1 text-white btn-prim ucase">Send</button><br>                         
                        </div>                            
                    </div>
                </form>
            </div>         
        </div>
    </div>         
        {{footer}}        
        {{util-scripts}}
    </body>
</html>   