{{doc}}
    <head>
        {{head-main}}
    </head>
    <body class="nav-offset">        
        {{back-to-top}}
        {{nav}}
        
<!--        <style>
      pre {
        outline: 1px solid #ccc;
        padding: 5px;
        margin: 5px;
      }

      .string {
        color: green;
      }

      .number {
        color: darkorange;
      }

      .boolean {
        color: blue;
      }

      .null {
        color: magenta;
      }

      .key {
        color: red;
      }
    </style>

    <title>Pion ion-sfu | Echotest</title>
  </head>

  <body>
    <nav class="navbar navbar-light bg-light border-bottom">
      <h3>Pion</h3>
    </nav>
    <div class="container pt-4">
      <div class="row" id="start-btns">
        <div class="col-12">
          <button type="button" class="btn btn-primary" onclick="start(false)">
            start
          </button>
          <button type="button" class="btn btn-primary" onclick="start(true)">
            start with simulcast
          </button>
        </div>
      </div>

      <div class="row">
        <div class="col-12 pt-4">Media</div>
      </div>
      <div class="row">
        <div class="col-6 pt-2">
          <span
            style="position: absolute; margin-left: 5px; margin-top: 5px"
            class="badge badge-primary"
            >Local</span
          >
          <video
            id="local-video"
            style="background-color: black"
            width="320"
            height="240"
          ></video>
          <div class="controls" style="display: none">
            <div class="row pt-3">
              <div class="col-3">
                <strong>Video</strong>
                <div class="radio">
                  <label
                    ><input
                      type="radio"
                      onclick="controlLocalVideo(this)"
                      value="true"
                      name="optlocalvideo"
                      checked
                    />
                    Unmute</label
                  >
                </div>
                <div class="radio">
                  <label
                    ><input
                      type="radio"
                      onclick="controlLocalVideo(this)"
                      value="false"
                      name="optlocalvideo"
                    />
                    Mute</label
                  >
                </div>
              </div>
              <div class="col-3">
                <strong>Audio</strong>
                <div class="radio">
                  <label
                    ><input
                      type="radio"
                      onclick="controlLocalAudio(this)"
                      value="true"
                      name="optlocalaudio"
                      checked
                    />
                    Unmute</label
                  >
                </div>
                <div class="radio">
                  <label
                    ><input
                      type="radio"
                      onclick="controlLocalAudio(this)"
                      value="false"
                      name="optlocalaudio"
                    />
                    Mute</label
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 pt-2">
          <span
            style="position: absolute; margin-left: 5px; margin-top: 5px"
            class="badge badge-primary"
            >Remote</span
          >
          <span
            id="size-tag"
            style="position: absolute; margin-left: 5px; top: 225px"
            class="badge badge-primary"
          ></span>
          <span
            id="br-tag"
            style="position: absolute; left: 215px; top: 225px"
            class="badge badge-primary"
          ></span>
          <video
            id="remote-video"
            style="background-color: black"
            width="320"
            height="240"
          ></video>
          <div class="controls" style="display: none">
            <div class="row pt-3">
              <div class="col-3">
                <strong>Video</strong>
                <div id="simulcast-controls" style="display: none">
                  <div class="radio">
                    <label
                      ><input
                        type="radio"
                        onclick="controlRemoteVideo(this)"
                        value="high"
                        name="optremotevideos"
                        checked
                      />
                      High</label
                    >
                  </div>
                  <div class="radio">
                    <label
                      ><input
                        type="radio"
                        onclick="controlRemoteVideo(this)"
                        value="medium"
                        name="optremotevideos"
                      />
                      Medium</label
                    >
                  </div>
                  <div class="radio">
                    <label
                      ><input
                        type="radio"
                        onclick="controlRemoteVideo(this)"
                        value="low"
                        name="optremotevideos"
                      />
                      Low</label
                    >
                  </div>
                  <div class="radio">
                    <label
                      ><input
                        type="radio"
                        onclick="controlRemoteVideo(this)"
                        value="none"
                        name="optremotevideos"
                      />
                      Mute</label
                    >
                  </div>
                </div>

                <div id="simple-controls" style="display: none">
                  <div class="radio">
                    <label
                      ><input
                        type="radio"
                        onclick="controlRemoteVideo(this)"
                        value="high"
                        name="optremotevideo"
                        checked
                      />
                      Unmute</label
                    >
                  </div>
                  <div class="radio">
                    <label
                      ><input
                        type="radio"
                        onclick="controlRemoteVideo(this)"
                        value="none"
                        name="optremotevideo"
                      />
                      Mute</label
                    >
                  </div>
                </div>
              </div>
              <div class="col-3">
                <strong>Audio</strong>
                <div class="radio">
                  <label
                    ><input
                      type="radio"
                      onclick="controlRemoteAudio(this)"
                      value="true"
                      name="optremoteaudio"
                      checked
                    />
                    Unmute</label
                  >
                </div>
                <div class="radio">
                  <label
                    ><input
                      type="radio"
                      onclick="controlRemoteAudio(this)"
                      value="false"
                      name="optremoteaudio"
                    />
                    Mute</label
                  >
                </div>
              </div>
            </div>
            <strong class="d-block">API call</strong>
            <pre
              id="api"
              class="d-block border"
              style="
                background-color: #f8f9fa;
                height: 117px;
                width: 320px;
                margin: 5px 0;
              "
            ></pre>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 pt-4">Data</div>
      </div>
      <div class="row">
        <div class="col-6 pt-2">
          <textarea
            id="local-data"
            class="d-block border"
            style="
              background-color: #f8f9fa;
              height: 117px;
              width: 320px;
              margin: 5px 0;
              padding: 5px;
            "
            placeholder="Send a message"
          ></textarea>
          <button type="button" class="btn btn-primary" onclick="send()">
            send
          </button>
        </div>
        <div class="col-6 pt-2">
          <pre
            id="remote-data"
            class="d-block border"
            style="
              background-color: #f8f9fa;
              height: 117px;
              width: 320px;
              margin: 5px 0;
            "
          ></pre>
        </div>
      </div>
    </div> -->
        {{live-broadcast}}
        {{live-scripts}}
        
        {{util-scripts}}
    </body>
</html>    