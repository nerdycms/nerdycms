<?php $hideban = @$this->pdata['cst']['hide_home_banners']=="on"; ?>
{{doc}}
   <head>
        {{head-main}}
    </head>
<body>
  
  <!--Main Navigation-->
  <header>
    {{back-to-top}}
    {{nav}}
    {{preview-banner}}

  </header>
  <!--Main Navigation-
  <!--main content -->
  <main>
    <!-- top video -->
    <section class="section  wow fadeIn">
      <div class="container-fluid">
           <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">Featured Videos</h4>
        </div>
        <div class="row">
          {{video-thumbs|featured}}
        </div>
        </section>
        <!--/.row-->
        <?php if(!$hideban && !app::memberUser()) { ?>  
        <!-- Now Playing -->
    
        <section class="section  wow fadeIn">
      <div class="container-fluid">
        <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">Awesome Features</h4>
        </div>

        </div>
        </div>
        <!--/.row-->

        <!-- banner -->
        <div class="row banner">
            {{creative|straight|533}}   
        </div>
      </div>
    </section>
        <?php } ?>
<?php if(!$hideban) { ?>  
    <section class="section  wow fadeIn">
      <div class="container-fluid">
        <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">Models</h4>
        </div>
        <div class="row">
            {{model-thumbs|random}}          
        </div>
          <div class="getaccess">
          <a class="join" href="/videos">SHOW ALL VIDEOS <i class="fas fa-angle-double-right fa-1x"></i></a>
          </p>
        </div>
        </div>
    
        <!--/.row-->
  
    </section>
<?php } ?>
    <section class="section  wow fadeIn">
      <div class="container-fluid">
        <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">New {{data|brand_name}} Videos</h4>
        </div>
        <div class="row">
          {{video-thumbs|new}}
        </div>
        <!--/.row-->
    </section>
<?php if(!$hideban) { ?>  
        <section class="section  wow fadeIn">
      <div class="container-fluid">
        <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">Coming Soon</h4>
        </div>

        </div>
        </div>
        <!--/.row-->

        <!-- banner -->
        <div class="row banner">
          {{countdown}}
        </div>
      </div>
    </section>
    <!-- banner-->
<?php } ?>

    <section class="section  wow fadeIn">
      <div class="container-fluid">
       <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">Top Rated Videos</h4>
        </div>
        <div class="row">
        {{video-thumbs|top}}
        </row>

    </section>
    <?php if(!$hideban && !app::memberUser()) { ?>  
        <section class="section  wow fadeIn">
      <div class="container-fluid">
        <div class="row vid-title ">
          <div class="title-breaker"></div>
          <h4 class="title-name">BONUS OFFER</h4>
        </div>

        
        {{creative|last|440}}   
        

                <div class="getaccess">
          <a class="join"  onclick="$('#signup').modal();aspo();">GET ACCESS <i class="fas fa-angle-double-right fa-1x"></i></a>
        </div>
      </div>
      </section>
    <?php } ?>
  </main>

        {{footer}}
        {{util-scripts}}

</html>