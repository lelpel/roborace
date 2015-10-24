#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "ADC.h"
#include "setup.h"
#include "IRremote.h"
#include "config.h"
#include "motor.h"
#include "PWMServo.h"
#include "sensors.h"

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
void setup()
{
  analogReference(DEFAULT); //analog init  
  ADC_setup();
  speedInit();
  setupMotorServo();
  setupIrrecv();

  pinMode(BUTTON, INPUT); //button init
  digitalWrite(BUTTON,HIGH); //set pul-up resistor

  Serial.begin(SERIAL_SPEED); //init serial
  // say START
  Serial.println("\nStart");

}
//VARIABLEAS 
int angle = 0;
char speedR = 0;
boolean isBumpk = false;

int lapCount = 0;
int lapTime = 0;

unsigned long lastTimeSPEED = 0; // used in module speed
char autoMode = 2; // is auto mode enable ore no?


unsigned char sen_left[3];
unsigned char med_left;
unsigned char sen_rightcenter[3];
unsigned char med_rightcenter;
unsigned char sen_leftcenter[3];
unsigned char med_leftcenter;
unsigned char sen_right[3];
unsigned char med_right;
int k = 0;
unsigned long ir_command;

char command = 'S';
char prevCommand = 'A';
int velocity = 0;   
unsigned long timer0 = 2000;  //Stores the time (in millis since execution started) 
unsigned long timer1 = 0;  //Stores the time when the last command was received from the phone

int voltageCount = 0;

int mod = 2;


/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// functions

void radioMove(int inServo,int inMotor,int inRight,int inLeft,int inForwrd,int inNeutral,int inBack) {
  angle = map(inServo,inLeft,inRight,-SERVO_MAX_ANGLE,SERVO_MAX_ANGLE);
  if (inMotor<(inBack+100)) {
    back();
    delay(300);
  }
  else {
    speedR = map( inMotor,inForwrd,inNeutral,20,0);
  }

}

void ledSwitch(boolean value) {
  if (value == HIGH) digitalWrite(LED_PIN, HIGH);
  else digitalWrite(LED_PIN, LOW);
}




/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////// loop



