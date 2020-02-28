<html lang="en">
    <head>
        <title>document</title>
        <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    </head>
    <body onload = "Trigger()">
        <br>
        <br>
        Assistant:<span id="assistant" ></span>
        <!-- <br>
        <button id="giveCommand">start</button>
        <br> -->
        Voice Input:<span id="message" ></span>

        <br>
        <!-- <br>
        Select Voice: <select name="" id="voiceList"></select>
        <br> -->
    <br>
            <!-- <button id="btnspeak">Speak</button> -->
            
            <div id="result"></div>  
        <script>
            function post(){
                console.log(variables.name);
                 var name = variables.name;
                 var color = variables.color;
                 var pattern = variables.pattern;

                 $.post('new.php',{postname:name,postcolor:color,postpattern:pattern},function(data){
                    //if(data=="1"){
                     //on_callPHP();
                var toSpeak = new SpeechSynthesisUtterance(data);
                var selectedVoiceName = voiceList.selectedOptions[0].getAttribute('data-name');
                voices.forEach((voice)=>{
                    if(voice.name === selectedVoiceName){
                        toSpeak.voice = voice;
                    }
                });
                textToSpeech.speak(toSpeak);
                    $('#result').html(data);
                    //}            
                 });
            }
            var i = 0;
            function Trigger(){
                window.setTimeout(speakReply, 1000);
            };

            var variables = {};
            var message = document.querySelector('#message');
            var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
            var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;
            var answers = [];
            var grammar = '#JSGF V1.0';
            var assistant = document.querySelector('#assistant');
            var recognition = new SpeechRecognition();
            var speechRecognitionGrammerList = new SpeechGrammarList();
            speechRecognitionGrammerList.addFromString(grammar,1);
            
            recognition.grammars = speechRecognitionGrammerList;
            recognition.lang ='en-US';
            recognition.interimResults = false;

            var questions=["What do you want to buy ?","what's the color?","pattern that you prefer?","Size that you need?"]
            var textInput = questions[i];
            assistant.textContent = textInput;
            //variables.name = 'frock';//answers[0];
            //variables.color = 'red';//answers[1];
            //variables.pattern = 'plaid';//answers[2];
            // $.ajax({
            //             url:"getInput.php",
            //             method: "post",
            //             data : variables,
            //             success: function(res){
            //                 console.log(res);
            //             }
            //         });

            
            function speakReply(){
                //on_callPHP();
                var toSpeak = new SpeechSynthesisUtterance(textInput);
                //var selectedVoiceName = voiceList.selectedOptions[0].getAttribute('data-name');
                // voices.forEach((voice)=>{
                //     if(voice.name === selectedVoiceName){
                //         toSpeak.voice = voice;
                //     }
                // });
                if(i<questions.length){
                    textToSpeech.speak(toSpeak);
                    toSpeak.onend = function(event){
                        setTimeout(recognitionStart, 1000);
                    }
                    
                    //i++;
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
                 setTimeout(talk,1000);

            }; 

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
            
            function talk() {
                console.log("user input "+message.textContent);
                var user = message.textContent;
                if (user in know) {
                    i++;
                    textInput = questions[i];
                    assistant.textContent = textInput;
                    answers.push(user);
                    setTimeout(speakReply,1000);
                } else {
                    textInput = "Try again ";//+questions[i];
                    setTimeout(speakReply,1000);
                }
                console.log(answers);
            } 

            recognition.onerror = function(event){
                message.textContent = 'Error';
                
            }

            // document.querySelector('#giveCommand').addEventListener('click',function(event){
            //     recognition.start();
            // })
            
            function showResult(){
                $name = 'frock';//answers[0];
                $color = 'red';//answwers[1];
                $pattern = 'plaid';//answers[2];
            }

            var voiceList = document.querySelector('#voiceList');
            var speak = document.querySelector('#speak');

            var textToSpeech = window.speechSynthesis;
            var voices =[];

            GetVoices();
            if(speechSynthesis !== undefined){
                speechSynthesis.onvoiceschanged=GetVoices;
            }
            
            

            // btnspeak.addEventListener('click',()=>{
            //     console.log(textInput);
            //     var toSpeak = new SpeechSynthesisUtterance(textInput);
            //     var selectedVoiceName = voiceList.selectedOptions[0].getAttribute('data-name');
            //     voices.forEach((voice)=>{
            //         if(voice.name === selectedVoiceName){
            //             toSpeak.voice = voice;
            //         }
            //     });
            //     textToSpeech.speak(toSpeak);
            // });

            function GetVoices(){
                // voices = textToSpeech.getVoices();
                // //voiceList.innerHTML = '';
                // voices.forEach((voice)=>{
                //     var listItem = document.createElement('option');
                //     listItem.textContent=voice.name;
                //     listItem.setAttribute('data-lang',voice.lang);
                //     listItem.setAttribute('data-name',voice.name);
                //     voiceList.appendChild(listItem);
                // });
                // voiceList.selectedIndex =0;
            }


        </script>
     
        
    </body>
</html>