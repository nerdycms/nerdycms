<footer>
    <div class="container-fluid mb0">
            <div class="row">
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                                                    <a href="/research/" style="width:50%;height:40px;text-align: center"><?=is_file(COM_CONTENT_DIR."/dark_logo.png")?"<img class='dark-only' style='height:50px' src='".VDIR."content/common/dark_logo.png'><img class='light-only' style='height:50px' src='".VDIR."content/common/light_logo.png'>":'<h2 class="high-color">'.BRAND_NAME.'</h2>'?></a>					
                            <div class="clear"></div>
                    </div>
                    <div class="col-md-8">
                    <div class="footer11 mt32">
                    <ul>
                                                    <li><a onclick="$('#signup').modal();aspo();">Join Now!</a></li>
                    <li><a onclick="$('#signin').modal();">Login</a></li>
                                                    <li><a href="/videos">Videos</a></li>
                    <li><a href="/models">Models</a></li>
                    <li><a href="/categories">Categories</a></li>
                    <li><a href="/video-tags">Video Tags</a></li>
                    <li><a href="/page/become-models">Be A Model</a></li>
                    <li><a href="/page/affiliates">Affiliates</a></li>

                    </ul>
                    </div>
                    <div class="footer12">
                    <ul>
                        <li><a href="<?=app::asset("/customer-service")?>">Customer Service</a></li>
                    <li><a href="/page/privacy">Privacy Policy</a></li>
                    <li><a href="/page/terms">Terms</a></li>
                    <li><a href="/page/dmca">DMCA</a></li>
                    <li><a href="/page/2257">2257</a></li>
                    <li><a href="/report"> Report Content </a></li>
                    </ul>
                    </div>
                    <div class="footer3">
                    <p class="copyright">Copyright © <script>document.write(new Date().getFullYear())</script>  - {{data|domain_name}}. All rights Reserved. All models appearing on this website are 18 years or older. All video, images, design, graphics are copyright. For billing inquiries, please visit <a href="https://portal.aquete.com/">AQUETE</a> our authorized processing sales agents. </p>
                    </div>
                            <img class="c2c-card visa" src="assets/visa_logo_compliant.svg" alt="VISA" width="60" height="100">
                            <img src="assets/mc_logo_compliant.svg" alt="Mastercard" width="60" height="100">
                            <img src="assets/amex-index.png" alt="American Express" width="60" height="35">
                            <img src="assets/discover-index.png" alt="Discover" width="60" height="35">
                    <div class="footer-img"><ul>
                            <li><img src="assets/rta.gif" alt="RTA Icon">&nbsp;</li>
                    </ul><div>
                    <div class="footer-text">
                    <h4> <a href="/page/2257"> 18 U.S.C. § 2257 Record-Keeping Requirements Compliance Statement.</a></h4>                    
                    </div>					
                    </div>				

            <hr>
            <p class="copyright">Copyright © <script>document.write(new Date().getFullYear())</script> {{data|copyright_name}} - <?=@NERDY_LINK?"<a href='https://nerdycms.com' target='_blank' class='high-color'>Developed by NerdyCMS.com</a>":""?></p>

    </div>			
</div></div></div></footer>
