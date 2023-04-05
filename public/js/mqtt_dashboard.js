function startConnect(){

    var clientID = "clientID - "+parseInt(Math.random() * 100);

     client = new Paho.MQTT.Client("broker.emqx.io", Number(8084), "/mqtt", clientID);

    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    client.connect({
        useSSL: true,
        onSuccess: onConnect,
//        userName: userId,
 //       passwordId: passwordId
    });


}
function onConnect(){
    topic =  'smart_farm/dataset';
    console.log("Subscribing to topic "+topic+". ");

    client.subscribe(topic);
}



function onConnectionLost(responseObject){
    console.log('ERROR: Connection is lost');
    if(responseObject !=0){
        console.log("ERROR:"+ responseObject.errorMessage +".");
    }
}

function onMessageArrived(message){
    // console.log("OnMessageArrived: "+ message.payloadString);

    const d = '{'+message.payloadString+'}';
    const jj = JSON.parse(d);
    var node = jj.nodes[1];
    node = node.split(',');
    // console.log(node[1]);
    
    document.getElementById("d_temp").innerHTML = node[1];
    document.getElementById("d_humm").innerHTML = node[2];
    document.getElementById("d_soil").innerHTML = node[3];
    
}

function startDisconnect(){
    client.disconnect();
    console.log('Disconnected.');
}

function publishMessage(msg){
msg = msg;
topic = "smart_farm/command";

Message = new Paho.MQTT.Message(msg);
Message.destinationName = topic;

client.send(Message);
console.log('Message sent ('+msg+')');
}

window.onload =function() {
    startConnect()
}
