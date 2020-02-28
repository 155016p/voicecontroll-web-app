<!DOCTYPE html>
<html>
<head>
	<title>new</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
</head>

<body background="TWO.jpg">
<nav class="menu">
	<ul>
		<li><a href="home.php"> Home</a></li>
		<li><a href="gallary.php">  Assistant </a></li>
		<li><a href="products.php"> products</a></li>
		<li><a href="about.php"> contact us</a></li>
		<li><a href="admin.php"> Admin</a></li>
		
	</ul>

	<form class="search-form">
		<!--<input type="text" placeholder="search">
		<button> Search</button>-->
</nav>
</form>
</nav>

<style>
        body {
  background-color: green;
      }

  .box {
    border: 2px solid;
    padding-top: 5px;
    padding-right: 5px;
    padding-bottom: 5px;
    padding-left: 5px;
    margin-left:25%;
    margin-right:25%;
    resize: both;
    overflow: hidd;
    border-style: solid;
    border-color: black;
    border-width: 2px;
    vertical-align: center; 
    text-align: center;
  }

    .red-box {
    background-color:lightblue;
    color: #0B0301;
    padding-top: 5px;
    padding-right: 5px;
    padding-bottom: 5px;
    padding-left: 5px;
  }



    </style>
  
</head>

<body onload="startInstruction()">

    
<div class="box red-box" align="right" width="48" height="48" >
    <select name="voice" id="voices">
      <option value="">select a voice</option>
    </select><br><br>

    <label ron="rate">Rate:<lable>       
    <input name="rate" type="range" min="0" max="3" value="1" step="0.1"><br><br>

    <label ron="pitch">pitch</label>
    <input type="range" name="pitch" min="0" max="2" step="0.1"><br><br>

<!-- <textarea name="text" rows="8" cols="80">Hello, have a nice day ! </textarea><br><br> -->

    <button id="stop" align="center">Stop</button>
    <button id="speak">Speak</button>
</div>

<div class= "box red-box">
    Assistant:<span id="assistant" ></span>
    <br>
    <br>
    Voice Input:<span id="message" ></span>
</div>
<div class= "box red-box" id= "result">
    Price:<span id="price" ></span>
    <br>
    <br>
    Location:<span id="location" ></span>
</div>

<script >

var i = 0;
    var pr = document.querySelector('#price');
    var loc = document.querySelector('#location');
    var variables = {};
    var message = document.querySelector('#message');
    var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
    var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;
    var answers = [];
    var grammar = '#JSGF V1.0';
    var assistant = document.querySelector('#assistant');
    var recognition = new SpeechRecognition();
    var speechRecognitionGrammerList = new SpeechGrammarList();
    var textToSpeech = window.speechSynthesis;
    speechRecognitionGrammerList.addFromString(grammar,1);
    recognition.grammars = speechRecognitionGrammerList;
    recognition.lang ='en-US';
    recognition.interimResults = false;
    var questions=["What do you want to buy ?","what's the color?","pattern that you prefer?","Size that you need?"]
    var textInput = questions[i];

    const msg = new SpeechSynthesisUtterance();
    let voices = [];
    const voicesDropdown = document.querySelector('[name="voice"]');
    const options = document.querySelectorAll('[type="range"],[name="text"]');
    const speakButton = document.querySelector('#speak');
    const stopButton = document.querySelector('#stop');
    //msg.text = document.querySelector('[name="text"]').value;
    msg.text = "Hello, have a nice day !  ";

    speechSynthesis.addEventListener('voiceschanged',populateVoices);
    voicesDropdown.addEventListener('changed',setVoice);
    options.forEach(option => option.addEventListener('change', setOption));
    speakButton.addEventListener('click',toggle);
    stopButton.addEventListener('click',toggle.bind(null, false));
    
    know = {
        "check" : "successful",
        "hello" : "hi",
        "how are you?" : "good",
        "ok" : "What do you want to buy?",
        "red":"",
        "green":"",
        "hat":"",
        "M":"",
        "m":"",
        "no":""

    };
    
    function startInstruction(){
        setTimeout(toggle,1000);
    }

    function toggle(startOver = true){
        speechSynthesis.cancel();
            if(startOver){
                speechSynthesis.speak(msg);
                setTimeout(start,1000);
            }
    }

    function start(){
        assistant.textContent = textInput;
        window.setTimeout(speakAssitant, 1000);
    };

    function speakAssitant(){
        //location.reload();
        var toSpeak = new SpeechSynthesisUtterance(textInput);
        
        if(i<questions.length){
            textToSpeech.speak(toSpeak);
            toSpeak.onend = function(event){
                setTimeout(recognitionStart, 10);
            }
        }else{
            console.log("completed");
            variables.name = answers[0];
            variables.color = answers[1];
            variables.pattern = answers[2];
            variables.size = answers[3];
            post();   
        }
    }

    function recognitionStart(event){
        recognition.start();
    }

    recognition.onresult = function(event){
        var last = event.results.length -1;
        var command = event.results[last][0].transcript;
        message.textContent = command;
        
    };

    recognition.onspeechend = function(event){
            recognition.stop();
            setTimeout(checkUserReply,1000);

    }; 

    recognition.onerror = function(event){
        speakAssitant();
        message.textContent = 'Sorry! I can not undestand';

    }

    function checkUserReply() {
        console.log("user input "+message.textContent);
        var user = message.textContent;
        if (user in know) {
            i++;
            textInput = questions[i];
            assistant.textContent = textInput;
            answers.push(user);
            setTimeout(speakAssitant,1000);
        } else {
            textInput = "Try again ";//+questions[i];
            setTimeout(speakAssitant,1000);
        }
        console.log(answers);
    } 

    function post(){
        console.log(variables.name);
            var name = variables.name;
            var color = variables.color;
            var pattern = variables.pattern;
            $.post('new.php',{postname:name,postcolor:color,postpattern:pattern},function(data){
            var d = split(data);
            var price = d[0];
            pr.textContent = price;
            var location = d[1];
            loc.textContent = location;
            var successMsg = `Great!. We have items that match to your choice. Price is ${price}. You can buy it from ${location} branch`;
            var failedMsg = "Sorry!. We don't have items match to you. try for anothor one.";
            if(d[1]!=undefined){
                assistant.textContent = successMsg;
                var toSpeak = new SpeechSynthesisUtterance(successMsg);
                textToSpeech.speak(toSpeak);
            }else{
                assistant.textContent = failedMsg;
                var toSpeak = new SpeechSynthesisUtterance(failedMsg);
                textToSpeech.speak(toSpeak);
                setTimeout(Reload,10000);
            }
            
                //$('#result').html();
                //}            
            });
    }

    function split(data) {
        var str = data;
        var res = str.split(" ");
        return res;
    }

    function Reload(){
        location.reload();
    }


    
    
    function populateVoices(){
        voices = this.getVoices();
            //console.log(voices);
        voicesDropdown.innerHTML = voices.filter(voice => voice.lang.includes('en')).map(voice => `<option value="${voice.name}">${voice.name} (${voice.lang})</option>`)
        .join(''); 
    }

    function setVoice(){
        msg.voice = voices.find(voice => voice.name === this.value);
        toggle();
    }

   

    function setOption(){
        console.log(this.name,this.value);
        msg[this.name]=this.value;
        toggle();
    }

</script>
</body>
</hlml>