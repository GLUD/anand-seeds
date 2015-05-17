#include <SPI.h>
#include <Client.h>
#include <Ethernet.h>
#include <Server.h>
#include <Udp.h>
#include <DHT.h>
#define DHTPIN 13

byte mac[] = { 
  0xDE, 0xA3, 0xBE, 0xEF, 0xFA, 0xE1 };
//byte rip[] = {0,0,0,0};
IPAddress ip(192,168,1,238);
IPAddress servidor(192,168,1,236);  // IP del servidor (no DNS)

//IPAddress gateway(192,168,1, 1);
//IPAddress subnet(255, 255, 255, 0);
// Initialize the Ethernet server library
// with the IP address and port you want to use
// (port 80 is default for HTTP):
EthernetServer server(80);  //Se escoje un puerto por seguridad
EthernetClient cliente;

int iluminacion= 4; //este actuador se encarga da la luz
int ventilacion= 5; //este actuador se encarga da la ventilacion
int riego= 6; //este actuador se encarga del riego
int dimmer=9;   //Se tiene como dimmer para las luces
int sen_htierra=A0;
int valorHtierra = 0;
float h=0;
float t=0;
int humr_tem = 13;
float temperatura;
int lightPin = 1; // Pin LDR.
int lumens;

//Seleccionamos el pin en el que se conectará el sensor
#define DHTTYPE DHT11 //Se selecciona el DHT11 (hay //otros DHT)
DHT dht(DHTPIN, DHTTYPE); //Se inicia una variable que será usada por Arduino para comunicarse con el sensor

String readString = String(30);

void setup()
{
  // start the Ethernet connection and the server:
  Ethernet.begin(mac, ip);
  server.begin();
  pinMode(iluminacion,OUTPUT);
  pinMode(ventilacion,OUTPUT);
  pinMode(riego,OUTPUT);
  pinMode(humr_tem, INPUT);
  Serial.begin(9600);



}
void cargarSensado(){
  //Se inicia lectura de humedad del suelo
  valorHtierra = analogRead(sen_htierra);
  h= dht.readHumidity(); //Se lee la humedad
  t = dht.readTemperature(); //Se lee la temperatura
  lumens = analogRead(lightPin);
}

void loop()
{
  cargarSensado();
  //while(contado<)
//  enviar();
  // escucha las peticiones del cliente
  escucha();
  //delay(100);
}

void escucha(){
  EthernetClient client = server.available();
  if (client) {     
    // an http request ends with a blank line
    boolean currentLineIsBlank = true; 
    while (client.connected()) {

      if (client.available()) {
        char c = client.read();
        Serial.print(c);

        //  Serial.println(client.getRemoteIP(rip));
        if (readString.length()<100) //leer peticion HTTP caracter por caracter
        {
          readString += c;
        }
        if (c=='\n') //Si la peticion HTTP ha finalizado
        {
          if (c=='&')          
          {
            if(readString.indexOf("ilum=")>0){
              digitalWrite(iluminacion,HIGH);
            }  

          }

          //Determinar lo que se recibe mediante GET para encender el Led o apagarlo
          if(readString.indexOf("ilum=")>0){
            digitalWrite(iluminacion,HIGH);
          }    
          if(readString.indexOf("ilum=off")>0){
            digitalWrite(iluminacion,LOW);
          }
          if(readString.indexOf("vent=on")>0){
            digitalWrite(ventilacion,HIGH);
          }
          if(readString.indexOf("vent=off")>0){
            digitalWrite(ventilacion,LOW);
          }
          if(readString.indexOf("rieg=on")>0){
            digitalWrite(riego,HIGH);
          }
          if(readString.indexOf("rieg=off")>0){
            digitalWrite(riego,LOW);
          }


          if(readString.indexOf("pwm=sec")>0){
            for(int fadeValue = 0 ; fadeValue <= 255; fadeValue +=5) { 
              // sets the value (range from 0 to 255):
              analogWrite(dimmer, fadeValue);         
              // wait for 30 milliseconds to see the dimming effect    
              delay(30);

              // fade out from max to min in increments of 5 points:
              for(int fadeValue = 255 ; fadeValue >= 0; fadeValue -=5) { 
                // sets the value (range from 0 to 255):
                analogWrite(dimmer, fadeValue);         
                // wait for 30 milliseconds to see the dimming effect    
                delay(30);                            
              } 

            }

          }
          readString=""; //Vaciar el string que se uso para la lectura
          client.println("Access-Control-Allow-Origin: *");
          client.stop();
        }
      }
    }
  }
}

void  request(){  
  if (cliente.connect(servidor, 80)) {
    Serial.println("connected");
    // Se hace un  request HTTP: 
    ///DBClass/registro_datos.php
    //soberania-code/add_sensor.php
    cliente.println("GET /soberania-code/add_sensor.php?idar=1018438961&temp=" + String(t*0.6)
      +"&humr="+String(h)+"&hums="+String(valorHtierra)+"&radi="+String(lumens));
    cliente.println("HTTP/1.1 200 OK");
    cliente.println("Host: 192.168.1.236");
    cliente.println("Connection: close");
    cliente.println();
  } 
  else {
    // kf you didn't get a connection to the server:
    Serial.println("connection failed");
  }

}
void  enviar(){  
  //Envio de metodo
  if (cliente.available()) {
    char get = cliente.read();
    Serial.print(get);
  }

  if (!cliente.connected()) {
    Serial.println();
    Serial.println("disconnecting.");
    cliente.stop();
    request();
    //while(true);
  }
}

