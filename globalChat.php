<html>
  <head>
    <link href="css/gChat.css" type="text/css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" data-auto-replace-svg="nest"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/socket.io.js"></script>
    <!-- <script src="js/global_chat_script.js" type="text/javascript"></script> -->

    <script type="text/javascript">
      $( document ).ready(function() {
        $(function() {
          var INDEX = 0; 
          $("#chat-submit").click(function(e) {
            e.preventDefault();
            var msg = $("#chat-input").val(); 
            if(msg.trim() == ''){
              return false;
            }
            var buttons = [
                {
                  name: 'Existing User',
                  value: 'existing'
                },
                {
                  name: 'New User',
                  value: 'new'
                }
              ];
          })
          
          $("#chat-circle").click(function() {    
            $("#chat-circle").toggle('scale');
            $(".chat-box").toggle('scale');
          })
          
          $(".chat-box-toggle").click(function() {
            $("#chat-circle").toggle('scale');
            $(".chat-box").toggle('scale');
          })
        
      })
    });

    </script>

  </head>

      <div id="chat-circle" class="btn btn-raised" hidden>
              <!-- <div id="chat-overlay"></div> -->
              <i id="chat-open" style="font-size: 1.5em" class="fas fa-comments"></i>
    </div>

    <?php 
        require_once "js/global_chat_backend.php";  
    ?>
    
    <div class="chat-box">
      <div class="chat-box-header">
        Global chat
        <span class="chat-box-toggle"><i class="material-icons">close</i></span>
      </div>
      <div class="chat-box-body">
        <div class="chat-box-overlay">   
        </div>
        <div class="chat-logs">
        
        </div>
      </div>
      <div class="chat-input">      

        <form>
          <input maxlength="300" autocomplete="off" style="color: white" type="text" id="chat-input" placeholder="Wyślij wiadomość..."/>
          <button style="cursor: pointer;" type="submit" class="chat-submit" id="chat-submit"><i class="material-icons">send</i></button>
        </form>      

      </div>
    </div>
  </div>

</html>