void loop() {  
  //  while(1)
  //  {
  //    
  //    if(Serial.available() > 0){ 
  //      timer1 = millis();   
  //      prevCommand = command;
  //      command = Serial.read(); 
  //      //Change pin mode only if new command is different from previous.   
  //      if(command!=prevCommand){
  //        //Serial.println(command);
  //        switch(command){
  //        case 'F':
  //          speedR =  velocity;
  //          angle = 0; 
  //          //yellowCar.Forward_4W(velocity);
  //          break;
  //        case 'B':  
  //          //yellowCar.Back_4W(velocity);
  //          angle = 0;
  //          back();
  //          delay(500);
  //          break;
  //        case 'L':  
  //          //yellowCar.Left_4W();
  //          angle = -SERVO_MAX_ANGLE;
  //          break;
  //        case 'R':
  //          angle = SERVO_MAX_ANGLE;
  //          //yellowCar.Right_4W();  
  //          break;
  //        case 'S': 
  //          speedR =  0;
  //          angle = 0;
  //          //yellowCar.Stopped_4W();
  //          break; 
  //        case 'I':  //FR  
  //          speedR = velocity;
  //          angle = SERVO_MAX_ANGLE;
  //          //yellowCar.ForwardRight_4W(velocity);
  //          break; 
  //        case 'J':  //BR  
  //          //yellowCar.BackRight_4W(velocity);
  //          break;        
  //        case 'G':  //FL 
  //          speedR = velocity;
  //          angle = -SERVO_MAX_ANGLE; 
  //          //yellowCar.ForwardLeft_4W(velocity);
  //          break; 
  //        case 'H':  //BL
  //          //yellowCar.BackLeft_4W(velocity);
  //          break;
  //        case 'W':  //Font ON 
  //          //digitalWrite(pinfrontLights, HIGH);
  //          break;
  //        case 'w':  //Font OFF
  //          //digitalWrite(pinfrontLights, LOW);
  //          break;
  //        case 'U':  //Back ON 
  //          //digitalWrite(pinbackLights, HIGH);
  //          break;
  //        case 'u':  //Back OFF 
  //          //digitalWrite(pinbackLights, LOW);
  //          break; 
  //        case 'D':  //Everything OFF 
  //          //digitalWrite(pinfrontLights, LOW);
  //          //digitalWrite(pinbackLights, LOW);
  //          //yellowCar.Stopped_4W();
  //          break;         
  //        default:  //Get velocity
  //          if(command=='q'){
  //            velocity = 10;
  ////            velocity = 255;  //Full velocity
  //            //yellowCar.SetSpeed_4W(velocity);
  //          }
  //          else{ 
  //            //Chars '0' - '9' have an integer equivalence of 48 - 57, accordingly.
  //            if((command >= 48) && (command <= 57)){ 
  //              //Subtracting 48 changes the range from 48-57 to 0-9.
  //              //Multiplying by 25 changes the range from 0-9 to 0-225.
  ////              velocity = (command - 48)*25;       
  ////              yellowCar.SetSpeed_4W(velocity);
  //                velocity = (command - 48);
  //            }
  //          }
  //        }
  //      }
  //    }
  //    else{
  //      timer0 = millis();  //Get the current time (millis since execution started).
  //      //Check if it has been 500ms since we received last command.
  //      if((timer0 - timer1)>500){  
  //        //More tan 500ms have passed since last command received, car is out of range.
  //        //Therefore stop the car and turn lights off.
  //        //digitalWrite(pinfrontLights, LOW);
  //        //digitalWrite(pinbackLights, LOW);
  //        //yellowCar.Stopped_4W();
  //        speedR = 0;
  //      }
  //    }
  //    writeServo(angle);
  //    if(millis()-lastTimeSPEED>30)////
  //    {     
  //      realRobotSpeed = getSpeed();                                                                                                                                                                                                                                           
  //      //Serial.println(realRobotSpeed);
  //      moveRobot(speedR);
  //      lastTimeSPEED = millis();
  //    }
  //  
  //    
  //  }

  //  writeServo(-90);
  //  delay(5000);
  //  writeServo(0);
  //  delay(5000);
  //  writeServo(90);
  //  delay(5000);

  Serial.println("AUTO");

  //    while(1)
  //    {
  //      if (irrecv.decode(&results))   
  //      {   
  //        ir_command = results.value;
  //        //SaveEEPROM(results.value);   
  //        Serial.println(ir_command);
  //        irrecv.resume(); 
  //        if(ir_command==1) { 
  //          ledSwitch(HIGH);
  //        }
  //        if(ir_command==2) { 
  //          ledSwitch(LOW); 
  //          break; 
  //        }
  //
  //      }
  //    }

  while(1)
  {
    ////////////////////////////////
    //MEDIAN FILTER
    //TODO delta
    if(marker_sensor_is_ready[SLEFT])
    {
      sen_left[0] = sen_left[1];
      sen_left[1] = sen_left[2];
      sen_left[2] =  sen_data[SLEFT];
      med_left = median_of_3(sen_left[0],sen_left[1],sen_left[2]);// тут медианный фильтр
      marker_sensor_is_ready[SLEFT] = 0;
    }
    if(marker_sensor_is_ready[SRIGHT])
    {
      sen_right[0] = sen_right[1];
      sen_right[1] = sen_right[2];
      sen_right[2] =  sen_data[SRIGHT];
      med_right = median_of_3(sen_right[0],sen_right[1],sen_right[2]);// тут медианный фильтр
      marker_sensor_is_ready[SRIGHT] = 0;
    }
    if(marker_sensor_is_ready[SLEFTCENTER])
    {
      sen_leftcenter[0] = sen_leftcenter[1];
      sen_leftcenter[1] = sen_leftcenter[2];
      sen_leftcenter[2] =  sen_data[SLEFTCENTER];
      med_leftcenter = median_of_3(sen_leftcenter[0],sen_leftcenter[1],sen_leftcenter[2]);// тут медианный фильтр
      marker_sensor_is_ready[SLEFTCENTER] = 0;
    }

    if(marker_sensor_is_ready[SRIGHTCENTER])
    {
      sen_rightcenter[0] = sen_rightcenter[1];
      sen_rightcenter[1] = sen_rightcenter[2];
      sen_rightcenter[2] =  sen_data[SRIGHTCENTER];
      med_rightcenter = median_of_3(sen_rightcenter[0],sen_rightcenter[1],sen_rightcenter[2]);// тут медианный фильтр
      marker_sensor_is_ready[SRIGHTCENTER] = 0;
    }
    ///////////////////////////////////////////////////////////////////



    switch(mod)
    {
    case 0:
      // right wall
      if((med_rightcenter<100)&&(med_right<70)) {
        angle = -50*(double)( med_rightcenter) ;
      }
      else {
        if(med_rightcenter<100)  angle = 350*(double)( med_right-30)/(double)(30 + med_right) ;
        else angle = 50*(double)( med_right-30)/(double)(30 + med_right) ;
      }
      //speed
      if(  (med_rightcenter>120)&&(abs(angle)<15))
      {
        speedR = 10;//10
      }
      else
      {
        if (realRobotSpeed>20)
          speedR = -64;
        else if(realRobotSpeed > 6)
          speedR = 0;
        else 
          speedR = 1;
      }
      break;
    case 1:
      //left wall
      if((med_leftcenter<100)&&(med_left<70)) {
        angle = 50*(double)( med_leftcenter) ;
      }
      else {
        if(med_leftcenter<100)  angle = 350*(double)( -med_left+30)/(double)(30 + med_left) ;
        else angle = 50*(double)( -med_left+30)/(double)(30 + med_left) ;
      }
      //speed
      if(  (med_leftcenter>120)&&(abs(angle)<15))
      {
        speedR = 10;//10
      }
      else
      {
        if (realRobotSpeed>20)
          speedR = -64;
        else if(realRobotSpeed > 6)
          speedR = 0;
        else 
          speedR = 1;
      }
      break;
    case 2:
      //center
      //if((med_leftcenter+med_rightcenter)>250)
      if((med_rightcenter>130)||(med_leftcenter>130)) {
        angle = 50*(double)( med_right-med_left)/(double)(med_left + med_right);
        speedR = 50;//10
      }
      else {
        angle = 200*(double)( med_right-med_left)/(double)(med_left + med_right);
        if (realRobotSpeed>15) //20
          speedR = -64;
        else if(realRobotSpeed > 10)
          speedR = 0;   
        else 
          speedR = 10;//1
      }
      break;        
    }


    /////////////////////////////////////////////////////////////////////////
    //BUMP 
    if (bump(4)) angle =  SERVO_MAX_ANGLE;
    if (bump(5)) angle = -SERVO_MAX_ANGLE;

    if((isBumpk>12)||bump(4)||bump(5)) // time? bump(4)||bump(5)||0   12
    {
      if(k>300)// 50
      {
        back();
        writeServo(0);
        if(bump(4)||bump(5)){
          writeServo(-angle);
          delay(400);
        }
        if(isBumpk>7){ 
          delay(400);
        }        
        delay(10);
        isBumpk = 0;
        speedR = 1;
        k = 0;
        moveRobot(10);
      }
      else
      {
        k++;
      }
    }
    else
    {
      k = 0;
    }
    ///////////////////////////////////////////////////////
    // Speed and servo
    // speed table 
    // set value  ----- real speed -- break speed
    // 1                6             3
    // 10               10            4
    // 20               16            6

    writeServo(angle);
    if(millis()-lastTimeSPEED>30) {     
      realRobotSpeed = getSpeed();                                                                                                                                                                                                                                           
      //Serial.println(realRobotSpeed);
      moveRobot(speedR);
      lastTimeSPEED = millis();
      if(speedR) {
        if(realRobotSpeed<=((speedR/2<=3)?3:speedR/2)) { 
          isBumpk++; 
        }
        else { 
          isBumpk = 0; 
        }
      }      
    }
    ////////////////////////////////////////////////////////
    // BATTERY
    if(get_voltage(6)<11500) {
      voltageCount++;
      if (voltageCount>100) ledSwitch(HIGH);
    }
    else voltageCount = 0;

    ////////////////////////////////////////////////////////
    // display data
    //    Serial.print( med_left,DEC); 
    //    Serial.print("  ");
    //    Serial.print( med_leftcenter,DEC);
    //    Serial.print("  ");
    //    Serial.print( med_rightcenter,DEC);
    //    Serial.print("  ");
    //    Serial.print( med_right,DEC);
    //    Serial.print("  ");
    //    Serial.print(speedR);
    //    Serial.print("  ");
    //    Serial.println(angle);
    //    delay(10);





  }

}
































































