
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>about me &#8212; olly jackson</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<script type="text/javascript">
var socket;
var amount = 20;

function init(){
  var host = "ws://ollyjackson.co.uk:12345/echo/";
  try{
    socket = new WebSocket(host);
    log('WebSocket - status '+socket.readyState);
    socket.onopen    = function(msg){ log("Welcome - status "+this.readyState); };
    socket.onmessage = function(msg){
      console.log("GOT MESSAGE!?" + msg.data);

      if ($('#kitten')) {
        if (msg.data == 'up') {
          $('#kitten').animate({top: '-=' + amount});
        }
        if (msg.data == 'down') {
          $('#kitten').animate({top: '+=' + amount});
        }
        if (msg.data == 'left') {
          $('#kitten').animate({left: '-=' + amount});
        }
        if (msg.data == 'right') {
          $('#kitten').animate({left: '+=' + amount});
        }
      }
    };
    socket.onclose   = function(msg){ log("Disconnected - status "+this.readyState); };
  }
  catch(ex){ log(ex); }
}

function send(){
  var txt,msg;
  txt = $("msg");
  msg = txt.value;
  if(!msg){ alert("Message can not be empty"); return; }
  txt.value="";
  txt.focus();
  try{ socket.send(msg); log('Sent: '+msg); } catch(ex){ log(ex); }
}
function quit(){
  log("Goodbye!");
  socket.close();
  socket=null;
}

function command(command) {
  socket.send(command);
}

// Utilities
function log(msg){ $("log").innerHTML+="<br>"+msg; }
function onkey(event){ if(event.keyCode==13){ send(); } }
</script>
</head>
<body onload="init()">
<div id="log" style="display:none"></div>
<? if ($_GET['iphone']) { ?>
<button onclick="command('up')">up</button>
<button onclick="command('down')">down</button>
<button onclick="command('left')">left</button>
<button onclick="command('right')">right</button>

<? } else { ?>
<br/>
<input id="msg" type="textbox" onkeypress="onkey(event)" style="display:none"/>
<!--<button onclick="send()">Send</button>
<button onclick="quit()">Quit</button>-->
<img id="kitten" src="kitten.jpg" style="position:absolute;top:100px;left:100px;"/>
<? } ?>
</body>
</html>