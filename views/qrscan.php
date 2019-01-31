<!DOCTYPE html>
<html>
<head>
	<title>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <audio id="myAudio">
  <source src="../resources/success.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
</head>
<body>
  <center> 
    <h1>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</h1>
    <button onclick="playAudio()" type="button">Play Audio</button>
    
    <video id="preview"></video>
    <script type="text/javascript">
      var x = document.getElementById("myAudio"); 

function playAudio() { 
  x.play(); 
} 

function pauseAudio() { 
  x.pause(); 
} 
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
      
      scanner.addListener('scan', function (content) {
        //alert(content);
        document.getElementById("yourInputFieldId").value = content;
        window.location = "test.php?user="+content;
        x.play(); 
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[1]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
   <input type='text' id='yourInputFieldId' />
   </center>
</body>
</html>