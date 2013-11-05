/*
  DigitalReadSerial
 Reads a digital input on pin 2, prints the result to the serial monitor 
 
 This example code is in the public domain.
 */

// digital pin 2 has a pushbutton attached to it. Give it a name:
int noPins = 5;
int myState[5];
int myPins[] = {2, 3, 4, 5, 6};

int i;

// the setup routine runs once when you press reset:
void setup() {
  // initialize serial communication at 9600 bits per second:
  Serial.begin(9600);
   
  for (i = 0; i < noPins; i = i + 1) {
    pinMode(myPins[i],INPUT);
  }

  delay(10);   
  for (i = 0; i < noPins; i = i + 1) {
    int buttonState = digitalRead(myPins[i]);
    myState[i] = buttonState;
    delay(1);
  }
  
  delay(10);  
}

// the loop routine runs over and over again forever:
void loop() {
  
  for (i = 0; i < noPins; i = i + 1) {
    int buttonState = digitalRead(myPins[i]);
    if(myState[i] != buttonState){
      Serial.print(myPins[i]);
      Serial.print(':');
      Serial.println(buttonState);
      myState[i] = buttonState;
    }
    delay(1);
  }
}



