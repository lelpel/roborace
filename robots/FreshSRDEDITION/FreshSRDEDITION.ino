#include <Arduino.h>
#include <avr/io.h>
#include <avr/interrupt.h>
#include "ADC.h"
#include "setup.h"
#include <IRremote.h>
#include "config.h"
#include "motor.h"
#include "PWMServo.h"
#include <Servo.h>
#include "sensors.h"



char command = 'S';
char prevCommand = 'A';
int velocity = 0;   
unsigned long timer0 = 2000;  //Stores the time (in millis since execution started) 
unsigned long timer1 = 0;  //Stores the time when the last command was received from the phone








/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
double mapdouble(double x, double in_min, double in_max, double out_min, double out_max)
{
  return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}


void setup()
{

  analogReference(DEFAULT); //analog init  
  ADC_setup();
  //speedInit();
  setupMotorServo();
  //setupIrrecv();

  //button init (set pul-up resistor)
  pinMode(BUTTON, INPUT);
  digitalWrite(BUTTON,HIGH);

  //init serial
  Serial.begin(SERIAL_SPEED);

  // say START
  Serial.println("\nStart");

}
//VARIABLEAS

int sen_min_val = 20;
int sen_max_val = 150;

int angle = 0;
int speedR = 0;

unsigned char sen_left[3];
unsigned char med_left;
unsigned char sen_center[3];
unsigned char med_center;
unsigned char sen_right[3];
unsigned char med_right;

int k = 0;

unsigned long ir_command;

void loop()
{ 
while(1)
  {  
//    writeServo(0);
    
    writeServo(SERVO_MAX_ANGLE);
    delay(2000);
    writeServo(0);
    delay(2000);
    writeServo(-SERVO_MAX_ANGLE);
    delay(2000);
  }
  /*
  while(1)
  {    
    if(Serial.available() > 0){ 
      timer1 = millis();   
      prevCommand = command;
      command = Serial.read(); 
      //Change pin mode only if new command is different from previous.   
      if(command!=prevCommand){
        //Serial.println(command);
        switch(command){
        case 'F':
          forward(velocity); 
          angle = 0; 
          //yellowCar.Forward_4W(velocity);
          break;
        case 'B':  
          //yellowCar.Back_4W(velocity);
          angle = 0;
          back(velocity);
          delay(500);
          break;
        case 'L':  
          //yellowCar.Left_4W();
          angle = -SERVO_MAX_ANGLE;
          break;
        case 'R':
          angle = SERVO_MAX_ANGLE;
          //yellowCar.Right_4W();  
          break;
        case 'S': 
          forward(0);
          angle = 0;
          //yellowCar.Stopped_4W();
          break; 
        case 'I':  //FR  
          forward(velocity);
          angle = SERVO_MAX_ANGLE;
          //yellowCar.ForwardRight_4W(velocity);
          break; 
        case 'J':  //BR  
          angle = SERVO_MAX_ANGLE;
          back(velocity);
          //yellowCar.BackRight_4W(velocity);
          break;        
        case 'G':  //FL 
          forward(velocity);
          angle = -SERVO_MAX_ANGLE; 
          //yellowCar.ForwardLeft_4W(velocity);
          break; 
        case 'H':  //BL
          angle = -SERVO_MAX_ANGLE;
          back(velocity);
          //yellowCar.BackLeft_4W(velocity);
          break;
        case 'W':  //Font ON 
          //digitalWrite(pinfrontLights, HIGH);
          break;
        case 'w':  //Font OFF
          //digitalWrite(pinfrontLights, LOW);
          break;
        case 'U':  //Back ON 
          //digitalWrite(pinbackLights, HIGH);
          break;
        case 'u':  //Back OFF 
          //digitalWrite(pinbackLights, LOW);
          break; 
        case 'D':  //Everything OFF 
          //digitalWrite(pinfrontLights, LOW);
          //digitalWrite(pinbackLights, LOW);
          //yellowCar.Stopped_4W();
          break;         
        default:  //Get velocity
          if(command=='q'){
            velocity = 255;  //Full velocity
          }
          else{ 
            //Chars '0' - '9' have an integer equivalence of 48 - 57, accordingly.
            if((command >= 48) && (command <= 57)){ 
              //Subtracting 48 changes the range from 48-57 to 0-9.
              //Multiplying by 25 changes the range from 0-9 to 0-225.
              velocity = (command - 48)*25;       
            }
          }
        }
      }
    }
    else{
      timer0 = millis();  //Get the current time (millis since execution started).
      //Check if it has been 500ms since we received last command.
      if((timer0 - timer1)>500){        
        speedR = 0;
      }
    }
    writeServo(angle);

  }

*/



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
      if(marker_sensor_is_ready[SCENTER])
      {
        sen_center[0] = sen_center[1];
        sen_center[1] = sen_center[2];
        sen_center[2] =  sen_data[SCENTER];
        med_center = median_of_3(sen_center[0],sen_center[1],sen_center[2]);// тут медианный фильтр
        marker_sensor_is_ready[SCENTER] = 0;
      }
  
  
   if(med_center>140)
    {
      writeServo( (int)
      (mapdouble(
                ((double)(  (double)(-med_left+med_right) /  (double)(med_left+med_right)  )),
                -1,
                1,
                -SERVO_MAX_ANGLE,
                SERVO_MAX_ANGLE
                )
                /2));
    }
    else
    {
      writeServo( (int)
      (mapdouble(
                ((double)(  (double)(-med_left+med_right) /  (double)(med_left+med_right)  )),
                -1,
                1,
                -SERVO_MAX_ANGLE,
                SERVO_MAX_ANGLE
                )
                *30));
    }  
    
      speedR = map (med_center,20,150,70,170);
      forward(speedR);
  
  
      /////////////////////////////////////////////////////////////////////////
      //BUMP 
      if((med_center<31)) // time?
      {
        if(k>300)////////////////10//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        {
          if(med_left>med_right)
          {
            mLeft();
            k = 0;
          }
          else
          {
            mRight();
            k = 0;
          }
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
//   Speed and servo

  ////////////////////////////////////////////////////////
//   display data
//      Serial.print( med_left,DEC); 
//      Serial.print("  ");
  //    Serial.print( med_center,DEC);
  //    Serial.print("  ");
  //    Serial.print( med_right,DEC);
  //    Serial.print("  ");
  //    Serial.print(speedR);
  //    Serial.print("  ");
  //    Serial.println(angle);
  //    delay(10);


    }

}






void mLeft(void)
{

  neutral();
  delay(50);

  writeServo(SERVO_MAX_ANGLE);
  delay(120);
  back(170);
  delay(550);//320
  neutral();
  writeServo(-SERVO_MAX_ANGLE);
  delay(100);
  forward(200);
  delay(100); 


}
void mRight(void)
{
  neutral();
  delay(50);
  writeServo(-SERVO_MAX_ANGLE);
  delay(120);
  back(150);
  delay(320);
  neutral();
  writeServo(SERVO_MAX_ANGLE);
  delay(100);
  forward(200);  
  delay(100); 
}















































